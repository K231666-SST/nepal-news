@if ($paginator->hasPages())
<nav style="display:flex;align-items:center;justify-content:space-between;padding:16px 0;flex-wrap:wrap;gap:10px">
    <div style="font-size:13px;color:#6e6e73">
        Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
    </div>
    <div style="display:flex;gap:5px;align-items:center">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span style="padding:7px 14px;border:1.5px solid rgba(0,0,0,0.08);border-radius:22px;color:#ccc;font-size:13px;font-weight:500">← Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding:7px 14px;border:1.5px solid rgba(0,0,0,0.08);border-radius:22px;color:#1d1d1f;font-size:13px;font-weight:500;background:white;text-decoration:none;transition:all .2s">← Prev</a>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span style="padding:7px 10px;font-size:13px;color:#ccc">...</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding:7px 14px;border:1.5px solid #C0392B;border-radius:22px;background:#C0392B;color:white;font-size:13px;font-weight:600;box-shadow:0 3px 10px rgba(192,57,43,0.3)">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding:7px 14px;border:1.5px solid rgba(0,0,0,0.08);border-radius:22px;color:#1d1d1f;font-size:13px;font-weight:500;background:white;text-decoration:none">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding:7px 14px;border:1.5px solid rgba(0,0,0,0.08);border-radius:22px;color:#1d1d1f;font-size:13px;font-weight:500;background:white;text-decoration:none">Next →</a>
        @else
            <span style="padding:7px 14px;border:1.5px solid rgba(0,0,0,0.08);border-radius:22px;color:#ccc;font-size:13px;font-weight:500">Next →</span>
        @endif
    </div>
</nav>
@endif
