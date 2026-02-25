@extends('layouts.app')

@section('title', 'Catálogo – SER Electrónica')
@section('meta_description', 'Catálogo de productos de electrónica, audio, altavoces y más. SER Electrónica, Lavalle 299, Mendoza.')

@push('styles')
<style>
/* ================================================================
   CATÁLOGO INDEX
================================================================ */
.page-banner {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 3rem 5vw 2.5rem;
}

.page-banner__inner { max-width: 1320px; margin: 0 auto; }

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.78rem;
    color: var(--text-3);
    margin-bottom: 1.2rem;
    flex-wrap: wrap;
}

.breadcrumb a { color: var(--text-2); transition: color var(--t); }
.breadcrumb a:hover { color: var(--lime); }
.breadcrumb span { color: var(--lime); }

/* ================================================================
   LAYOUT 2 COLUMNAS
================================================================ */
.catalog-layout {
    display: grid;
    grid-template-columns: 270px 1fr;
    gap: 2.5rem;
    max-width: 1320px;
    margin: 0 auto;
    padding: 3rem 5vw 5rem;
    align-items: start;
}

/* ================================================================
   SIDEBAR FILTROS
================================================================ */
.sidebar {
    position: sticky;
    top: 84px;
    max-height: calc(100vh - 100px);
    overflow-y: auto;
}

.sidebar-card {
    background: var(--surface);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius-lg);
    overflow: hidden;
}

.sidebar-card__header {
    padding: 1rem 1.4rem;
    border-bottom: 1px solid var(--border-solid);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.sidebar-card__header svg { color: var(--lime); }

.sidebar-card__title {
    font-family: var(--font-mono);
    font-size: 0.68rem;
    text-transform: uppercase;
    letter-spacing: 0.18em;
    color: var(--lime);
}

.sidebar-card__body { padding: 1.4rem; }

.filter-section { margin-bottom: 1.8rem; }
.filter-section:last-child { margin-bottom: 0; }

.filter-section__label {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--text-2);
    text-transform: uppercase;
    letter-spacing: 0.1em;
    display: block;
    margin-bottom: 0.8rem;
    font-family: var(--font-body);
}

.filter-cats { list-style: none; display: flex; flex-direction: column; gap: 2px; }

.filter-cats__item a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 7px 10px;
    border-radius: var(--radius);
    font-size: 0.86rem;
    color: var(--text-2);
    transition: all var(--t);
    border: 1px solid transparent;
}

.filter-cats__item a:hover {
    color: var(--lime);
    background: var(--lime-dim);
    border-color: rgba(182,255,59,0.15);
}

.filter-cats__item a.active {
    color: var(--lime);
    background: var(--lime-dim);
    border-color: rgba(182,255,59,0.25);
}

.filter-cats__count {
    font-family: var(--font-mono);
    font-size: 0.65rem;
    color: var(--text-3);
}

.filter-cats__item a.active .filter-cats__count { color: var(--lime); opacity: 0.7; }

/* Price inputs */
.price-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.6rem;
    margin-bottom: 0.8rem;
}

.price-field {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.price-field label {
    font-size: 0.68rem;
    color: var(--text-3);
    font-family: var(--font-mono);
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

.price-field input {
    background: var(--bg);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius);
    padding: 8px 10px;
    font-size: 0.85rem;
    color: var(--text);
    outline: none;
    width: 100%;
    transition: border-color var(--t);
}

.price-field input:focus { border-color: var(--lime); }

.filter-apply {
    width: 100%;
    background: var(--lime);
    color: var(--bg);
    border: none;
    border-radius: var(--radius);
    padding: 9px;
    font-size: 0.82rem;
    font-weight: 700;
    font-family: var(--font-body);
    letter-spacing: 0.06em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all var(--t);
}

.filter-apply:hover { background: #c8ff5a; box-shadow: var(--shadow-lime); }

.filter-reset {
    display: block;
    text-align: center;
    margin-top: 0.7rem;
    font-size: 0.75rem;
    color: var(--text-3);
    transition: color var(--t);
}

.filter-reset:hover { color: var(--lime); }

/* Divider */
.filter-divider {
    height: 1px;
    background: var(--border-solid);
    margin: 1.4rem 0;
}

/* ================================================================
   MAIN CATALOG
================================================================ */
.catalog-main {}

.catalog-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.8rem;
    flex-wrap: wrap;
}

.catalog-count {
    font-size: 0.85rem;
    color: var(--text-3);
}

.catalog-count strong { color: var(--text); }

.catalog-controls {
    display: flex;
    align-items: center;
    gap: 0.7rem;
}

/* Search bar */
.search-bar {
    display: flex;
    align-items: center;
    background: var(--surface);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius);
    overflow: hidden;
    transition: border-color var(--t);
}

