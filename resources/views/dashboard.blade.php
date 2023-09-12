<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <x-select
                    :async-data="route('nomenclature-type.search')"
                    option-label="name"
                    option-value="id"
                    option-description="-"
                    autocomplete="off" autocorrect="off"
                >
                    <x-slot name="emptyMessage">
                        @livewire('nomenclature-type.nomenclature-type-modal')
                    </x-slot>
                </x-select>
            </x-card>
        </div>
    </div>
</x-app-layout>
