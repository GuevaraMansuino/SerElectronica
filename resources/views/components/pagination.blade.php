@props(['paginator'])

{{--
    Uso:
    @include('components.pagination', ['paginator' => $productos])
--}}

@if($paginator->hasPages())
<nav class="pagination" aria-label="Paginación">

    {{-- Anterior --}}
    @if($paginator->onFirstPage())
        <span class="disabled" aria-hidden="true">‹</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" aria-label="Página anterior">‹</a>
    @endif

    {{-- Páginas numeradas --}}
    @foreach($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
        @if($page == $paginator->currentPage())
            <span class="current" aria-current="page">{{ $page }}</span>
        @else
            <a href="{{ $url }}" aria-label="Página {{ $page }}">{{ $page }}</a>
        @endif
    @endforeach

    {{-- Siguiente --}}
    @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" aria-label="Página siguiente">›</a>
    @else
        <span class="disabled" aria-hidden="true">›</span>
    @endif

</nav>
@endif