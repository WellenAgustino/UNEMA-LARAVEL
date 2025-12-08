@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-6 space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-2 py-1 text-gray-500 text-sm opacity-50">
                <i class="bi bi-chevron-left"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" 
               class="px-2 py-1 text-blue-400 hover:text-blue-200 text-sm transition">
                <i class="bi bi-chevron-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-2 py-1 text-gray-500 text-sm">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-2 py-1 text-sm text-white bg-blue-600 rounded-md">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-2 py-1 text-sm text-blue-400 hover:text-blue-200 rounded-md">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" 
               class="px-2 py-1 text-blue-400 hover:text-blue-200 text-sm transition">
                <i class="bi bi-chevron-right"></i>
            </a>
        @else
            <span class="px-2 py-1 text-gray-500 text-sm opacity-50">
                <i class="bi bi-chevron-right"></i>
            </span>
        @endif
    </nav>
@endif
