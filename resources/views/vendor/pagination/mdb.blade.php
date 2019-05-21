@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination pg-teal justify-content-center pagination-lg">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" tabindex="-1">{{ __('Previous') }}</a>
                </li>
            @else 
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">{{ __('Previous') }}</a>
                </li>
            @endif
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" >{{ __('Next') }}</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">{{ __('Next') }}</span>
                </li>
            @endif
        </ul>
    </nav>
@endif