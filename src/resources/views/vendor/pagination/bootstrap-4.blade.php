@if ($paginator->hasPages())
    <nav class="pagination-nav">
        <ul class="pagination" style="display: flex; justify-content: center; list-style-type: none;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}&date={{ request('date', $currentDate ?? '') }}" rel="prev" aria-label="@lang('pagination.previous')" style="background-color: white; border: 1px solid #000; padding: 5px;">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link" style="background-color: white; border: 1px solid #000; padding: 5px;">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}&date={{ request('date', $currentDate ?? '') }}" style="background-color: white; border: 1px solid #000; padding: 5px;">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}&date={{ request('date', $currentDate ?? '') }}" rel="next" aria-label="@lang('pagination.next')" style="background-color: white; border: 1px solid #000; padding: 5px;">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true" style="background-color: white; border: 1px solid #000; padding: 5px;">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
