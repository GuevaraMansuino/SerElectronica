@extends('admin.layout')

@section('title', 'Promociones')
@section('page-title', 'PROMOCIONES')

@section('topbar-actions')
<a href="{{ route('admin.promociones.create') }}" class="abtn abtn-lime">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Nueva promoción
</a>
@endsection

<style>
.action-btn-lime { color: var(--lime) !important; }

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
.help-popup-body strong.lime { color: var(--lime); }

.help-popup-footer {
    border-top: 1px solid var(--border-solid);
    padding: 0.8rem 1.5rem 1.4rem;
}

/* Backdrop for help popup */
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

    {{-- Tabla --}}
    <div>
        {{-- Stats rápidas --}}
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem;">
            <div class="acard" style="padding:0;">
                <div style="padding:1.2rem;text-align:center;">
                    <span style="font-family:var(--font-display);font-size:2.5rem;color:var(--lime);line-height:1;display:block;">
                        {{ $promociones->count() }}
                    </span>
                    <span style="font-family:var(--font-mono);font-size:0.62rem;text-transform:uppercase;letter-spacing:0.15em;color:var(--text-3);">Total</span>
                </div>
            </div>
            <div class="acard" style="padding:0;">
                <div style="padding:1.2rem;text-align:center;">
                    <span style="font-family:var(--font-display);font-size:2.5rem;color:var(--success);line-height:1;display:block;">
                        {{ $promociones->where('activa', true)->count() }}
                    </span>
                    <span style="font-family:var(--font-mono);font-size:0.62rem;text-transform:uppercase;letter-spacing:0.15em;color:var(--text-3);">Activas</span>
                </div>
            </div>
            <div class="acard" style="padding:0;">
                <div style="padding:1.2rem;text-align:center;">
                    <span style="font-family:var(--font-display);font-size:2.5rem;color:var(--text-3);line-height:1;display:block;">
                        {{ $promociones->where('activa', false)->count() }}
                    </span>
                    <span style="font-family:var(--font-mono);font-size:0.62rem;text-transform:uppercase;letter-spacing:0.15em;color:var(--text-3);">Inactivas</span>
                </div>
            </div>
        </div>

        <div class="acard">
            <div class="acard-header">
                <span class="acard-title">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                    </svg>
                    Listado de promociones
                    <span class="help-popup-wrapper">
                        <button type="button" class="help-trigger" aria-label="Ayuda sobre promociones" tabindex="0">
                            ?
                        </button>
                        <div class="help-popup" role="tooltip">
                            <div class="help-popup-header">
                                <span class="help-popup-title">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                                    Cómo funcionan
                                </span>
                            </div>
                            <div class="help-popup-body">
                                <p>Las promociones <strong>activas</strong> aparecen en la sección "Promociones" del inicio y en la página de promociones.</p>
                                <p>Podés definir una <strong>fecha de vencimiento</strong> para que la promo expire automáticamente, o dejarla sin fecha para que dure indefinidamente.</p>
                                <p>Usá el botón de <strong class="lime">encendido/apagado</strong> para activar o desactivar rápidamente sin eliminar.</p>
                            </div>
                            <div class="help-popup-footer">
                                <a href="{{ route('admin.promociones.create') }}" class="abtn abtn-lime" style="width:100%;justify-content:center;">
                                    + Nueva promoción
                                </a>
                            </div>
                        </div>
                        <div class="help-backdrop"></div>
                    </span>
                </span>
            </div>

            <table class="atable">
                <thead>
                    <tr>
                        <th style="width:60px"></th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Vencimiento</th>
                        <th style="text-align:right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promociones as $promo)
                    <tr>
                        <td>
                            @if($promo->imagen)
                                <img src="{{ asset('storage/' . $promo->imagen) }}"
                                     alt="{{ $promo->titulo }}"
                                     class="td-img">
                            @else
                                <div class="td-img-ph">🏷️</div>
                            @endif
                        </td>

                        <td class="td-main">{{ $promo->titulo }}</td>

                        <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            <span title="{{ $promo->descripcion }}">
                                {{ Str::limit($promo->descripcion, 55) }}
                            </span>
                        </td>

                        <td>
                            <span class="badge {{ $promo->activa ? 'badge-success' : 'badge-danger' }}">
                                {{ $promo->activa ? 'Activa' : 'Inactiva' }}
                            </span>
                        </td>

                        <td>
                            @if($promo->fecha_fin)
                                @if($promo->fecha_fin->isPast())
                                    <span style="font-size:0.78rem;color:var(--danger);">
                                        Venció {{ $promo->fecha_fin->format('d/m/Y') }}
                                    </span>
                                @elseif($promo->fecha_fin->diffInDays() <= 3)
                                    <span style="font-size:0.78rem;color:var(--warning);">
                                        Vence {{ $promo->fecha_fin->diffForHumans() }}
                                    </span>
                                @else
                                    <span style="font-size:0.78rem;color:var(--text-2);">
                                        {{ $promo->fecha_fin->format('d/m/Y') }}
                                    </span>
                                @endif
                            @else
                                <span style="font-size:0.78rem;color:var(--text-3);">Sin vencimiento</span>
                            @endif
                        </td>

                        <td>
                            <div class="td-actions" style="justify-content:flex-end;">
                                {{-- Toggle activa/inactiva - solo si está dentro del período válido --}}
                                @php
                                    $isExpired = $promo->end_date && \Carbon\Carbon::parse($promo->end_date)->isPast();
                                    $canToggle = !$isExpired;
                                @endphp
                                @if($canToggle)
                                <a href="{{ URL::signedRoute('admin.promociones.toggle', ['id' => $promo->id]) }}"
                                   class="action-btn {{ !$promo->activa ? 'action-btn-lime' : '' }}"
                                   title="{{ $promo->activa ? 'Desactivar' : 'Activar' }}">
                                    @if($promo->activa)
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M18.36 6.64a9 9 0 11-12.73 0"/>
                                        <line x1="12" y1="2" x2="12" y2="12"/>
                                    </svg>
                                    @else
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <polyline points="9 11 12 14 22 4"/>
                                        <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                                    </svg>
                                    @endif
                                </a>
                                @else
                                <span class="action-btn" 
                                      style="opacity:0.4;cursor:not-allowed;"
                                      title="No se puede modificar: promoción vencida el {{ \Carbon\Carbon::parse($promo->end_date)->format('d/m/Y') }}">
                                    @if($promo->activa)
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M18.36 6.64a9 9 0 11-12.73 0"/>
                                        <line x1="12" y1="2" x2="12" y2="12"/>
                                    </svg>
                                    @else
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <polyline points="9 11 12 14 22 4"/>
                                        <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                                    </svg>
                                    @endif
                                </span>
                                @endif

                                {{-- Editar --}}
                                <a href="{{ route('admin.promociones.edit', $promo) }}"
                                   class="action-btn"
                                   title="Editar promoción">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('admin.promociones.destroy', $promo) }}"
                                      method="POST"
                                      id="delete-form-{{ $promo->id }}"
                                      style="display:contents">
                                    @csrf @method('DELETE')
                                    <button type="button" 
                                            class="action-btn del" 
                                            title="Eliminar"
                                            data-confirm="¿Eliminar la promoción «{{ addslashes($promo->titulo) }}»?"
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
                        <td colspan="6" style="text-align:center;padding:4rem 2rem;">
                            <div style="font-size:2.5rem;margin-bottom:0.8rem">⭐</div>
                            <p style="color:var(--text-2);margin-bottom:0.5rem;">Todavía no hay promociones</p>
                            <a href="{{ route('admin.promociones.create') }}"
                               style="color:var(--lime);font-size:0.85rem;">
                                + Crear la primera promoción
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const helpTrigger = document.querySelector('.help-trigger');
    const helpPopupWrapper = document.querySelector('.help-popup-wrapper');
    const helpPopup = document.querySelector('.help-popup');
    const helpBackdrop = document.querySelector('.help-backdrop');
    
    function closeHelpPopup() {
        console.log('Closing popup');
        if (helpPopupWrapper) {
            helpPopupWrapper.classList.remove('active');
        }
    }
    
    function toggleHelpPopup() {
        if (helpPopupWrapper) {
            helpPopupWrapper.classList.toggle('active');
            console.log('Toggle popup, new state:', helpPopupWrapper.classList.contains('active'));
        }
    }
    
    if (helpTrigger) {
        // Toggle on click
        helpTrigger.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();
            toggleHelpPopup();
        });
        
        // Close on click outside
        document.addEventListener('click', function(e) {
            if (helpPopupWrapper && helpPopupWrapper.classList.contains('active')) {
                if (!helpPopupWrapper.contains(e.target)) {
                    closeHelpPopup();
                }
            }
        });
        
        // Close on escape
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                e.preventDefault();
                closeHelpPopup();
            }
        });
        
        // Close on backdrop click
        if (helpBackdrop) {
            helpBackdrop.addEventListener('click', function(e) {
                e.stopPropagation();
                closeHelpPopup();
            });
        }
        
        console.log('Help popup initialized');
    }
});
</script>

@endsection