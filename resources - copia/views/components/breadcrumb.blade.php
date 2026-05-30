@props(['items' => []])

{{--
    Uso:
    @include('components.breadcrumb', [
        'items' => [
            ['label' => 'Inicio',   'url' => route('home')],
            ['label' => 'Catálogo', 'url' => route('catalogo.index')],
            ['label' => 'Nombre categoría'], // último item, sin url
        ]
    ])
--}}

<nav class="breadcrumb" aria-label="Migas de pan">
    @foreach($items as $index => $item)
        @if(!$loop->last)
            <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
            <span aria-hidden="true">›</span>
        @else
            <span>{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
