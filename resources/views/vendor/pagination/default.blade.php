@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
        <li><span>总计 {{ $paginator->total() }} 条,  {{ $paginator->currentPage()}}/{{ $paginator->lastPage()}} 页</span></li>
    </ul>
@else

    <ul class="pagination">
        <li class="disabled"><span>&laquo;</span></li>
        <li class="disabled"><span>1</span></li>
        <li class="disabled"><span>&raquo;</span></li>
        <li><span>总计 {{ $paginator->total() }} 条, {{ $paginator->lastPage()}} 页</span></li>
    </ul>
@endif

