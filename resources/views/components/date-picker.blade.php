@props([
    'max' => null,
    'min' => null,
    'clearable' => true,
    'name' => null,
    'disabled' => false,
])

<div
    x-data="{
        value: @entangle($attributes->wire('model')),
        clearable: @boolean($clearable),
        max: @toJs($max),
        min: @toJs($min)
    }"
    x-on:change="value = $event.target.value"
    x-init="
        new Pikaday({
            field: $refs.input,
            format: 'DD.MM.YYYY',
            firstDay: 1,
            yearRange: 100,
            minDate: min ? new Date(moment(min, 'DD.MM.YYYY')) : null,
            maxDate: max ? new Date(moment(max, 'DD.MM.YYYY')) : null,
            i18n: {
                previousMonth : 'Предыдущий месяц',
                nextMonth     : 'Следующий месяц',
                months        : ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                weekdays      : ['Воскресенье', 'Понедельник','Вторник','Среда','Четверг','Пятница','Суббота'],
                weekdaysShort : ['Вс','Пн','Вт','Ср','Чт','Пт','Сб']
            },
            toString(date, format) {
               return moment(date).format(format);
            }
        });"
>
    <x-input
        {{ $attributes->whereDoesntStartWith('wire:model') }}
        x-ref="input"
        x-bind:value="value"
        readonly
        type="text"
        :name="$name ?? $attributes->wire('model')->value"
        :disabled="$disabled"
    >
        <x-slot name="append">
            <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center gap-3 text-gray-400 pointer-events-none">
                @if ($clearable && !$disabled)
                    <x-icon name="x-mark"
                            x-show="value"
                            x-on:click="value = null"
                            class="w-4 h-4 hover:text-rose-700 cursor-pointer pointer-events-auto"
                            x-cloak
                    ></x-icon>
                @endif
                <x-icon name="calendar" class="h-5 w-5"></x-icon>
            </div>
        </x-slot>
    </x-input>
</div>
