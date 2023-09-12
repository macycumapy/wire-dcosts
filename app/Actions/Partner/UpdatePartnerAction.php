<?php

declare(strict_types=1);

namespace App\Actions\Partner;

use App\Actions\Partner\Data\UpdatePartnerData;

class UpdatePartnerAction
{
    public function exec(UpdatePartnerData $data): bool
    {
        $partner = $data->partner;
        $partner->name = $data->name;

        return $partner->save();
    }
}
