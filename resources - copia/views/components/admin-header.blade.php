@props([
    'title' => '',
    'subtitle' => '',
    'actions' => null
])

{{--
    Uso:
    @include('components.admin-header', [
        'title' => 'Productos',
        'subtitle' => 'Gestiona tu inventario',
        'actions' => '<a href="#" class="btn btn-primary">Nuevo</a>'
    ])
--}}

<div class="admin-header">
    <div class="admin-header__content">
        @if($title)
            <h1 class="admin-header__title">{{ $title }}</h1>
        @endif
        @if($subtitle)
            <p class="admin-header__subtitle">{{ $subtitle }}</p>
        @endif
    </div>
    
    @if($actions || $slot->isNotEmpty())
        <div class="admin-header__actions">
            {{ $actions }}
            {{ $slot }}
        </div>
    @endif
</div>
