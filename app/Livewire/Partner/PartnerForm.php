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
use WireUi\Traits\Actions;

class PartnerForm extends Component
{
    use Actions;

    public const PARTNER_SAVED_EVENT = 'partnerSaved';
    public ?Partner $partner = null;
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
        ]);
    }

    public function create(CreatePartnerAction $action): void
    {
        $action->exec(PartnerData::validateAndCreate($this->data));
        $this->dispatch(self::PARTNER_SAVED_EVENT);
        $this->notification()->success('Контрагент', 'Добавлен');
        $this->resetData();
    }

    public function update(UpdatePartnerAction $action): void
    {
        $action->exec(UpdatePartnerData::validateAndCreate([
            ...$this->data->toArray(),
            'partner' => $this->partner,
        ]));
        $this->dispatch(self::PARTNER_SAVED_EVENT);
        $this->notification()->success('Контрагент', 'Изменен');
    }

    public function render(): View
    {
        return view('livewire.partner.partner-form');
    }
}
