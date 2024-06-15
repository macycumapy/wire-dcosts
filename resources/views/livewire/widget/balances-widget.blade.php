<div>
    <x-dropdown width="7xl">
        <x-slot name="trigger">
            <div class="flex">
                <div class="w-[150px] md:w-auto truncate">{{ $mainAccount->name }}</div>:&nbsp;
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
                        <div class="w-[200px] md:w-auto truncate">{{ $account->name }}</div>
                        <div>{{number_format($account->balance, 2, '.', ' ')}}</div>
                    </div>
                </x-dropdown.header>
            @endforeach
        </div>
    </x-dropdown>
</div>
