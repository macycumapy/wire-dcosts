<?php

declare(strict_types=1);

namespace App\WireUI;

class Button extends \WireUi\View\Components\Button
{
    public function defaultColors(): array
    {
        return array_merge(parent::defaultColors(), [
            'emerald' => <<<EOT
                ring-emerald-800 text-white bg-emerald-800 hover:bg-emerald-700 hover:ring-emerald-700
            EOT,
            'primary' => <<<EOT
                ring-emerald-800 text-white bg-emerald-800 hover:bg-emerald-700 hover:ring-emerald-700
            EOT,
            'gray' => <<<EOT
                focus:ring-gray-200 text-gray-900 bg-gray-100 hover:bg-gray-200
            EOT,
            'white' => <<<EOT
                bg-white border text-gray-700 hover:bg-slate-50 ring-slate-200
            EOT,
        ]);
    }
}
