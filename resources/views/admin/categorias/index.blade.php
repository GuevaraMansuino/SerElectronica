@extends('admin.layout')

@section('title', 'Categorías')
@section('page-title', 'CATEGORÍAS')

@push('styles')
    @vite(['resources/css/admin-categorias.css'])
@endpush

@section('topbar-actions')
<a href="{{ route('admin.categorias.create') }}" class="abtn abtn-lime">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Nueva categoría
</a>
@endsection



@section('content')

<div style="display:grid;grid-template-columns:1fr;gap:1.5rem;align-items:start;">

    {{-- Tabla de categorías --}}
    <div class="acard">
        <div class="acard-header">
            <span class="acard-title">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 7h4l2-4h6l2 4h4"/><path d="M5 21h14"/><line x1="12" y1="7" x2="12" y2="21"/>
                </svg>
                {{ $categorias->count() }} categorías
                <span class="help-popup-wrapper">
                    <button type="button" class="help-trigger" aria-label="Ayuda sobre categorías" tabindex="0">
                        ?
                    </button>
                    <div class="help-popup" role="tooltip">
                        <div class="help-popup-header">
                            <span class="help-popup-title">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                                Ayuda
                            </span>
                        </div>
                        <div class="help-popup-body">
                            <p>Las <strong>categorías</strong> organizan tu catálogo. Cada producto pertenece a una.</p>
                            <p>El <strong>slug URL</strong> se genera automáticamente desde el nombre.</p>
                            <p>No podés eliminar una categoría que tenga productos asociados. Primero reasignás o eliminás los productos.</p>
                        </div>
                    </div>
                    <div class="help-backdrop"></div>
                </span>
            </span>
        </div>

        <table class="atable">
            <thead>
                <tr>
                    <th style="width:50px">Ícono</th>
                    <th>Nombre</th>
                    <th>Slug URL</th>
                    <th>Productos</th>
                    <th style="text-align:right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categorias as $cat)
                <tr>
                    <td>
                        <div style="width:40px;height:40px;background:var(--lime-dim);border:1px solid rgba(182,255,59,0.2);border-radius:8px;display:grid;place-items:center;font-size:1.3rem;">
                            {{ $cat->icono_emoji ?? '📦' }}
                        </div>
                    </td>

                    <td class="td-main">{{ $cat->nombre }}</td>

                    <td>
                        <code style="font-family:var(--font-mono);font-size:0.72rem;color:var(--text-3);background:var(--bg);padding:2px 7px;border-radius:4px;border:1px solid var(--border-solid);">
                            /{{ $cat->slug }}
                        </code>
                    </td>

                    <td>
                        @if($cat->products_count > 0)
                            <span class="badge badge-lime">{{ $cat->products_count }} producto{{ $cat->products_count !== 1 ? 's' : '' }}</span>
                        @else
                            <span class="badge badge-neutral">Sin productos</span>
                        @endif
                    </td>

                    <td>
                        <div class="td-actions" style="justify-content:flex-end;">
                            {{-- Ver productos de esta categoría --}}
                            <a href="{{ route('admin.productos.index', ['categoria_id' => $cat->id]) }}"
                               class="action-btn"
                               title="Ver productos de esta categoría">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="2" y="3" width="6" height="6"/><rect x="9" y="3" width="6" height="6"/>
                                    <rect x="16" y="3" width="6" height="6"/><rect x="2" y="10" width="6" height="11"/>
                                    <rect x="9" y="10" width="13" height="11"/>
                                </svg>
                            </a>

                            {{-- Editar --}}
                            <a href="{{ route('admin.categorias.edit', $cat) }}"
                               class="action-btn"
                               title="Editar categoría">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>

                            {{-- Eliminar (solo si no tiene productos) --}}
                            @if($cat->products_count === 0)
                            <form action="{{ route('admin.categorias.destroy', $cat) }}"
                                  method="POST"
                                  id="delete-form-{{ $cat->id }}">
                                @csrf @method('DELETE')
                                <button type="button" 
                                        class="action-btn del" 
                                        title="Eliminar categoría"
                                        data-confirm="¿Eliminar la categoría «{{ addslashes($cat->nombre) }}»?"
                                        onclick="confirmDelete(this)">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14H6L5 6"/>
                                        <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                                    </svg>
                                </button>
                            </form>
                            @else
                            {{-- Tooltip de que no se puede eliminar --}}
                            <span class="action-btn" style="opacity:0.2;cursor:not-allowed;" title="No se puede eliminar: tiene productos asociados">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14H6L5 6"/>
                                </svg>
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:4rem 2rem;">
                        <div style="font-size:2.5rem;margin-bottom:0.8rem">🗂️</div>
                        <p style="color:var(--text-2);margin-bottom:0.5rem;">Todavía no hay categorías</p>
                        <a href="{{ route('admin.categorias.create') }}" style="color:var(--lime);font-size:0.85rem;">
                            + Crear la primera categoría
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const helpTrigger = document.querySelector('.help-trigger');
    const helpPopupWrapper = document.querySelector('.help-popup-wrapper');
    
    function closeHelpPopup() {
        if (helpPopupWrapper) {
            helpPopupWrapper.classList.remove('active');
        }
    }
    
    function toggleHelpPopup() {
        if (helpPopupWrapper) {
            helpPopupWrapper.classList.toggle('active');
        }
    }
    
    if (helpTrigger) {
        helpTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            toggleHelpPopup();
        });
        
        document.addEventListener('click', function(e) {
            if (helpPopupWrapper && helpPopupWrapper.classList.contains('active')) {
                if (!helpPopupWrapper.contains(e.target)) {
                    closeHelpPopup();
                }
            }
        });
        
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                e.preventDefault();
                closeHelpPopup();
            }
        });
    }
});
</script>

@endsection