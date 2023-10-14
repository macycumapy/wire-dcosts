@props([
    'count' => 0,
    'actions' => null,
])

<section x-data="{ open: false }" aria-labelledby="filter-heading" class="flex justify-between items-center relative"
        {{ $attributes->merge(['class' => 'relative z-10 grid items-center']) }}>
    <div class="relative col-start-1 row-start-1">
        <div class="flex space-x-2 divide-x divide-gray-500">
            <div class="flex">
                <x-button @click="open = !open" label="Фильтры: {{ $count }}"
                          flat icon="filter"
                          class="group font-medium text-xs flex items-center {{ $count ? '!text-orange-700' : 'text-gray-700' }}">
                </x-button>
            </div>
            @if($count)
                <div class="flex pl-2">
                    <x-button wire:click="resetFilters()" flat xs label="Очистить"></x-button>
                </div>
            @endif
        </div>
    </div>
    <template x-if="open">
        <div class="absolute -bottom-[175px] sm:-bottom-[75px] bg-gray-800 w-full border-b-2 border-emerald-800 p-4 z-20">
            <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-12 gap-x-4 text-sm md:gap-x-6 gap-y-2 md:gap-y-4">
                {{ $slot }}
            </div>
        </div>
    </template>

    @isset($actions)
        <div class="py-2">
            <div class="flex sm:justify-end">
                <div class="relative inline-block">
                    {{ $actions }}
                </div>
            </div>
        </div>
    @endisset
</section>
