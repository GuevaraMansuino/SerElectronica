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

@push('styles')
<style>
.action-btn-lime { color: var(--lime) !important; }
</style>
@endpush

@section('content')

<div style="display:grid;grid-template-columns:1fr 280px;gap:1.5rem;align-items:start;">

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
                                {{-- Toggle activa/inactiva - using signed URL --}}
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

    {{-- Sidebar info --}}
    <div class="acard">
        <div class="acard-header">
            <span class="acard-title">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                Cómo funcionan
            </span>
        </div>
        <div class="acard-body" style="font-size:0.82rem;color:var(--text-2);line-height:1.7;display:flex;flex-direction:column;gap:0.8rem;">
            <p>Las promociones <strong style="color:var(--text)">activas</strong> aparecen en la sección "Promociones" del inicio y en la página de promociones.</p>
            <p>Podés definir una <strong style="color:var(--text)">fecha de vencimiento</strong> para que la promo expire automáticamente, o dejarla sin fecha para que dure indefinidamente.</p>
            <p>Usá el botón de <strong style="color:var(--lime)">encendido/apagado</strong> para activar o desactivar rápidamente sin eliminar.</p>
            <div style="border-top:1px solid var(--border-solid);padding-top:0.8rem;margin-top:0.2rem;">
                <a href="{{ route('admin.promociones.create') }}" class="abtn abtn-lime" style="width:100%;justify-content:center;">
                    + Nueva promoción
                </a>
            </div>
        </div>
    </div>

</div>

@endsection