<?php

declare(strict_types=1);

namespace App\Livewire\Partner;

use App\Actions\Partner\CreatePartnerAction;
use App\Actions\Partner\Data\PartnerData;
use App\Actions\Partner\Data\UpdatePartnerData;
use App\Actions\Partner\UpdatePartnerAction;
use App\Models\Partner;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class PartnerForm extends Component
{
    use WireUiActions;

    public const PARTNER_SAVED_EVENT = 'partner-saved';
    public ?Partner $partner = null;
    public ?string $name = null;
    public PartnerData $data;

    public function mount(?int $id = null): void
    {
        if ($id) {
            $this->partner = Partner::findOrFail($id);
            $this->data = PartnerData::from($this->partner);
        } else {
            $this->resetData();
        }
    }

    private function resetData(): void
    {
        $this->data = PartnerData::from([
            'user_id' => Auth::id(),
            'name' => $this->name,
        ]);
    }

    public function create(CreatePartnerAction $action): void
    {
        $partner = $action->exec(PartnerData::validateAndCreate($this->data));
        $this->dispatch(self::PARTNER_SAVED_EVENT, $partner->id);
        $this->notification()->success('Контрагент', 'Добавлен');
        $this->resetData();
    }

    public function update(UpdatePartnerAction $action): void
    {
        $action->exec(UpdatePartnerData::validateAndCreate([
            ...$this->data->toArray(),
            'partner' => $this->partner,
        ]));
        $this->dispatch(self::PARTNER_SAVED_EVENT, $this->partner->id);
        $this->notification()->success('Контрагент', 'Изменен');
    }

    public function render(): View
    {
        return view('livewire.partner.partner-form');
    }
}
