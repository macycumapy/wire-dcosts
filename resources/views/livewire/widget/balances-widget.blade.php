<x-dropdown width="6xl" position="bottom">
    <x-slot name="trigger">
        <div class="flex text-sm md:text-base">
            <div class="max-w-[150px] md:max-w-auto truncate">{{ $mainAccount->name }}</div>:&nbsp;
            <div>{{ number_format($mainAccount->balance, 2, '.', ' ') }} руб.</div>
        </div>
    </x-slot>

    <div class="divide-y divide-gray-500 text-gray-400">
        <x-dropdown.header class="!pt-0 !px-2">
            <div class="flex justify-between p-1 gap-2">
                <div>Всего</div>
                <div>{{number_format($totalBalance, 2, '.', ' ')}}</div>
            </div>
        </x-dropdown.header>

        @foreach ($accounts as $account)
            <x-dropdown.header class="!pt-0 !px-2">
                <div class="flex justify-between p-1 gap-2">
                    <div class="max-w-[200px] md:max-w-auto truncate">{{ $account->name }}</div>
                    <div>{{number_format($account->balance, 2, '.', ' ')}}</div>
                </div>
            </x-dropdown.header>
        @endforeach
    </div>
</x-dropdown>
