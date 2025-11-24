@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-3 py-1 text-gray-500 bg-gray-100 rounded cursor-not-allowed">
                    <i class="fas fa-chevron-left mr-1"></i>Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded leading-5 hover:bg-green-50 hover:text-green-700 focus:outline-none focus:ring ring-green-300 focus:border-green-500 active:bg-green-100 active:text-green-700 transition ease-in-out duration-150">
                    <i class="fas fa-chevron-left mr-1"></i>Previous
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-1 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded leading-5 hover:bg-green-50 hover:text-green-700 focus:outline-none focus:ring ring-green-300 focus:border-green-500 active:bg-green-100 active:text-green-700 transition ease-in-out duration-150">
                    Next<i class="fas fa-chevron-right ml-1"></i>
                </a>
            @else
                <span class="relative inline-flex items-center px-3 py-1 ml-3 text-gray-500 bg-gray-100 rounded cursor-not-allowed">
                    Next<i class="fas fa-chevron-right ml-1"></i>
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Previous">
                            <span class="relative inline-flex items-center px-3 py-1 text-gray-500 bg-gray-100 rounded cursor-not-allowed" aria-hidden="true">
                                <i class="fas fa-chevron-left mr-1"></i>Previous
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-md leading-5 hover:bg-green-50 hover:text-green-700 focus:z-10 focus:outline-none focus:ring ring-green-300 focus:border-green-500 active:bg-green-100 active:text-green-700 transition ease-in-out duration-150" aria-label="Previous">
                            <i class="fas fa-chevron-left mr-1"></i>Previous
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-green-600 cursor-default leading-5 rounded-md">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:bg-green-50 hover:text-green-700 focus:z-10 focus:outline-none focus:ring ring-green-300 focus:border-green-500 active:bg-green-100 active:text-green-700 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-md leading-5 hover:bg-green-50 hover:text-green-700 focus:z-10 focus:outline-none focus:ring ring-green-300 focus:border-green-500 active:bg-green-100 active:text-green-700 transition ease-in-out duration-150" aria-label="Next">
                            Next<i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Next">
                            <span class="relative inline-flex items-center px-3 py-1 text-gray-500 bg-gray-100 rounded cursor-not-allowed" aria-hidden="true">
                                Next<i class="fas fa-chevron-right ml-1"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
