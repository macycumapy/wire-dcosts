@if ($paginator->hasPages())
        <div class="pagination-wrapper">
        <nav class="border-t border-gray-700 px-4 flex items-center justify-between sm:px-0">
            <div class="-mt-px w-0 flex-1 flex">
                @if(!$paginator->onFirstPage())
                    <button wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="prev"
                            class="border-t-2 border-transparent pt-4 pr-1 inline-flex items-center text-sm font-medium text-gray-400 hover:text-primary-700 hover:border-primary-600">
                        <svg class="mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                        Назад
                    </button>
                @endif
            </div>
            <div class="hidden md:-mt-px md:flex">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span
                            class="border-transparent text-gray-500 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium"> ... </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <button wire:click="gotoPage({{ $page }},'{{ $paginator->getPageName() }}')"
                                    class="border-transparent text-gray-500 hover:text-primary-700 hover:border-primary-600 border-t-2 pt-4 px-4 inline-flex items-center text-sm font-medium  {{ $paginator->currentPage() === $page ? 'border-emerald-700 text-primary-600' : '' }}">
                                {{ $page }}
                            </button>
                        @endforeach
                    @endif
                @endforeach

            </div>
            <div class="-mt-px w-0 flex-1 flex justify-end">
                @if($paginator->hasMorePages())
                    <button wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled"
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before"
                            class="border-t-2 border-transparent pt-4 pl-1 inline-flex items-center text-sm font-medium text-gray-400 hover:text-primary-700 hover:border-primary-600">
                        Вперед
                        <svg class="ml-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                @endif
            </div>
        </nav>
    </div>
@endif
