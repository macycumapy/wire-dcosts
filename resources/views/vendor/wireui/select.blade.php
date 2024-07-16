<x-dynamic-component
    :component="WireUi::component('text-field')"
    x-ref="container"
    :data="$wrapperData"
    :attributes="$attrs->class([
        'cursor-pointer' => !$disabled && !$readonly,
    ])"
    x-data="wireui_select"
    :x-props="WireUi::toJs([
        'asyncData'         => $asyncData,
        'optionValue'       => $optionValue,
        'optionLabel'       => $optionLabel,
        'optionDescription' => $optionDescription,
        'hasSlot'           => $slot->isNotEmpty(),
        'multiselect'       => $multiselect,
        'searchable'        => $searchable,
        'clearable'         => $clearable,
        'readonly'          => $readonly || $disabled,
        'placeholder'       => $placeholder,
        'template'          => $template,
        'wireModel'         => WireUi::wireModel(isset($__livewire) ? $this : null, $attributes),
        'alpineModel'       => WireUi::alpineModel($attributes),
    ])"
    x-bind:class="{
        'ring-2 ring-primary-600': positionable.isOpen(),
    }"
    x-on:click="toggle"
    x-on:keydown.enter.stop.prevent="toggle"
    x-on:keydown.space.stop.prevent="toggle"
    x-on:keydown.arrow-down.prevent="positionable.open()"
    tabindex="0"
