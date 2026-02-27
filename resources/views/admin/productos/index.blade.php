@extends('admin.layout')

@section('title', 'Productos')
@section('page-title', 'PRODUCTOS')

@section('topbar-actions')
<a href="{{ route('admin.productos.create') }}" class="abtn abtn-lime">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Nuevo producto
</a>
@endsection

@push('styles')
<style>
/* Help popup styles */
.help-trigger {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: var(--surface-2);
    border: 1px solid var(--border-solid);
    color: var(--text-3);
    font-family: var(--font-mono);
    font-size: 0.7rem;
    font-weight: 700;
    cursor: help;
    margin-left: 8px;
    transition: all var(--t);
    position: relative;
    z-index: 10;
}

.help-trigger:hover,
.help-trigger.active {
    background: var(--lime);
    color: var(--bg);
    border-color: var(--lime);
}

.help-popup-wrapper {
    position: static;
    display: inline-flex;
    align-items: center;
    position: relative;
}

.help-popup-wrapper:hover .help-popup,
.help-popup-wrapper:hover ~ .help-backdrop,
.help-popup-wrapper.active .help-popup,
.help-popup-wrapper.active ~ .help-backdrop {
    opacity: 1;
    visibility: visible;
}

.help-popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: var(--surface);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius-lg);
    overflow: hidden;
    width: 380px;
    max-width: 90vw;
    box-shadow: 0 20px 60px rgba(0,0,0,0.5), var(--shadow);
    opacity: 0;
    visibility: hidden;
    transition: all 0.25s ease;
    z-index: 9999;
}

.help-popup-header {
    padding: 1.1rem 1.5rem;
    border-bottom: 1px solid var(--border-solid);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--surface-2);
}

.help-popup-header svg { color: var(--lime); }

.help-popup-title {
    font-family: var(--font-display);
    font-size: 0.84rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.help-popup-body {
    padding: 1.4rem 1.5rem;
    font-size: 0.82rem;
    color: var(--text-2);
    line-height: 1.7;
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.help-popup-body p { margin: 0; }
.help-popup-body strong { color: var(--text); }

.help-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(4px);
    opacity: 0;
    visibility: hidden;
    transition: all 0.25s ease;
    z-index: 9998;
}

.help-trigger.active ~ .help-backdrop {
    opacity: 1;
    visibility: visible;
}

.toolbar {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.toolbar-search {
    display: flex;
    align-items: center;
    background: var(--surface);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius);
    overflow: hidden;
    transition: border-color var(--t);
    flex: 1;
    max-width: 360px;
}

.toolbar-search:focus-within { border-color: var(--lime); }

.toolbar-search input {
    flex: 1;
    background: none;
    border: none;
    outline: none;
    padding: 9px 14px;
    font-size: 0.86rem;
    color: var(--text);
    font-family: var(--font-body);
}

.toolbar-search input::placeholder { color: var(--text-3); }

.toolbar-search button {
    background: none;
    border: none;
    padding: 9px 12px;
    color: var(--text-3);
    cursor: pointer;
    transition: color var(--t);
    display: grid;
    place-items: center;
}

.toolbar-search button:hover { color: var(--lime); }

.toolbar-select {
    background: var(--surface);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius);
    padding: 9px 12px;
    font-size: 0.84rem;
    color: var(--text-2);
    outline: none;
    cursor: pointer;
    font-family: var(--font-body);
    transition: border-color var(--t);
    min-width: 180px;
}

.toolbar-select:focus { border-color: var(--lime); }
</style>
@endpush

@section('content')

{{-- Toolbar --}}
<form action="{{ route('admin.productos.index') }}" method="GET" class="toolbar" id="filter-form">
    <div class="toolbar-search">
        <input type="text"
               name="q"
               value="{{ request('q') }}"
               placeholder="Buscar por nombre...">
        <button type="submit" aria-label="Buscar">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
        </button>
    </div>

    <select name="categoria_id" class="toolbar-select" onchange="this.form.submit()">
        <option value="">Todas las categorías</option>
        @foreach($categorias as $cat)
            <option value="{{ $cat->id }}"
                {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->nombre }}
            </option>
        @endforeach
    </select>

    <select name="estado" class="toolbar-select" onchange="this.form.submit()">
        <option value="">Todos los estados</option>
        <option value="activo"   {{ request('estado') === 'activo'   ? 'selected' : '' }}>Activos</option>
        <option value="oculto"   {{ request('estado') === 'oculto'   ? 'selected' : '' }}>Ocultos</option>
        <option value="destacado"{{ request('estado') === 'destacado'? 'selected' : '' }}>Destacados</option>
    </select>

    @if(request()->hasAny(['q','categoria_id','estado']))
        <a href="{{ route('admin.productos.index') }}" class="abtn abtn-outline" style="white-space:nowrap;">
            ✕ Limpiar
        </a>
    @endif
</form>

{{-- Tabla --}}
<div class="acard">
    <div class="acard-header">
        <span class="acard-title">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="2" y="3" width="6" height="6"/><rect x="9" y="3" width="6" height="6"/>
                <rect x="16" y="3" width="6" height="6"/><rect x="2" y="10" width="6" height="11"/>
                <rect x="9" y="10" width="13" height="11"/>
            </svg>
            {{ $productos->total() }} productos
            <span class="help-popup-wrapper">
                <button type="button" id="helpBtn" class="help-trigger" aria-label="Ayuda sobre productos" tabindex="0">
                    ?
                </button>
                <div id="helpPopup" class="help-popup" role="tooltip">
                    <div class="help-popup-header">
                        <span class="help-popup-title">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                            Ayuda
                        </span>
                    </div>
                    <div class="help-popup-body">
                        <p>Los <strong>productos</strong> son los artículos que vendés en tu tienda. Cada uno puede tener precio, descripción, imagen y categoría.</p>
                        <p>Podés aplicar <strong>promociones</strong> a productos específicos o a categorías enteras.</p>
                        <p>Los productos se muestran en el catálogo público solo si están <strong>activos</strong>.</p>
                    </div>
                </div>
                <div class="help-backdrop"></div>
            </span>
        </span>
        <span style="font-family:var(--font-mono);font-size:0.65rem;color:var(--text-3);">
            Página {{ $productos->currentPage() }} de {{ $productos->lastPage() }}
        </span>
    </div>

    <table class="atable">
        <thead>
            <tr>
                <th style="width:60px"></th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Destacado</th>
                <th>Estado</th>
                <th style="text-align:right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
            <tr>
                <td>
                    @if($producto->image)
                        <img src="{{ asset('storage/' . $producto->image) }}"
                             alt="{{ $producto->name }}"
                             class="td-img">
                    @else
                        <span class="td-img-ph" title="Sin imagen">📦</span>
                    @endif
                </td>

                <td class="td-main">{{ $producto->name }}</td>

                <td>
                    <span class="badge badge-neutral">{{ $producto->category->name }}</span>
                </td>

                <td style="font-family:var(--font-display);font-size:1.05rem;color:var(--lime);letter-spacing:0.02em;">
                    ${{ number_format($producto->price, 0, ',', '.') }}
                </td>

                <td>
                    @if($producto->destacado)
                        <span class="badge badge-lime">Destacado</span>
                    @else
                        <span style="color:var(--text-3);font-size:0.78rem;">—</span>
                    @endif
                </td>

                <td>
                    <span class="badge {{ $producto->activo ? 'badge-success' : 'badge-danger' }}">
                        {{ $producto->activo ? 'Activo' : 'Oculto' }}
                    </span>
                </td>

                <td>
                    <div class="td-actions" style="justify-content:flex-end;">
                        {{-- Ver en sitio --}}
                        <a href="{{ route('producto.show', $producto->slug) }}"
                           target="_blank"
                           class="action-btn"
                           title="Ver en el sitio">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/>
                                <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
                            </svg>
                        </a>

                        {{-- Editar --}}
                        <a href="{{ route('admin.productos.edit', $producto) }}"
                           class="action-btn"
                           title="Editar producto">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </a>

                        {{-- Toggle activo --}}
                        <form action="{{ route('admin.productos.toggle', $producto) }}" method="POST" style="display:contents">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    class="action-btn"
                                    title="{{ $producto->activo ? 'Ocultar' : 'Activar' }}">
                                @if($producto->activo)
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/>
                                    <path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/>
                                    <line x1="1" y1="1" x2="23" y2="23"/>
                                </svg>
                                @else
                                <svg width="12" height="12" fill="none" stroke="var(--lime)" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                @endif
                            </button>
                        </form>

                        {{-- Eliminar --}}
                        <form action="{{ route('admin.productos.destroy', $producto) }}"
                              method="POST"
                              id="delete-form-{{ $producto->id }}"
                              style="display:contents">
                            @csrf @method('DELETE')
                            <button type="button" 
                                    class="action-btn del" 
                                    title="Eliminar producto"
                                    data-confirm="¿Eliminar «{{ addslashes($producto->nombre) }}»?\nEsta acción no se puede deshacer."
                                    onclick="confirmDelete(this)">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14H6L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                    <path d="M9 6V4h6v2"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:4rem 2rem;">
                    <div style="font-size:2.5rem;margin-bottom:0.8rem">📦</div>
                    <p style="color:var(--text-2);margin-bottom:0.5rem">No se encontraron productos</p>
                    @if(request()->hasAny(['q','categoria_id','estado']))
                        <a href="{{ route('admin.productos.index') }}" style="color:var(--lime);font-size:0.85rem;">Limpiar filtros</a>
                    @else
                        <a href="{{ route('admin.productos.create') }}" style="color:var(--lime);font-size:0.85rem;">+ Crear el primer producto</a>
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación --}}
    @if($productos->hasPages())
    <div style="padding:1.2rem 1.5rem;border-top:1px solid var(--border-solid);display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
        <span style="font-size:0.78rem;color:var(--text-3);">
            Mostrando {{ $productos->firstItem() }}–{{ $productos->lastItem() }} de {{ $productos->total() }}
        </span>
        <div style="display:flex;gap:0.3rem;">
            @if($productos->onFirstPage())
                <span class="abtn abtn-outline" style="opacity:0.3;pointer-events:none;padding:6px 10px;">‹</span>
            @else
                <a href="{{ $productos->previousPageUrl() }}" class="abtn abtn-outline" style="padding:6px 10px;">‹</a>
            @endif

            @foreach($productos->getUrlRange(max(1, $productos->currentPage()-2), min($productos->lastPage(), $productos->currentPage()+2)) as $page => $url)
                @if($page == $productos->currentPage())
                    <span class="abtn abtn-lime" style="padding:6px 12px;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="abtn abtn-outline" style="padding:6px 12px;">{{ $page }}</a>
                @endif
            @endforeach

            @if($productos->hasMorePages())
                <a href="{{ $productos->nextPageUrl() }}" class="abtn abtn-outline" style="padding:6px 10px;">›</a>
            @else
                <span class="abtn abtn-outline" style="opacity:0.3;pointer-events:none;padding:6px 10px;">›</span>
            @endif
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const helpBtn = document.getElementById('helpBtn');
    const helpPopup = document.getElementById('helpPopup');
    
    if (helpBtn && helpPopup) {
        // Toggle popup on button click
        helpBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            helpPopup.classList.toggle('active');
        });
        
        // Close on click outside
        document.addEventListener('click', function(e) {
            if (!helpPopup.contains(e.target) && !helpBtn.contains(e.target)) {
                helpPopup.classList.remove('active');
            }
        });
        
        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                helpPopup.classList.remove('active');
            }
        });
    }
});
</script>

@endsection