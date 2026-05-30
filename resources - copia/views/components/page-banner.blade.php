@props([
    'title' => '',
    'subtitle' => '',
    'showBreadcrumb' => true,
    'breadcrumbs' => []
])

{{--
    Uso básico:
    @include('components.page-banner', [
        'title' => 'Mi Título',
        'subtitle' => 'Mi subtítulo opcional'
    ])

    Con breadcrumbs:
    @include('components.page-banner', [
        'title' => 'Catálogo',
        'breadcrumbs' => [
            ['label' => 'Inicio', 'url' => route('home')],
            ['label' => 'Catálogo']
        ]
    ])
--}}

<div class="page-banner">
    <div class="page-banner__inner">
        @if($showBreadcrumb && count($breadcrumbs) > 0)
            @include('components.breadcrumb', ['items' => $breadcrumbs])
        @endif
        
        @if($title)
            <h1 class="page-banner__title">{{ $title }}</h1>
        @endif
        
        @if($subtitle)
            <p class="page-banner__subtitle">{{ $subtitle }}</p>
        @endif
    </div>
</div>
