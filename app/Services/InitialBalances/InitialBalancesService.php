<?php

declare(strict_types=1);

namespace App\Services\InitialBalances;

use App\Actions\CashFlow\CreateCashFlowAction;
use App\Actions\CashFlow\Data\CashFlowData;
use App\Actions\CashFlow\Outflow\CreateCashOutflowAction;
use App\Actions\CashFlow\Outflow\Data\CashOutflowData;
use App\Actions\CashOutflowItem\Data\OutflowItemData;
use App\Actions\Category\CreateCategoryAction;
use App\Actions\Category\Data\CategoryData;
use App\Actions\Nomenclature\CreateNomenclatureAction;
use App\Actions\Nomenclature\Data\NomenclatureData;
use App\Actions\NomenclatureType\CreateNomenclatureTypeAction;
use App\Actions\NomenclatureType\Data\NomenclatureTypeData;
use App\Actions\Partner\CreatePartnerAction;
use App\Actions\Partner\Data\PartnerData;
use App\Enums\CashFlowType;
use App\Models\Category;
use App\Models\Nomenclature;
use App\Models\NomenclatureType;
use App\Models\Partner;
use App\Services\InitialBalances\Data\OutflowData;
use App\Services\InitialBalances\Data\OutflowDetailsData;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

readonly class InitialBalancesService
{
    public function __construct(
        private CreatePartnerAction          $createPartnerAction,
        private CreateCategoryAction         $createCategoryAction,
        private CreateCashFlowAction         $createCashFlowAction,
        private CreateCashOutflowAction      $createCashOutflowAction,
        private CreateNomenclatureAction     $createNomenclatureAction,
        private CreateNomenclatureTypeAction $createNomenclatureTypeAction,
        private InflowsXlsxParser            $inflowsXlsxParser,
        private OutflowXlsxParser            $outflowXlsxParser,
    ) {
    }

    public function uploadInflows(UploadedFile $file): Collection
    {
        $inflowsData = $this->inflowsXlsxParser->parse($file->get());

        return DB::transaction(function () use ($inflowsData) {
            return collect($inflowsData)->map(function ($inflow) {
                /** @var Partner $partner */
                $partner = Partner::firstWhere('name', $inflow->partnerName);
                if (!$partner && !empty($inflow->partnerName)) {
                    $partner = $this->createPartnerAction->exec(PartnerData::from([
                        'name' => $inflow->partnerName,
                        'user_id' => Auth::id(),
                    ]));
                }

                /** @var Category $category */
                $category = Category::where('type', CashFlowType::Inflow)->firstWhere('name', $inflow->categoryName);
                if (!$category) {
                    $category = $this->createCategoryAction->exec(CategoryData::from([
                        'name' => $inflow->categoryName,
                        'type' => CashFlowType::Inflow,
                        'user_id' => Auth::id(),
                    ]));
                }

                return $this->createCashFlowAction->exec(CashFlowData::from([
                    'user_id' => Auth::id(),
                    'partner_id' => $partner?->id,
                    'category_id' => $category->id,
                    'date' => $inflow->date,
                    'sum' => $inflow->sum,
                    'type' => CashFlowType::Inflow,
                    'account_id' => Auth::user()->accounts->first()?->id,
                ]));
            });
        });
    }

    public function uploadOutflows(UploadedFile $file): Collection
    {
        ini_set('max_execution_time', 60 * 5);
        $outflowData = $this->outflowXlsxParser->parse($file->get());

        return DB::transaction(function () use ($outflowData) {
            return collect($outflowData)->map(function (OutflowData $outflow) {
                /** @var Category $category */
                $category = Category::where('type', CashFlowType::Outflow)->firstWhere('name', $outflow->categoryName);
                if (!$category) {
                    $category = $this->createCategoryAction->exec(CategoryData::from([
                        'name' => $outflow->categoryName,
                        'type' => CashFlowType::Outflow,
                        'user_id' => Auth::id(),
                    ]));
                }

                return $this->createCashOutflowAction->exec(CashOutflowData::from([
                    'user_id' => Auth::id(),
                    'category_id' => $category->id,
                    'date' => $outflow->date,
                    'sum' => $outflow->sum,
                    'account_id' => Auth::user()->accounts->first()?->id,
                    'details' => $outflow->details
                        ->map(function (OutflowDetailsData $details) {
                            /** @var NomenclatureType $nomenclatureType */
                            $nomenclatureType = NomenclatureType::firstWhere('name', $details->nomenclatureType);
                            if (!$nomenclatureType && !empty($details->nomenclatureType)) {
                                $nomenclatureType = $this->createNomenclatureTypeAction->exec(NomenclatureTypeData::from([
                                    'name' => $details->nomenclatureType,
                                    'user_id' => Auth::id(),
                                ]));
                            }

                            /** @var Nomenclature $nomenclature */
                            $nomenclature = Nomenclature::firstWhere('name', $details->nomenclatureName);
                            if (!$nomenclature) {
                                $nomenclature = $this->createNomenclatureAction->exec(NomenclatureData::from([
                                    'name' => $details->nomenclatureName,
                                    'user_id' => Auth::id(),
                                    'nomenclature_type_id' => $nomenclatureType?->id,
                                ]));
                            }

                            return OutflowItemData::from([
                                'count' => $details->count,
                                'cost' => $details->cost,
                                'nomenclature_id' => $nomenclature->id,
                            ]);
                        })
                ]));
            });
        });
    }
}
