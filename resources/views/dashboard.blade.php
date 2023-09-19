<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <div class="flex justify-end space-x-4">
                    <x-button
                        primary
                        wire:navigate
                        href="{{ route('inflows.create') }}"
                        label="Добавить поступление"
                    ></x-button>

                    <x-button
                        primary
                        wire:navigate
                        href="{{ route('outflows.create') }}"
                        label="Добавить расход"
                    ></x-button>
                </div>
                @livewire('cash-flow.cash-flow-list')
            </x-card>
        </div>
    </div>
</x-app-layout>
