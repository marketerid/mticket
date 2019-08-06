@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <a href="javascript:void(0)" aria-label="Previous">
                    <span aria-hidden="true"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Previous</span>
                </a>
			</li>
        @else
            <li>
				<a href="{{ $paginator->previousPageUrl() }}" class="click-pagination" aria-label="Previous">
					<span aria-hidden="true"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Previous</span>
				</a>
			</li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><a href="javascript:void(0)">{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><a href="javascript:void(0)">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}" class="click-pagination">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
				<a href="{{ $paginator->nextPageUrl() }}" class="click-pagination" aria-label="Next">
					<span aria-hidden="true">Next <i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
				</a>
			</li>
        @else
            <li class="disabled">
                <a href="javascript:void(0)">
                    <span aria-hidden="true">Next <i class="fa fa-long-arrow-right" aria-hidden="true"></i></span>
                </a>
            </li>
        @endif
    </ul>
@endif
