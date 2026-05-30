@props([
    'placeholder' => 'Buscar...',
    'value' => '',
    'name' => 'search',
    'route' => '',
    'method' => 'GET'
])

{{--
    Uso:
    @include('components.search-bar', [
        'placeholder' => 'Buscar productos...',
        'name' => 'q',
        'route' => route('admin.productos.index')
    ])
    
    Con valor actual:
    @include('components.search-bar', [
        'placeholder' => 'Buscar...',
        'value' => request('q'),
        'route' => route('admin.productos.index')
    ])
--}}

<form action="{{ $route }}" method="{{ $method }}" class="search-bar">
    <div class="search-bar__input-wrapper">
        <svg class="search-bar__icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.35-4.35"/>
        </svg>
        <input 
            type="text" 
            name="{{ $name }}" 
            value="{{ $value }}" 
            placeholder="{{ $placeholder }}" 
            class="search-bar__input"
        >
    </div>
    <button type="submit" class="search-bar__btn">Buscar</button>
</form>
