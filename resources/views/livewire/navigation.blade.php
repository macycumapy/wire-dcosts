<nav x-data="{ open: false }" class="bg-secondary-800 border-b border-secondary-800">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a wire:navigate href="{{ route('dashboard') }}">
                        <img src="/images/logo.png" class="w-10 h-10">
                    </a>
                </div>
            </div>

            <div class="flex items-center text-primary-700 font-semibold">
                @livewire('widget.balances-widget')
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <x-button primary outline>
                                    {{ Auth::user()->name }}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </x-button>
                            </span>
                        </x-slot>
                        @foreach($reports as $report)
                            <x-dropdown.item
                                wire:navigate
                                href="{{ route('report', ['slug' => $report->slug]) }}"
                                :label="$report->name"
                            ></x-dropdown.item>
                        @endforeach
                        <x-dropdown.item>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <div class="flex" @click.prevent="$root.submit();">
                                    <x-icon name="logout" class="w-4 h-4"></x-icon>
                                    <span class="ml-4 my-auto">{{ __('Log Out') }}</span>
                                </div>
                            </form>
                        </x-dropdown.item>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" @click.outside.debounce.100ms="open=false" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden fixed left-0 top-16 z-50 bg-secondary-800 w-full text-gray-400">
            <!-- Responsive Settings Options -->
            <div class="border-b border-t border-emerald-800 space-y-2">
                <div class="space-y-1">
                    @foreach($reports as $report)
                        <div class="p-4">
                            <a wire:navigate href="{{ route('report', ['slug' => $report->slug]) }}">
                                {{ $report->name }}
                            </a>
                        </div>
                    @endforeach
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data class="cursor-pointer p-4">
                        @csrf
                        <div class="flex" @click.prevent="$root.submit();">
                            <x-icon name="logout" class="w-5 h-5"></x-icon>
                            <span class="ml-4 my-auto">{{ __('Log Out') }}</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
