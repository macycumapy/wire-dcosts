@section('page-title')
    Регистрация
@endsection

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-8 min-h-screen flex justify-center items-center">
    <div class="w-full sm:max-w-md p-4 rounded bg-opacity-25 bg-gray-200 space-y-4 !text-gray-900 h-full">
        <h1 class="text-white text-center"> @yield('page-title')</h1>

        <x-label class="text-white">
            Имя
            <x-input
                wire:model.defer="createUserData.name"
                wire:keydown.enter="register"
                name="name"
                class="text-gray-800 font-semibold"
                required
            ></x-input>
        </x-label>

        <x-label class="text-white">
            Email
            <x-input
                wire:model.defer="createUserData.email"
                wire:keydown.enter="register"
                name="email"
                class="text-gray-800 font-semibold"
                required
            ></x-input>
        </x-label>

        <x-label class="text-white">
            Пароль
            <x-input
                wire:model.defer="createUserData.password"
                wire:keydown.enter="register"
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
                wire:keydown.enter="register"
                name="password_confirmation"
                class="text-gray-800 font-semibold"
                type="password"
                required
            ></x-input>
        </x-label>

        <x-button primary
                  wire:click="register"
                  label="Зарегистрироваться"
                  class="w-full"
        ></x-button>
    </div>
</div>
