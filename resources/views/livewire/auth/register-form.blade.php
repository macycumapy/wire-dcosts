@section('page-title')
    Регистрация
@endsection

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-8 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-lg p-4 rounded bg-opacity-25 bg-gray-200 space-y-4 !text-gray-900 h-full">
        <h1 class="text-white text-center"> @yield('page-title')</h1>

        <x-label class="text-white">
            Имя
            <x-input
                wire:model.defer="createUserData.name"
                name="name"
                class="text-gray-800 font-semibold"
                required
            ></x-input>
        </x-label>

        <x-label class="text-white">
            Email
            <x-input
                wire:model.defer="createUserData.email"
                name="email"
                class="text-gray-800 font-semibold"
                required
            ></x-input>
        </x-label>

        <x-label class="text-white">
            Пароль
            <x-input
                wire:model.defer="createUserData.password"
                name="password"
                class="text-gray-800 font-semibold"
                type="password"
                required
            ></x-input>
        </x-label>

        <x-label class="text-white">
            Подтверждение пароля
            <x-input
                wire:model.defer="createUserData.password_confirmation"
                name="password_confirmation"
                class="text-gray-800 font-semibold"
                type="password"
                required
            ></x-input>
        </x-label>

        <div class="flex justify-end">
            <x-button primary
                      wire:click="register"
                      label="Зарегистрироваться"
            ></x-button>
        </div>
    </div>
</div>
