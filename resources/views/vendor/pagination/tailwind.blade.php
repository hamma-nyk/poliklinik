@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        
        {{-- Mobile View --}}
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-neutral-400 bg-neutral-50 border border-neutral-200 cursor-default leading-5 rounded-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-500">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-300 leading-5 rounded-lg hover:text-neutral-500 focus:outline-none focus:ring ring-blue-300 active:bg-neutral-100 active:text-neutral-700 transition ease-in-out duration-150 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:text-white dark:active:bg-neutral-700">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-neutral-700 bg-white border border-neutral-300 leading-5 rounded-lg hover:text-neutral-500 focus:outline-none focus:ring ring-blue-300 active:bg-neutral-100 active:text-neutral-700 transition ease-in-out duration-150 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:text-white dark:active:bg-neutral-700">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-neutral-400 bg-neutral-50 border border-neutral-200 cursor-default leading-5 rounded-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-500">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Desktop View --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            
            <div class="flex items-center px-4">
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    Menampilkan
                    <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $paginator->firstItem() }}</span>
                    sampai
                    <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $paginator->lastItem() }}</span>
                    dari
                    <span class="font-bold text-neutral-800 dark:text-neutral-200">{{ $paginator->total() }}</span>
                    data
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-lg gap-1">
                    
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-neutral-300 bg-neutral-50 border border-neutral-200 cursor-default rounded-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-600" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-neutral-500 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50 hover:text-blue-600 transition-colors dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-blue-400" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-neutral-400 bg-white border border-neutral-200 cursor-default rounded-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-500">
                                    {{ $element }}
                                </span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-bold text-white bg-blue-600 border border-blue-600 rounded-lg shadow-md shadow-blue-500/30 cursor-default dark:shadow-blue-900/20">
                                            {{ $page }}
                                        </span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-neutral-600 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50 hover:text-blue-600 hover:border-blue-300 transition-all duration-200 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-blue-400" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-neutral-500 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50 hover:text-blue-600 transition-colors dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-blue-400" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-neutral-300 bg-neutral-50 border border-neutral-200 cursor-default rounded-lg dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-600" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif