@extends('admin.layout')

@section('title', 'Categorías')
@section('page-title', 'CATEGORÍAS')

@section('topbar-actions')
<a href="{{ route('admin.categorias.create') }}" class="abtn abtn-lime">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Nueva categoría
</a>
@endsection

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

.help-popup-footer {
    border-top: 1px solid var(--border-solid);
    padding: 0.8rem 1.5rem 1.4rem;
}

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
</style>

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
                        @if($cat->productos_count > 0)
                            <span class="badge badge-lime">{{ $cat->productos_count }} producto{{ $cat->productos_count !== 1 ? 's' : '' }}</span>
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
                            @if($cat->productos_count === 0)
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