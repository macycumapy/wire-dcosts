<div class="max-w-7xl sm:mx-auto sm:p-4 p-2">
    <x-card card-classes="h-full" padding="sm:p-4 p-2">
        <div class="min-w-full">
            <div id="list" class="min-h-[60vh] divide-y divide-gray-500">
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
            <div class="flex justify-between items-center sticky bottom-0 bg-white dark:bg-secondary-800 p-2">
                <div>Итого: {{ number_format($sum ?? 0, 2, '.', ' ') }} </div>
                <x-button
                    secondary
                    wire:navigate
                    :href="\Illuminate\Support\Facades\URL::previous()"
                    label="Назад"
                ></x-button>
            </div>
        </div>
    </x-card>
</div>