.search-bar:focus-within { border-color: var(--lime); }

.search-bar input {
    background: none;
    border: none;
    outline: none;
    padding: 9px 14px;
    font-size: 0.86rem;
    color: var(--text);
    font-family: var(--font-body);
    width: 220px;
}

.search-bar input::placeholder { color: var(--text-3); }

.search-bar button {
    background: none;
    border: none;
    padding: 9px 12px;
    color: var(--text-3);
    cursor: pointer;
    transition: color var(--t);
    display: grid;
    place-items: center;
}

.search-bar button:hover { color: var(--lime); }

/* Sort */
.sort-select {
    background: var(--surface);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius);
    padding: 9px 12px;
    font-size: 0.83rem;
    color: var(--text-2);
    outline: none;
    cursor: pointer;
    font-family: var(--font-body);
    transition: border-color var(--t);
}

.sort-select:focus { border-color: var(--lime); }

/* Active filters chips */
.active-filters {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 1.2rem;
}

.filter-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: var(--lime-dim);
    border: 1px solid rgba(182,255,59,0.25);
    border-radius: 100px;
    padding: 4px 10px;
    font-size: 0.73rem;
    color: var(--lime);
    font-family: var(--font-mono);
}

.filter-chip a {
    color: var(--lime);
    opacity: 0.6;
    transition: opacity var(--t);
    line-height: 1;
}

.filter-chip a:hover { opacity: 1; }

/* ================================================================
   PRODUCTOS GRID
================================================================ */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(252px, 1fr));
    gap: 1.3rem;
}

/* Empty state */
.empty-catalog {
    grid-column: 1 / -1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 5rem 2rem;
    text-align: center;
}

.empty-catalog__icon { font-size: 4rem; margin-bottom: 1rem; }
.empty-catalog h3 { font-family: var(--font-display); font-size: 1.5rem; color: var(--text-2); margin-bottom: 0.4rem; }
.empty-catalog p  { font-size: 0.88rem; color: var(--text-3); }

/* ================================================================
   PAGINACIÓN
================================================================ */
.pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    margin-top: 3rem;
    flex-wrap: wrap;
}

.pagination a,
.pagination span {
    min-width: 36px;
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius);
    font-size: 0.85rem;
    font-weight: 600;
    border: 1px solid var(--border-solid);
    color: var(--text-2);
    padding: 0 8px;
    transition: all var(--t);
}

.pagination a:hover {
    border-color: var(--lime);
    color: var(--lime);
    background: var(--lime-dim);
}

.pagination .current {
    background: var(--lime);
    color: var(--bg);
    border-color: var(--lime);
}

.pagination .disabled { opacity: 0.25; pointer-events: none; }

/* ================================================================
   RESPONSIVE
================================================================ */
@media (max-width: 960px) {
    .catalog-layout { grid-template-columns: 1fr; }
    .sidebar { position: static; }
}

@media (max-width: 600px) {
    .catalog-toolbar { flex-direction: column; align-items: stretch; }
    .catalog-controls { flex-wrap: wrap; }
    .search-bar input { width: 160px; }
}
</style>
@endpush

@section('content')

{{-- PAGE BANNER --}}
<div class="page-banner">
    <div class="page-banner__inner">
        <nav class="breadcrumb" aria-label="Migas de pan">
            <a href="{{ route('home') }}">Inicio</a>
            <span>›</span>
            <span>Catálogo</span>
            @if(request('categoria') && isset($categoriaActual))
                <span>›</span>
                <span>{{ $categoriaActual->name }}</span>
            @endif
        </nav>
        <span class="sec-label">Productos</span>
        <h1 class="sec-title">
            @if(request('categoria') && isset($categoriaActual))
                {{ strtoupper($categoriaActual->name) }}
            @else
                CATÁLOGO COMPLETO
            @endif
        </h1>
    </div>
</div>

