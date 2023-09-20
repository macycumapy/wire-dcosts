<?php

declare(strict_types=1);

namespace App\Livewire\Report;

use App\Models\Report;
use App\Services\Metabase\MetabaseService;
use Illuminate\View\View;
use Livewire\Component;

class FlowsReport extends Component
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
            ->setQuestionId($report->question_id)
            ->setParams($report->params)
            ->getIFrameUrl();
    }

    public function render(): View
    {
        return view('livewire.report.flows-report');
    }
}
