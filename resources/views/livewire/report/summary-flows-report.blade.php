<div class="max-w-7xl sm:mx-auto sm:p-4 p-2">
    <x-card card-classes="h-full" padding="sm:p-4 p-2">
        <div class="min-w-full">
            <x-filters :count="$this->filtersCount">
                <x-search-period></x-search-period>
            </x-filters>
            <div id="list" class="min-h-[60vh] divide-y divide-gray-500">
                @foreach($items as $group)
                    <div class="p-2 space-y-2">
                        @if($group->group_type === 'Движения')
                            <div class="divide-y divide-gray-500 bg-gray-200 dark:bg-secondary-700 px-2 rounded-lg">
                                <div class="flex justify-between items-center py-1 z-10">
                                    <div>Итого поступлений</div>
                                    <div class="min-w-[100px] text-right text-positive-600">
                                        {{ number_format($group->inflowsSum, 2, '.', ' ') }}
                                    </div>
                                </div>
                                <div class="flex justify-between items-center py-1 z-10">
                                    <div>Итого расходов</div>
                                    <div class="min-w-[100px] text-right text-negative-400">
                                        {{ number_format($group->outflowsSum, 2, '.', ' ') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-between items-center bg-white dark:bg-secondary-800 py-1 z-10">
                            <div class="flex gap-2 items-center cursor-pointer">
                                {{ $group->group_type }}
                                @if(optional($group)->group_num === 1 && $this->searchDateFrom)
                                    на {{ \Carbon\Carbon::parse($this->searchDateFrom)->format('d.m.Y') }}
                                @endif

                                @if(optional($group)->group_num === 3 && $this->searchDateTo)
                                    на {{ \Carbon\Carbon::parse($this->searchDateTo)->format('d.m.Y') }}
                                @endif
                            </div>

                            <div class="min-w-[120px] text-right text-positive-600">
                                {{ number_format($group->sum, 2, '.', ' ') }}
                                @isset($group->percent)
                                    ({{ $group->percent }}%)
                                @endisset
                            </div>
                        </div>


                        @isset($group->items)
                            <div class="divide-y divide-gray-500">
                                @foreach($group->items as $details)
                                    <div  class="p-2 space-y-2 bg-gray-200 dark:bg-secondary-700 first:rounded-t-lg last:rounded-b-lg">
                                        <div class="flex justify-between items-start bg-gray-200 dark:bg-secondary-700 py-1">
                                            <div class="flex gap-2 items-center">
                                                {{ mb_ucfirst($details->month) }}
                                            </div>
                                            <div class="min-w-[100px] text-right {{ $details->sum >= 0 ? 'text-positive-600' : 'text-negative-400' }}">
                                                {{ number_format($details->sum, 2, '.', ' ') }}
                                                ({{ $details->percent }}%)
                                            </div>
                                        </div>
                                        <div class="pl-4 divide-y divide-gray-500">
                                            @foreach($details->items as $flow)
                                                <div class="flex justify-between items-start bg-gray-300 dark:bg-secondary-600 p-2 first:rounded-t-lg last:rounded-b-lg">
                                                    <div>{{ $flow->type->title() }}</div>
                                                    <div class="min-w-[100px] text-right {{ $flow->sum >= 0 ? 'text-positive-600' : 'text-negative-400' }}">
                                                        {{ number_format($flow->sum, 2, '.', ' ') }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endisset
                    </div>
                @endforeach
            </div>
        </div>
    </x-card>
</div>