{{-- LAYOUT --}}
<div class="catalog-layout">

    {{-- SIDEBAR --}}
    <aside class="sidebar" aria-label="Filtros">
        <form action="{{ route('catalogo.index') }}" method="GET" id="filter-form">

            <div class="sidebar-card">
                <div class="sidebar-card__header">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                    <span class="sidebar-card__title">Filtros</span>
                </div>

                <div class="sidebar-card__body">

                    {{-- Categorías --}}
                    <div class="filter-section">
                        <span class="filter-section__label">Categoría</span>
                        <ul class="filter-cats">
                            <li class="filter-cats__item">
                                <a href="{{ route('catalogo.index') }}"
                                   class="{{ !request('categoria') ? 'active' : '' }}">
                                    <span>Todas las categorías</span>
                                    <span class="filter-cats__count">{{ $totalProductos }}</span>
                                </a>
                            </li>
                            @foreach($categorias as $cat)
                            <li class="filter-cats__item">
                                <a href="{{ route('catalogo.index', array_merge(request()->except(['categoria','page']), ['categoria' => $cat->slug])) }}"
                                   class="{{ request('categoria') === $cat->slug ? 'active' : '' }}">
                                    <span>{{ $cat->nombre }}</span>
                                    <span class="filter-cats__count">{{ $cat->productos_count }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="filter-divider"></div>

                    {{-- Precio --}}
                    <div class="filter-section">
                        <span class="filter-section__label">Rango de precio</span>
                        <div class="price-row">
                            <div class="price-field">
                                <label for="precio_min">Desde</label>
                                <input type="number" id="precio_min" name="precio_min"
                                       placeholder="0"
                                       value="{{ request('precio_min') }}" min="0">
                            </div>
                            <div class="price-field">
                                <label for="precio_max">Hasta</label>
                                <input type="number" id="precio_max" name="precio_max"
                                       placeholder="∞"
                                       value="{{ request('precio_max') }}" min="0">
                            </div>
                        </div>
                        @if(request('categoria'))
                            <input type="hidden" name="categoria" value="{{ request('categoria') }}">
                        @endif
                        <button type="submit" class="filter-apply">Aplicar filtros</button>

                        @if(request()->hasAny(['precio_min','precio_max','q']))
                        <a href="{{ route('catalogo.index', request()->only('categoria')) }}"
                           class="filter-reset">✕ Limpiar filtros</a>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </aside>

    {{-- PRODUCTOS --}}
    <div class="catalog-main">

        {{-- Active filter chips --}}
        @if(request()->hasAny(['categoria','precio_min','precio_max','q']))
        <div class="active-filters">
            <span style="font-size:0.75rem;color:var(--text-3);font-family:var(--font-mono);">Filtros activos:</span>
            @if(request('categoria'))
                <span class="filter-chip">
                    {{ $categoriaActual->name ?? request('categoria') }}
                    <a href="{{ route('catalogo.index', request()->except('categoria')) }}" aria-label="Quitar filtro categoría">✕</a>
                </span>
            @endif
            @if(request('precio_min') || request('precio_max'))
                <span class="filter-chip">
                    Precio: ${{ request('precio_min', '0') }} – ${{ request('precio_max', '∞') }}
                    <a href="{{ route('catalogo.index', request()->except(['precio_min','precio_max'])) }}" aria-label="Quitar filtro precio">✕</a>
                </span>
            @endif
            @if(request('q'))
                <span class="filter-chip">
                    "{{ request('q') }}"
                    <a href="{{ route('catalogo.index', request()->except('q')) }}" aria-label="Quitar búsqueda">✕</a>
                </span>
            @endif
        </div>
        @endif

        {{-- Toolbar --}}
        <div class="catalog-toolbar">
            <span class="catalog-count">
                <strong>{{ $productos->total() }}</strong> productos encontrados
            </span>

            <div class="catalog-controls">
                {{-- Search --}}
                <div class="search-bar">
                    <input type="text"
                           id="js-search"
                           placeholder="Buscar..."
                           value="{{ request('q') }}"
                           aria-label="Buscar producto">
                    <button type="button" id="js-search-btn" aria-label="Buscar">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    </button>
                </div>

                {{-- Sort --}}
                <select class="sort-select" onchange="location.href=this.value" aria-label="Ordenar por">
                    <option value="{{ request()->fullUrlWithQuery(['orden'=>'reciente','page'=>null]) }}"
                        {{ request('orden','reciente')==='reciente' ? 'selected' : '' }}>Más recientes</option>
                    <option value="{{ request()->fullUrlWithQuery(['orden'=>'precio_asc','page'=>null]) }}"
                        {{ request('orden')==='precio_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                    <option value="{{ request()->fullUrlWithQuery(['orden'=>'precio_desc','page'=>null]) }}"
                        {{ request('orden')==='precio_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                    <option value="{{ request()->fullUrlWithQuery(['orden'=>'nombre','page'=>null]) }}"
                        {{ request('orden')==='nombre' ? 'selected' : '' }}>Nombre A–Z</option>
                </select>
            </div>
        </div>

        {{-- Grid --}}
        <div class="products-grid">
            @forelse($productos as $producto)
            <article class="product-card">
                <div class="product-card__img">
                    @if($producto->image)
                        <img src="{{ asset('storage/'.$producto->image) }}"
                             alt="{{ $producto->name }}" loading="lazy">
                    @else
                        <div style="display:grid;place-items:center;height:100%;font-size:2.5rem;color:var(--text-3)">📦</div>
                    @endif
                    @if($producto->is_new)
                        <span class="product-card__badge">Nuevo</span>
                    @endif
                </div>
                <div class="product-card__body">
                    <span class="product-card__cat">{{ $producto->category->name }}</span>
                    <h2 class="product-card__name">{{ $producto->name }}</h2>
                    <p class="product-card__desc">{{ Str::limit($producto->description, 88) }}</p>
                    <div class="product-card__footer">
                        <div>
                            @if($producto->has_promotion)
                                <small>Precio</small>
                                <span class="product-card__price" style="text-decoration: line-through; color: var(--text-3); font-size: 0.85em;">${{ number_format($producto->price, 0, ',', '.') }}</span>
                                <div style="color: var(--lime); font-weight: 600;">
                                    <small>Con promo:</small>
                                    <span class="product-card__price" style="color: var(--lime);">${{ number_format($producto->final_price, 0, ',', '.') }}</span>
                                </div>
                            @else
                                <small>Precio</small>
                                <span class="product-card__price">${{ number_format($producto->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <a href="{{ route('producto.show', $producto->slug) }}" class="product-card__cta">
                            Ver más
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="empty-catalog">
                <div class="empty-catalog__icon">🔍</div>
                <h3>Sin resultados</h3>
                <p>No encontramos productos con esos filtros.<br>Intentá cambiar los criterios de búsqueda.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($productos->hasPages())
        <nav class="pagination" aria-label="Paginación">
            @if($productos->onFirstPage())
                <span class="disabled">‹</span>
            @else
                <a href="{{ $productos->previousPageUrl() }}" aria-label="Página anterior">‹</a>
            @endif

            @foreach($productos->getUrlRange(1, $productos->lastPage()) as $page => $url)
                @if($page == $productos->currentPage())
                    <span class="current" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" aria-label="Página {{ $page }}">{{ $page }}</a>
                @endif
            @endforeach

            @if($productos->hasMorePages())
                <a href="{{ $productos->nextPageUrl() }}" aria-label="Página siguiente">›</a>
            @else
                <span class="disabled">›</span>
            @endif
        </nav>
        @endif

        {{-- Scroll Infinito: Sentinel para detectar fin de página --}}
        <div id="scroll-sentinel" style="display:none;"></div>
        
        {{-- Indicador de carga --}}
        <div id="loading-indicator" style="display:none;text-align:center;padding:2rem;">
            <div style="color:var(--text-2);font-size:0.9rem;">Cargando más productos...</div>
        </div>

        {{-- Fin del catálogo --}}
        <div id="no-more-products" style="display:none;text-align:center;padding:2rem;color:var(--text-3);">
            <p>Has visto todos los productos</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Scroll Infinito para el catálogo
(function() {
    'use strict';
    
    const sentinel = document.getElementById('scroll-sentinel');
    const loadingIndicator = document.getElementById('loading-indicator');
    const noMoreProducts = document.getElementById('no-more-products');
    const pagination = document.querySelector('.pagination');
    
    let currentPage = {{ $productos->currentPage() }};
    let lastPage = {{ $productos->lastPage() }};
    let isLoading = false;
    let hasMore = {{ $productos->hasMorePages() ? 'true' : 'false' }};
    
    // Obtener categoría actual de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const currentCategory = urlParams.get('categoria') || '';
    
    // Ocultar paginación tradicional si hay más páginas
    if (hasMore && pagination) {
        pagination.style.display = 'none';
    }
    
    // Función para cargar más productos
    async function loadMoreProducts() {
        if (isLoading || !hasMore) return;
        
        isLoading = true;
        loadingIndicator.style.display = 'block';
        sentinel.style.display = 'block';
        
        try {
            const nextPage = currentPage + 1;
            const url = `/api/public/products/load-more?page=${nextPage}&categoria=${currentCategory}`;
            
            const response = await fetch(url);
            const data = await response.json();
            
            if (data.products && data.products.length > 0) {
                // Agregar productos al grid
                const grid = document.querySelector('.products-grid');
                
                data.products.forEach(product => {
                    const card = createProductCard(product);
                    grid.insertAdjacentHTML('beforeend', card);
                });
                
                currentPage = data.current_page;
                hasMore = data.has_more;
                
                if (!hasMore) {
                    loadingIndicator.style.display = 'none';
                    noMoreProducts.style.display = 'block';
                }
            } else {
                hasMore = false;
                loadingIndicator.style.display = 'none';
                noMoreProducts.style.display = 'block';
            }
        } catch (error) {
            console.error('Error cargando más productos:', error);
        } finally {
            isLoading = false;
            sentinel.style.display = 'none';
        }
    }
    
    // Función para crear HTML de tarjeta de producto
    function createProductCard(product) {
        const imageHtml = product.image 
            ? `<img src="/storage/${product.image}" alt="${product.name}" loading="lazy">`
            : `<div style="display:grid;place-items:center;height:100%;font-size:2.5rem;color:var(--text-3)">📦</div>`;
        
        const badgeHtml = product.is_new 
            ? `<span class="product-card__badge">Nuevo</span>` 
            : '';
        
        const categoryName = product.category ? product.category.name : '';
        const priceFormatted = new Intl.NumberFormat('es-AR').format(product.price);
        const finalPriceFormatted = product.final_price ? new Intl.NumberFormat('es-AR').format(product.final_price) : priceFormatted;
        
        let priceHtml = '';
        if (product.has_promotion) {
            priceHtml = `
                <small>Precio</small>
                <span class="product-card__price" style="text-decoration: line-through; color: var(--text-3); font-size: 0.85em;">${priceFormatted}</span>
                <div style="color: var(--lime); font-weight: 600;">
                    <small>Con promo:</small>
                    <span class="product-card__price" style="color: var(--lime);">${finalPriceFormatted}</span>
                </div>
            `;
        } else {
            priceHtml = `
                <small>Precio</small>
                <span class="product-card__price">${priceFormatted}</span>
            `;
        }
        
        return `
            <article class="product-card">
                <div class="product-card__img">
                    ${imageHtml}
                    ${badgeHtml}
                </div>
                <div class="product-card__body">
                    <span class="product-card__cat">${categoryName}</span>
                    <h2 class="product-card__name">${product.name}</h2>
                    <p class="product-card__desc">${product.description ? product.description.substring(0, 88) : ''}</p>
                    <div class="product-card__footer">
                        <div>
                            ${priceHtml}
                        </div>
                        <a href="/catalogo/${product.slug}" class="product-card__cta">
                            Ver más
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </div>
            </article>
        `;
    }
    
    // Intersection Observer para detectar cuando llegamos al final
    if (hasMore) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !isLoading) {
                    loadMoreProducts();
                }
            });
        }, { rootMargin: '100px' });
        
        if (sentinel) {
            observer.observe(sentinel);
        }
    }
})();
</script>
    const searchInput = document.getElementById('js-search');
    const searchBtn   = document.getElementById('js-search-btn');

    function doSearch() {
        const params = new URLSearchParams(window.location.search);
        const q = searchInput.value.trim();
        if (q) params.set('q', q); else params.delete('q');
        params.delete('page');
        window.location.href = '?' + params.toString();
    }

    searchBtn.addEventListener('click', doSearch);
    searchInput.addEventListener('keydown', e => { if (e.key === 'Enter') doSearch(); });
</script>
@endpush