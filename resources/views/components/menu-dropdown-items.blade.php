@props([
'reports' => [],
])

<div class="p-2">
    @livewire('widget.theme-widget')
</div>

<hr class="my-1 dark:border-secondary-600">

<x-dropdown.header label="Журналы">
    <x-dropdown.item
        wire:navigate
        href="{{ route('account-cash-transfers.list') }}"
        label="Переводы между счетами"
    />
</x-dropdown.header>

<hr class="my-1 dark:border-secondary-600">

<x-dropdown.header label="Справочники">
    <x-dropdown.item
        wire:navigate
        href="{{ route('accounts.list') }}"
        label="Счета"
    />
</x-dropdown.header>

<hr class="my-1 dark:border-secondary-600">

<x-dropdown.header label="Отчеты">
    <x-dropdown.item
        wire:navigate
        href="{{ route('report.inflows') }}"
        label="Отчет о поступлениях"
    ></x-dropdown.item>

    <x-dropdown.item
        wire:navigate
        href="{{ route('report.outflows') }}"
        label="Отчет о затратах"
    ></x-dropdown.item>

    <x-dropdown.item
        wire:navigate
        href="{{ route('report.summary-flows') }}"
        label="Сводный отчет"
    ></x-dropdown.item>
</x-dropdown.header>

<x-dropdown.item separator>
    <form method="POST" action="{{ route('logout') }}" x-data>
        @csrf
        <div class="flex" @click.prevent="$root.submit();">
            <x-icon name="arrow-left-start-on-rectangle" class="w-4 h-4"></x-icon>
            <span class="ml-4 my-auto">{{ __('Log Out') }}</span>
        </div>
    </form>
</x-dropdown.item>
