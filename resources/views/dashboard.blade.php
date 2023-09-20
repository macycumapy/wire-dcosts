<x-app-layout>
    <div class="p-2 sm:py-12 sm:p-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card card-classes="h-full sm:h-[81vh]">
                @livewire('cash-flow.cash-flow-list')
                <div class="flex justify-end space-x-4">
                    <x-button
                        primary
                        wire:navigate
                        href="{{ route('inflows.create') }}"
                        icon="plus"
                        label="Поступление"
                        class="w-full sm:w-40"
                    ></x-button>

                    <x-button
                        primary
                        wire:navigate
                        href="{{ route('outflows.create') }}"
                        icon="plus"
                        label="Расход"
                        class="w-full sm:w-40"
                    ></x-button>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
