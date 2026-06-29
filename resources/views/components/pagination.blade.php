@if ($paginator->hasPages())
<div class="flex items-center justify-center gap-2 py-6 bg-white rounded-b-lg">

    {{-- Sebelumnya --}}
    @if ($paginator->onFirstPage())
        <span class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-400 cursor-not-allowed">
            &lt; Sebelumnya
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-500 hover:bg-gray-100 transition-all">
            &lt; Sebelumnya
        </a>
    @endif

    {{-- Nomor Halaman --}}
    @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
        @if ($page == $paginator->currentPage())
            <span class="px-4 py-2 bg-[#7a4988] text-white rounded-md text-sm font-bold shadow-md">
                {{ $page }}
            </span>
        @else
            <a href="{{ $url }}"
               class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-500 hover:bg-gray-100 transition-all">
                {{ $page }}
            </a>
        @endif
    @endforeach

    {{-- Selanjutnya --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-500 hover:bg-gray-100 transition-all">
            Selanjutnya &gt;
        </a>
    @else
        <span class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-400 cursor-not-allowed">
            Selanjutnya &gt;
        </span>
    @endif

</div>
@endif