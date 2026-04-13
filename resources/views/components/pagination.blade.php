@props(['paginator'])

{{--
    Uso:
    @include('components.pagination', ['paginator' => $productos])
--}}

@if($paginator->hasPages())
<nav class="pagination" aria-label="Paginación">

    {{-- Anterior --}}
    @if($paginator->onFirstPage())
        <span class="disabled" aria-hidden="true" style="flex-shrink:0;">‹</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" aria-label="Página anterior" style="flex-shrink:0;">‹</a>
    @endif

    {{-- Páginas numeradas en contenedor scrolleable --}}
    @if($paginator->lastPage() > 5)
        <button type="button" onclick="document.getElementById('comp-pagination').scrollBy({left: -150, behavior: 'smooth'})" class="scroll-pag-btn" aria-label="Anteriores" style="flex-shrink:0;">«</button>
    @endif

    <div class="pagination-numbers" id="comp-pagination" style="display:flex; align-items:center; overflow-x: auto; scrollbar-width: none;">
        @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if($page == $paginator->currentPage())
                <span class="current" aria-current="page" style="flex-shrink:0;">{{ $page }}</span>
            @else
                <a href="{{ $url }}" aria-label="Página {{ $page }}" style="flex-shrink:0;">{{ $page }}</a>
            @endif
        @endforeach
    </div>

    @if($paginator->lastPage() > 5)
        <button type="button" onclick="document.getElementById('comp-pagination').scrollBy({left: 150, behavior: 'smooth'})" class="scroll-pag-btn" aria-label="Siguientes" style="flex-shrink:0;">»</button>
    @endif

    {{-- Siguiente --}}
    @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" aria-label="Página siguiente" style="flex-shrink:0;">›</a>
    @else
        <span class="disabled" aria-hidden="true" style="flex-shrink:0;">›</span>
    @endif

</nav>
@endif