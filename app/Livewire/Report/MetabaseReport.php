<?php

declare(strict_types=1);

namespace App\Livewire\Report;

use App\Models\Report;
use App\Services\Metabase\MetabaseService;
use Illuminate\View\View;
use Livewire\Component;

class MetabaseReport extends Component
{
    public string $iframeUrl;

    private MetabaseService $metabaseService;

    public function boot(MetabaseService $metabaseService): void
    {
        $this->metabaseService = $metabaseService;
    }

    public function mount(string $slug): void
    {
        $report = Report::findBySlugOrFail($slug);

        $this->iframeUrl = $this->metabaseService
            ->setObjectType($report->object_type)
            ->setObjectId($report->object_id)
            ->setParams($report->params)
            ->setTheme($report->theme)
            ->getIFrameUrl();
    }

    public function render(): View
    {
        return view('livewire.report.metabase-report');
    }
}
