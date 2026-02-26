/**
 * Catálogo - Funcionalidad de búsqueda y scroll infinito
 */

document.addEventListener('DOMContentLoaded', function() {
    initCatalogSearch();
    initCatalogInfiniteScroll();
});

/**
 * Inicializar búsqueda del catálogo
 */
function initCatalogSearch() {
    const searchInput = document.getElementById('js-search');
    const searchBtn = document.getElementById('js-search-btn');

    if (!searchInput || !searchBtn) return;

    function doSearch() {
        const params = new URLSearchParams(window.location.search);
        const q = searchInput.value.trim();
        if (q) {
            params.set('q', q);
        } else {
            params.delete('q');
        }
        params.delete('page');
        window.location.href = '?' + params.toString();
    }

    searchBtn.addEventListener('click', doSearch);
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            doSearch();
        }
    });
}

/**
 * Scroll Infinito para el catálogo
 */
function initCatalogInfiniteScroll() {
    const sentinel = document.getElementById('scroll-sentinel');
    const loadingIndicator = document.getElementById('loading-indicator');
    const noMoreProducts = document.getElementById('no-more-products');
    const pagination = document.querySelector('.pagination');

    if (!sentinel) return;

    // Obtener datos del servidor
    const currentPage = parseInt(sentinel.dataset.currentPage || '1');
    const lastPage = parseInt(sentinel.dataset.lastPage || '1');
    const hasMore = sentinel.dataset.hasMore === 'true';

    let isLoading = false;
    let currentPageNum = currentPage;
    let hasMorePages = hasMore;

    // Ocultar paginación tradicional si hay más páginas
    if (hasMorePages && pagination) {
        pagination.style.display = 'none';
    }

    // Función para cargar más productos
    async function loadMoreProducts() {
        if (isLoading || !hasMorePages) return;

        isLoading = true;
        loadingIndicator.style.display = 'block';
        sentinel.style.display = 'block';

        try {
            const nextPage = currentPageNum + 1;
            const urlParams = new URLSearchParams(window.location.search);
            const currentCategory = urlParams.get('categoria') || '';
            const q = urlParams.get('q') || '';
            
            let url = `/api/public/products/load-more?page=${nextPage}&categoria=${currentCategory}`;
            if (q) {
                url += `&q=${encodeURIComponent(q)}`;
            }

            const response = await fetch(url);
            const data = await response.json();

            if (data.products && data.products.length > 0) {
                const grid = document.querySelector('.products-grid');

                data.products.forEach(product => {
                    const card = createProductCard(product);
                    grid.insertAdjacentHTML('beforeend', card);
                });

                currentPageNum = data.current_page;
                hasMorePages = data.has_more;

                if (!hasMorePages) {
                    loadingIndicator.style.display = 'none';
                    noMoreProducts.style.display = 'block';
                }
            } else {
                hasMorePages = false;
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
    if (hasMorePages) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !isLoading) {
                    loadMoreProducts();
                }
            });
        }, { rootMargin: '100px' });

        observer.observe(sentinel);
    }
}
