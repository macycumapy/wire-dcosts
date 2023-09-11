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
                dark:ring-offset-slate-800 dark:bg-emerald-700 dark:ring-emerald-700
                dark:hover:bg-emerald-600 dark:hover:ring-emerald-600
            EOT,
            'primary' => <<<EOT
                ring-primary-800 text-white bg-primary-800 hover:bg-primary-700 hover:ring-primary-700
                dark:ring-offset-slate-800 dark:bg-primary-700 dark:ring-primary-700
                dark:hover:bg-primary-600 dark:hover:ring-primary-600
            EOT,
            'gray' => <<<EOT
                focus:ring-gray-200 text-gray-900 bg-gray-100 hover:bg-gray-200
                dark:ring-offset-slate-800 dark:bg-gray-700 dark:ring-gray-700
                dark:hover:bg-gray-600 dark:hover:ring-gray-600
            EOT,
            'white' => <<<EOT
                bg-white border text-gray-700 hover:bg-slate-50 ring-slate-200
            EOT,
        ]);
    }

    public function outlineColors(): array
    {
        return array_merge(parent::outlineColors(), [
            self::DEFAULT => <<<EOT
                border text-slate-500 hover:bg-slate-700 ring-slate-200 dark:ring-slate-600 dark:border-slate-500
                dark:ring-offset-slate-800 dark:text-slate-400 dark:hover:bg-slate-700
            EOT,

            'primary' => <<<EOT
                ring-primary-700 text-primary-700 border border-primary-700 hover:bg-primary-100
                dark:ring-offset-slate-800 dark:hover:bg-slate-700
            EOT,
        ]);
    }
}
