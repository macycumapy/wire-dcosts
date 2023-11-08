<div class="max-w-7xl sm:mx-auto sm:px-6 lg:px-8 sm:my-12 m-2">
    <x-card card-classes="h-full sm:h-[85vh]">
        <div class="min-w-full space-y-2">
            <div id="list" class="h-[65vh] sm:h-[76vh] 2k:h-[78vh] overflow-auto soft-scrollbar divide-y divide-gray-500">
                @forelse($items as $nomenclature)
                    <div class="grid grid-cols-3 p-2 gap-2">
                        <div>{{ $nomenclature->date->format('d.m.Y') }}</div>
                        <div>{{ $nomenclature->nomenclature_name }}</div>
                        <div class="min-w-[100px] text-right underline">
                            <a href="{{ route('outflows.edit', ['id' => $nomenclature->cash_flow_id]) }}" wire:navigate>
                                {{ number_format($nomenclature->sum, 2, '.', ' ') }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-6">
                        {{ \App\Livewire\Report\OutflowsReport::NO_DATA_FOUND_TEXT }}
                    </div>
                @endforelse
            </div>
            <div class="flex justify-end">
                <x-button
                    wire:navigate
                    href="{{ route('report.outflows', [
                        'date_from' => $searchDateFrom,
                        'date_to' => $searchDateTo,
                    ]) }}"
                    label="Назад"
                ></x-button>
            </div>
        </div>
    </x-card>
</div>
