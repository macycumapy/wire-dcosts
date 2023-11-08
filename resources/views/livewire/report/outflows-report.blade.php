<div class="max-w-7xl sm:mx-auto sm:px-6 lg:px-8 sm:my-12 m-2">
    <x-card card-classes="h-full sm:h-[85vh]">
        <div class="min-w-full space-y-2">
            <x-filters :count="$this->filtersCount">
                <div class="sm:col-span-3">
                    <x-date-picker
                        wire:model.live="searchDateFrom"
                        placeholder="Дата начала"
                        clearable
                    ></x-date-picker>
                </div>
                <div class="sm:col-span-3">
                    <x-date-picker
                        wire:model.live="searchDateTo"
                        placeholder="Дата окончания"
                        clearable
                    ></x-date-picker>
                </div>

                <x-slot name="actions">
                    @if($items->isNotEmpty())
                        <div x-data class="flex justify-between gap-2 items-center">
                            <div class="hidden sm:flex gap-2">
                                <x-button
                                    xs
                                    icon="minus"
                                    label="Свернуть все"
                                    @click="$dispatch('hide')"
                                ></x-button>
                                <x-button
                                    xs
                                    icon="plus"
                                    label="Развернуть все"
                                    @click="$dispatch('show')"
                                ></x-button>
                            </div>
                            <div class="flex sm:hidden gap-2">
                                <x-button.circle
                                    xs
                                    icon="minus"
                                    @click="$dispatch('hide')"
                                ></x-button.circle>
                                <x-button.circle
                                    xs
                                    icon="plus"
                                    @click="$dispatch('show')"
                                ></x-button.circle>
                            </div>
                        </div>
                    @endif
                </x-slot>
            </x-filters>
            <div id="list" class="h-[65vh] sm:h-[72vh] 2k:h-[76vh] overflow-auto soft-scrollbar divide-y divide-gray-500">
                @forelse($items as $category)
                    <div x-data="{showCategory:true}"
                         x-on:show.window="showCategory=true"
                         @hide.window="showCategory=false"
                         class="p-2 space-y-2">
                        <div class="flex justify-between items-center">
                            <div class="flex gap-2 items-center">
                                <template x-if="showCategory">
                                    <div @click="showCategory=false" class="bg-gray-500 rounded-full">
                                        <x-icon name="minus" class="w-4 h-4 cursor-pointer text-gray-900"></x-icon>
                                    </div>
                                </template>
                                <template x-if="!showCategory">
                                    <div @click="showCategory=true" class="bg-gray-500 rounded-full">
                                        <x-icon name="plus" class="w-4 h-4 cursor-pointer text-gray-900"></x-icon>
                                    </div>
                                </template>
                                {{ $category->name }}
                            </div>
                            <div class="min-w-[100px] text-right">{{ number_format($category->sum, 2, '.', ' ') }}</div>
                        </div>
                        <div x-show="showCategory" class="divide-y divide-gray-500">
                            @foreach($category->details as $type)
                                <div x-data="{showType:true}"
                                     x-on:show.window="showType=true"
                                     @hide.window="showType=false"
                                     class="p-2 space-y-2 bg-gray-700 first:rounded-t-lg last:rounded-b-lg">
                                    <div class="flex justify-between items-start">
                                        <div class="flex gap-2 items-center">
                                            <template x-if="showType">
                                                <div @click="showType=false" class="bg-gray-500 rounded-full">
                                                    <x-icon name="minus" class="w-4 h-4 cursor-pointer text-gray-900"></x-icon>
                                                </div>
                                            </template>
                                            <template x-if="!showType">
                                                <div @click="showType=true" class="bg-gray-500 rounded-full">
                                                    <x-icon name="plus" class="w-4 h-4 cursor-pointer text-gray-900"></x-icon>
                                                </div>
                                            </template>
                                            {{ $type->name }}
                                        </div>
                                        <div
                                            class="min-w-[100px] text-right">{{ number_format($type->sum, 2, '.', ' ') }}</div>
                                    </div>
                                    <div x-show="showType" class="pl-4 divide-y divide-gray-500">
                                        @foreach($type->details as $nomenclature)
                                            <div class="flex justify-between items-start bg-gray-600 p-2 first:rounded-t-lg last:rounded-b-lg">
                                                <div>{{ $nomenclature->nomenclature }}</div>
                                                <div class="min-w-[100px] text-right">
                                                    {{ number_format($nomenclature->sum, 2, '.', ' ') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="p-6">
                        {{ \App\Livewire\Report\OutflowsReport::NO_DATA_FOUND_TEXT }}
                    </div>
                @endforelse
            </div>
            @if($items->isNotEmpty())
                <div class="flex justify-between">
                    <div>Итого</div>
                    <div>
                        {{ number_format($total, 2, '.', ' ') }}
                    </div>
                </div>
            @endif
        </div>
    </x-card>
</div>
