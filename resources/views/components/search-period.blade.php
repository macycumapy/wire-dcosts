@props([
    'periodName' => 'searchPeriod',
    'dateFromName' => 'searchDateFrom',
    'dateToName' => 'searchDateTo',
])

<div class="sm:col-span-3">
    <x-select
        wire:model.live="searchPeriod"
        :options="\App\Enums\Period::valuesWithTitles()"
        option-label="title"
        option-value="value"
        option-description="-"
        autocomplete="off" autocorrect="off"
        :clearable="false"
    ></x-select>
</div>
@if(in_array($this->$periodName, [\App\Enums\Period::Custom->value, \App\Enums\Period::Custom]))
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
@endif
