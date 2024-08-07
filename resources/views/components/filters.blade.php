@props([
    'count' => 0,
    'actions' => null,
])

<section x-data="{ open: false }" x-on:click.outside="open=false"
         aria-labelledby="filter-heading" class="flex justify-between items-center relative"
        {{ $attributes->merge(['class' => 'relative z-10 grid items-center']) }}>
    <div class="relative col-start-1 row-start-1">
        <div class="flex space-x-2 divide-x divide-secondary-500">
            <div class="flex">
                <x-button @click="open = !open" label="Фильтры: {{ $count }}"
                          flat icon="funnel"
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
    <div x-show="open" x-cloak class="absolute top-[45px] bg-white dark:bg-secondary-800 w-full p-4 z-20 dark:shadow-xl shadow-[0_10px_10px_-15px_rgba(0,0,0,0.3)]">
        <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-12 gap-x-4 text-sm md:gap-x-6 gap-y-2 md:gap-y-4">
            {{ $slot }}
        </div>
    </div>

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
