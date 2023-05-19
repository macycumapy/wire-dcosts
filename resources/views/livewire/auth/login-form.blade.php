@section('page-title')
    Авторизация
@endsection

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-8 min-h-screen flex justify-center items-center">
    <div class="w-full sm:max-w-md p-4 rounded bg-opacity-25 bg-gray-200 space-y-4 !text-gray-900 h-full">
        <h1 class="text-white text-center"> @yield('page-title')</h1>

        <x-label class="text-white">
            Email
            <x-input
                wire:model="authUserData.email"
                wire:keydown.enter="login"
                name="email"
                class="text-gray-800 font-semibold"
                required
            ></x-input>
        </x-label>

        <x-label class="text-white">
            Пароль
            <x-input
                wire:model="authUserData.password"
                wire:keydown.enter="login"
                name="password"
                class="text-gray-800 font-semibold"
                type="password"
                required
            ></x-input>
        </x-label>

        <x-label class="text-white flex gap-3">
            <x-checkbox
                wire:model="authUserData.remember"
                name="remember"
                class="font-semibold"
            ></x-checkbox>

            Запомнить меня
        </x-label>

        <x-button primary
                  wire:click="login"
                  wire:loading.attr="disabled"
                  spinner="login"
                  class="w-full"
        >Войти</x-button>
    </div>
</div>
