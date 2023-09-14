<div>
    <div x-data class="min-w-full divide-y divide-gray-500">
        <div class="grid grid-cols-4 p-4 font-semibold gap-4 sticky top-0 bg-gray-800">
            <div>Дата</div>
            <div>Сумма</div>
            <div>Категория</div>
            <div></div>
        </div>
        <div class="divide-y divide-gray-500 h-[55vh] sm:h-[60vh] overflow-auto soft-scrollbar">
            @forelse($items as $key => $cashFlow)
                <div wire:key="row_{{ $cashFlow->id }}">
                    <div class="p-4 grid grid-cols-3 sm:grid-cols-4 gap-4">
                        <div>
                            {{ $cashFlow->date->isToday() ? 'Сегодня' : $cashFlow->date->format('d.m.Y H:i') }}
                        </div>
                        <div class="text-{{ $cashFlow->type->color() }}-600">
                            {{ number_format($cashFlow->sum, 2, '.', ' ') }}
                        </div>
                        <div>
                            {{ $cashFlow->category?->name }}
                        </div>
                        <div class="col-span-3 sm:col-span-1 flex justify-end">
                            @if($cashFlow->type === \App\Enums\CashFlowType::Inflow)
                                <x-button
                                    flat
                                    wire:navigate
                                    href="{{ route('inflows.edit', ['id' => $cashFlow->id, 'clone' => true]) }}"
                                    icon="document-duplicate"
                                ></x-button>
                                <x-button
                                    flat
                                    wire:navigate
                                    href="{{ route('inflows.edit', ['id' => $cashFlow->id]) }}"
                                    icon="pencil-alt"
                                ></x-button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6">
                    Список пуст
                </div>
            @endforelse
        </div>
    </div>
    <div class="pb-4">
        {{ $items->links() }}
    </div>
</div>
