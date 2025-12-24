@if ($paginator->hasPages())
    <div class="flex items-center justify-between">

        {{-- SHOWING INFO --}}
        <p class="text-sm text-gray-600">
            @if ($paginator->firstItem())
                Showing
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                to
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                of
                <span class="font-medium">{{ $paginator->total() }}</span>
                results
            @else
                Showing {{ $paginator->count() }}
            @endif
        </p>

        {{-- PAGINATION BUTTONS --}}
        <div class="flex items-center gap-2">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <button
                    disabled
                    class="border cursor-not-allowed opacity-40 bg-surface rounded-md border-line px-3 py-2"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                </button>
            @else
                <a
                    href="{{ $paginator->previousPageUrl() }}"
                    class="border hover:text-primary hover:opacity-90 transition-all duration-300 bg-surface rounded-md border-line px-3 py-2"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            @endif

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a
                    href="{{ $paginator->nextPageUrl() }}"
                    class="border hover:text-primary hover:opacity-90 transition-all duration-300 bg-surface rounded-md border-line px-3 py-2"
                >
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            @else
                <button
                    disabled
                    class="border cursor-not-allowed opacity-40 bg-surface rounded-md border-line px-3 py-2"
                >
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            @endif

        </div>
    </div>
@endif
