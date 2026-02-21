@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'DASHBOARD')

@section('topbar-actions')
<a href="{{ route('admin.productos.create') }}" class="abtn abtn-lime">
    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
    </svg>
    Nuevo producto
</a>
@endsection

@section('content')

{{-- ── Stats ──────────────────────────────────────────────────── --}}
<div class="stats-row">
    <div class="stat-box">
        <div class="stat-box__icon">📦</div>
        <div class="stat-box__label">Productos</div>
        <div class="stat-box__value">{{ $stats['productos'] }}</div>
        <div class="stat-box__sub">en el catálogo</div>
    </div>
    <div class="stat-box">
        <div class="stat-box__icon">🗂️</div>
        <div class="stat-box__label">Categorías</div>
        <div class="stat-box__value">{{ $stats['categorias'] }}</div>
        <div class="stat-box__sub">creadas</div>
    </div>
    <div class="stat-box">
        <div class="stat-box__icon">⭐</div>
        <div class="stat-box__label">Promociones</div>
        <div class="stat-box__value">{{ $stats['promociones'] }}</div>
        <div class="stat-box__sub">activas ahora</div>
    </div>
    <div class="stat-box">
        <div class="stat-box__icon">⚠️</div>
        <div class="stat-box__label">Sin imagen</div>
        <div class="stat-box__value" style="color:{{ $stats['sin_imagen'] > 0 ? 'var(--warning)' : 'var(--lime)' }}">
            {{ $stats['sin_imagen'] }}
        </div>
        <div class="stat-box__sub">requieren imagen</div>
    </div>
</div>

{{-- ── Layout 2 columnas ─────────────────────────────────────── --}}
<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

    {{-- Últimos productos ──────────────────────────────────── --}}
    <div class="acard">
        <div class="acard-header">
            <span class="acard-title">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="2" y="3" width="6" height="6"/><rect x="9" y="3" width="6" height="6"/>
                    <rect x="16" y="3" width="6" height="6"/><rect x="2" y="10" width="6" height="11"/>
                    <rect x="9" y="10" width="13" height="11"/>
                </svg>
                Últimos productos agregados
            </span>
            <a href="{{ route('admin.productos.index') }}"
               class="abtn abtn-outline"
               style="padding:5px 12px;font-size:0.75rem;">
                Ver todos →
            </a>
        </div>

        <table class="atable">
            <thead>
                <tr>
                    <th style="width:56px"></th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th style="text-align:right"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($ultimosProductos as $p)
                <tr>
                    <td>
                        @if($p->image)
                            <img src="{{ asset('storage/' . $p->image) }}"
                                 class="td-img" alt="{{ $p->name }}">
                        @else
                            <span class="td-img-ph">📦</span>
                        @endif
                    </td>
                    <td class="td-main">{{ $p->name }}</td>
                    <td>
                        <span class="badge badge-neutral">{{ $p->category->name }}</span>
                    </td>
                    <td style="font-family:var(--font-display);font-size:1.05rem;color:var(--lime);letter-spacing:0.02em;">
                        ${{ number_format($p->price, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="badge {{ $p->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $p->is_active ? 'Activo' : 'Oculto' }}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <a href="{{ route('admin.productos.edit', $p) }}"
                           class="action-btn" title="Editar">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2.5rem;color:var(--text-3);">
                        <a href="{{ route('admin.productos.create') }}"
                           style="color:var(--lime);">+ Crear el primer producto</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Panel derecho ──────────────────────────────────────── --}}
    <div style="display:flex;flex-direction:column;gap:1.2rem;">

        {{-- Accesos rápidos --}}
        <div class="acard">
            <div class="acard-header">
                <span class="acard-title">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                    </svg>
                    Accesos rápidos
                </span>
            </div>
            <div class="acard-body" style="display:flex;flex-direction:column;gap:0.6rem;">
                <a href="{{ route('admin.productos.create') }}"
                   class="abtn abtn-lime"
                   style="justify-content:flex-start;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Nuevo producto
                </a>
                <a href="{{ route('admin.categorias.create') }}"
                   class="abtn abtn-outline"
                   style="justify-content:flex-start;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Nueva categoría
                </a>
                <a href="{{ route('admin.promociones.create') }}"
                   class="abtn abtn-outline"
                   style="justify-content:flex-start;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Nueva promoción
                </a>
                <div style="border-top:1px solid var(--border-solid);padding-top:0.6rem;margin-top:0.2rem;">
                    <a href="{{ route('home') }}"
                       target="_blank"
                       class="abtn abtn-outline"
                       style="justify-content:flex-start;font-size:0.78rem;color:var(--text-3);">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        Ver el sitio público
                    </a>
                </div>
            </div>
        </div>

        {{-- Promociones activas --}}
        <div class="acard">
            <div class="acard-header">
                <span class="acard-title">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                    </svg>
                    Promos activas
                </span>
                <a href="{{ route('admin.promociones.index') }}"
                   class="abtn abtn-outline"
                   style="padding:4px 10px;font-size:0.72rem;">
                    Ver todas
                </a>
            </div>
            <div class="acard-body" style="display:flex;flex-direction:column;gap:0;">
                @forelse($promocionesActivas as $promo)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:0.65rem 0;border-bottom:1px solid var(--border-solid);">
                    <div>
                        <span style="font-size:0.85rem;color:var(--text);display:block;font-weight:500;">
                            {{ Str::limit($promo->titulo, 30) }}
                        </span>
                        @if($promo->fecha_fin)
                        <span style="font-size:0.68rem;color:var(--text-3);font-family:var(--font-mono);">
                            Vence {{ $promo->fecha_fin->format('d/m/Y') }}
                        </span>
                        @endif
                    </div>
                    <a href="{{ route('admin.promociones.edit', $promo) }}"
                       style="font-size:0.72rem;color:var(--lime);white-space:nowrap;margin-left:0.8rem;">
                        Editar →
                    </a>
                </div>
                @empty
                <p style="font-size:0.82rem;color:var(--text-3);padding:0.5rem 0;">
                    No hay promociones activas.
                    <a href="{{ route('admin.promociones.create') }}" style="color:var(--lime);">Crear una →</a>
                </p>
                @endforelse
            </div>
        </div>

        {{-- Resumen de categorías --}}
        <div class="acard">
            <div class="acard-header">
                <span class="acard-title">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 7h4l2-4h6l2 4h4"/><path d="M5 21h14"/><line x1="12" y1="7" x2="12" y2="21"/>
                    </svg>
                    Categorías
                </span>
                <a href="{{ route('admin.categorias.index') }}"
                   class="abtn abtn-outline"
                   style="padding:4px 10px;font-size:0.72rem;">
                    Gestionar
                </a>
            </div>
            <div class="acard-body" style="display:flex;flex-direction:column;gap:0;">
                @foreach(\App\Models\Category::withCount('products')->orderByDesc('products_count')->take(6)->get() as $cat)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:0.55rem 0;border-bottom:1px solid var(--border-solid);">
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <span style="font-size:1rem;">{{ $cat->icono_emoji ?? '📦' }}</span>
                        <span style="font-size:0.84rem;color:var(--text-2);">{{ $cat->nombre }}</span>
                    </div>
                    <span class="badge badge-lime">{{ $cat->productos_count }}</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection