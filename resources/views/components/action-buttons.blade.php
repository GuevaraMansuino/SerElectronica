@props([
    'editUrl' => '#',
    'deleteUrl' => '#',
    'deleteId' => null,
    'deleteName' => 'este elemento',
    'showView' => false,
    'viewUrl' => '#'
])

{{--
    Uso:
    @include('components.action-buttons', [
        'editUrl' => route('admin.productos.edit', $product->id),
        'deleteUrl' => route('admin.productos.destroy', $product->id),
        'deleteId' => $product->id,
        'deleteName' => $product->name
    ])
    
    Con botón ver:
    @include('components.action-buttons', [
        'editUrl' => ...,
        'deleteUrl' => ...,
        'showView' => true,
        'viewUrl' => route('productos.show', $product->id)
    ])
--}}

<div class="action-buttons">
    @if($showView)
        <a href="{{ $viewUrl }}" class="action-btn action-btn--view" title="Ver">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
            </svg>
        </a>
    @endif
    
    <a href="{{ $editUrl }}" class="action-btn action-btn--edit" title="Editar">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
        </svg>
    </a>
    
    @if($deleteUrl && $deleteId)
        <form action="{{ $deleteUrl }}" method="POST" class="action-form" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="action-btn action-btn--delete" 
                    title="Eliminar"
                    onclick="return confirm('¿Estás seguro de eliminar {{ $deleteName }}?')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>
            </button>
        </form>
    @endif
</div>