>
    <div class="hidden" hidden>
        <div hidden x-ref="json">{{ WireUi::toJs($optionsToArray()) }}</div>
        <div hidden x-ref="slot">{{ $slot }}</div>

        <x-wireui-wrapper::element
            :id="$id"
            :name="$name"
            :value="$value"
            x-bind:value="getSelectedValue"
            x-ref="input"
            type="hidden"
        />

        @if (app()->runningUnitTests())
            <div dusk="select.{{ $name }}">
                {!! json_encode($optionsToArray()) !!}
            </div>
        @endif
    </div>

    @include('wireui-wrapper::components.slots', [
        'except' => ['append', 'label', 'beforeOptions', 'afterOptions'],
    ])

    @if ($label)
        <x-slot:label class="cursor-pointer select-none" x-on:click="toggle">
            {{ $label }}
        </x-slot:label>
    @endif

    <button
        type="button"
        class="w-full truncate flex items-center outline-0 border-0"
        tabindex="-1"
    >
        <span
            class="select-none text-gray-400 invalidated:text-negative-400 invalidated:dark:text-negative-400 text-sm truncate"
            x-show="isEmpty()"
            x-text="getPlaceholder"
        ></span>

        <span
            class="
                text-sm truncate text-secondary-600 dark:text-secondary-400
                invalidated:text-negative-500 invalidated:dark:text-negative-400
            "
            x-show="!config.multiselect && isNotEmpty()"
            x-html="getSelectedDisplayText()"
        ></span>

        <div
            @class([
                'w-full flex items-center overflow-hidden',
                'cursor-pointer' => !$readonly && !$disabled
            ])
            x-show="config.multiselect && isNotEmpty()"
        >
            <div class="flex items-center gap-2 overflow-x-auto hide-scrollbar w-full">
                @unless ($withoutItemsCount)
                    <span
                        class="inline-flex text-sm text-secondary-700 dark:text-secondary-400 select-none"
                        x-show="selectedOptions.length"
                        x-text="selectedOptions.length"
                    ></span>
                @endunless

                <div class="flex items-center gap-1 flex-nowrap">
                    <template x-for="(option, index) in selectedOptions" :key="`selected.${index}`">
                        <span @class([
                            'inline-flex items-center py-0.5 pl-2 pr-0.5 rounded-full text-xs font-medium',
                            'border border-secondary-200 shadow-sm bg-secondary-100 text-secondary-700',
                            'dark:bg-secondary-700 dark:text-secondary-400 dark:border-none',
                        ])>
                            <span style="max-width: 5rem" class="truncate select-none" x-text="option.label"></span>

                            @if ($clearable && !($readonly || $disabled))
                                <button
                                    class="flex items-center justify-center w-4 h-4 shrink-0 text-secondary-400 hover:text-secondary-500"
                                    x-on:click.stop="unSelect(option)"
                                    tabindex="-1"
                                    type="button"
                                >
                                    <x-dynamic-component
                                        :component="WireUi::component('icon')"
                                        class="w-3 h-3"
                                        name="x-mark"
                                    />
                                </button>
                            @endif
                        </span>
                    </template>
                </div>
            </div>
        </div>
    </button>

    <x-slot name="append" class="flex items-center pr-2.5 gap-x-1">
        @if ($clearable && !$readonly && !$disabled)
            <button
                x-show="isNotEmpty()"
                x-on:click.stop="clear"
                tabindex="-1"
                type="button"
                x-cloak
            >
                <x-dynamic-component
                    :component="WireUi::component('icon')"
                    @class([
                        'w-4 h-4 text-secondary-400 hover:text-negative-400',
                        'invalidated:text-negative-400 invalidated:dark:text-negative-500',
                    ])
                    name="x-mark"
                />
            </button>
        @endif

        @isset($openButton)
            {{ $openButton }}
        @else
            <button tabindex="-1" type="button">
                <x-dynamic-component
                    :component="WireUi::component('icon')"
                    @class([
                        'w-5 h-5 text-secondary-400',
                        'invalidated:text-negative-400 invalidated:dark:text-negative-500',
                    ])
                    :name="$rightIcon"
                />
            </button>
        @endisset
    </x-slot>

    <x-slot:after>
        <x-dynamic-component
            :component="WireUi::component('popover')"
            :margin="(bool) $label"
            class="w-full max-h-80 select-none overflow-hidden"
            x-ref="optionsContainer"
            tabindex="-1"
            x-on:keydown.tab.prevent="$event.shiftKey || focusable.next()?.focus()"
            x-on:keydown.shift.tab.prevent="focusable.previous()?.focus()"
            x-on:keydown.arrow-up.prevent="focusable.previous()?.focus()"
            x-on:keydown.arrow-down.prevent="focusable.next()?.focus()"
        >
            <div
                class="px-2 my-2"
                wire:key="search.options.{{ $name }}"
                x-show="asyncData.api || (config.searchable && options.length >= @js($minItemsForSearch))"
            >
                <x-dynamic-component
                    :component="WireUi::component('input')"
                    x-ref="search"
                    x-model.debounce.500ms="search"
                    shadowless
                    right-icon="magnifying-glass"
                    :placeholder="trans('wireui::messages.search_here')"
                    type="search"
                />
            </div>

            <div
                class="overflow-y-auto select-none max-h-60 snap-y snap-proximity overscroll-contain soft-scrollbar"
                tabindex="-1"
                name="wireui.select.options.{{ $name }}"
            >
                <div
                    class="w-full h-0.5 rounded-full relative overflow-hidden"
                    :class="{ 'bg-gray-200 dark:bg-gray-700': asyncData.fetching }"
                >
                    <div
                        class="bg-primary-500 h-0.5 rounded-full absolute animate-linear-progress"
                        style="width: 30%"
                        x-show="asyncData.fetching"
                    ></div>
                </div>

                @isset ($beforeOptions)
                    <div {{ $beforeOptions->attributes }}>
                        {{ $beforeOptions }}
                    </div>
                @endisset

                <ul x-ref="listing" wire:ignore>
                    <template x-for="(option, index) in displayOptions" :key="`${index}.${option.value}`">
                        <li tabindex="-1" :index="index"></li>
                    </template>
                </ul>

                @unless ($hideEmptyMessage)
                    <div
                        class="px-3 py-12 text-center cursor-pointer sm:py-2 sm:px-3 sm:text-left text-secondary-500"
                        x-show="displayOptions.length === 0"
                        x-on:click="search ? resetSearch() : positionable.close()"
                    >
                        {{ $emptyMessage ?? trans('wireui::messages.empty_options') }}
                    </div>
                @endunless

                @isset ($afterOptions)
                    <div {{ $afterOptions->attributes }}>
                        {{ $afterOptions }}
                    </div>
                @endisset
            </div>
        </x-dynamic-component>
    </x-slot:after>
</x-dynamic-component>
