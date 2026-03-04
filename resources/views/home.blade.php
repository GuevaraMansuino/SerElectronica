@extends('layouts.app')

@section('title', 'SER Electrónica – Tienda de Electrónica en Mendoza')
@section('meta_description', 'Audio profesional, equipos de música y electrónica en Mendoza. Lavalle 299. Excelente atención y los mejores precios.')

@push('styles')
    @vite(['resources/css/home.css'])
@endpush

@section('content')

{{-- ============================================================
     HERO
============================================================ --}}
<section class="hero" aria-label="Presentación">
    <div class="hero__content">

        <div class="hero__eyebrow fade-up">
            <span class="hero__eyebrow-dot"></span>
            <span class="hero__eyebrow-text">Mendoza · Lavalle 299 · Desde 2010</span>
        </div>

        <h1 class="hero__title fade-up d1">
            <span class="hero__title-line">AUDIO Y</span>
            <span class="hero__title-highlight">ELECTRÓNICA</span>
            <span class="hero__title-line">DE PRIMERA</span>
        </h1>

        <p class="hero__subtitle fade-up d2">
            Altavoces, amplificadores, equipos de música y tecnología. Asesoramiento personalizado y los mejores precios de Mendoza.
        </p>

        <div class="hero__actions fade-up d3">
            <a href="{{ route('catalogo.index') }}" class="btn btn-lime">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                Ver Productos
            </a>
            <a href="https://wa.me/5492613372353?text=Hola!+Estaba+en+su+pagina+web+y+queria+consultarles" target="_blank" rel="noopener" class="btn btn-outline">
                Consultar precio
            </a>
        </div>

        <div class="hero__stats fade-up d4">
            <div class="hero__stat">
                <span class="hero__stat-value">4.3★</span>
                <span class="hero__stat-label">Google Rating</span>
            </div>
            <div class="hero__stat">
                <span class="hero__stat-value">+16</span>
                <span class="hero__stat-label">Reseñas</span>
            </div>
            <div class="hero__stat">
                <span class="hero__stat-value">+30</span>
                <span class="hero__stat-label">Años en Mendoza</span>
            </div>
        </div>
    </div>

    <div class="hero__visual fade-up d2" aria-hidden="true">
        <div class="hero__img-frame">
            <span class="hero__corner hero__corner--tl"></span>
            <span class="hero__corner hero__corner--tr"></span>
            <span class="hero__corner hero__corner--bl"></span>
            <span class="hero__corner hero__corner--br"></span>

            <div class="hero__img-main">
                {{-- Reemplazar con foto real de la tienda --}}
                <img src="{{ asset('images/ImagenLocalFuera2.png') }}"
                     alt="Interior de SER Electrónica – Mendoza"
                     loading="eager">
            </div>

            <div class="hero__float-badge">
                <div class="hero__float-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <div class="hero__float-text">
                    <strong>Garantizado</strong>
                    <span>Productos de primera</span>
                </div>
            </div>

            <div class="hero__rating-badge" aria-label="Rating 4.3 estrellas">
                <span class="num">4.3</span>
                <span class="star">★</span>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     CATEGORÍAS
============================================================ --}}
<section class="cats-section" aria-labelledby="cats-heading">
    <div class="cats-section__inner">
        <div class="cats-header">
            <div>
                <span class="sec-label">Explorar</span>
                <h2 class="sec-title" id="cats-heading">CATEGORÍAS</h2>
            </div>
            <button class="cats-toggle" id="js-cats-toggle">
                Ver categorías
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
            </button>
        </div>
        
    </div>
</section>
<section class="cats-section-scrolleable">
    
    <div style="position:relative;">
        <div class="cats-fade-left" id="cats-fade-left"></div>
        <div class="cats-fade-right" id="cats-fade-right"></div>
        <div class="cats-grid" id="js-cats-grid">
            @forelse($categorias as $categoria)
            <a href="{{ route('catalogo.index', ['categoria' => $categoria->slug]) }}" class="cat-pill">
                <div class="cat-pill__icon">
                    {{ $categoria->icono_emoji ?? '⚡' }}
                </div>
                <span class="cat-pill__name">{{ $categoria->name }}</span>
                <span class="cat-pill__count">{{ $categoria->products_count }} productos</span>
                <span class="cat-pill__arrow">→</span>
            </a>
            @empty
        {{-- Placeholders mientras se cargan datos --}}
        @foreach(['🔊 Audio','🎵 Música','⚡ Amplificadores','🎚️ Mezcladoras','💡 Iluminación','🔌 Cables'] as $placeholder)
        <div class="cat-pill">
            <div class="cat-pill__icon">{{ explode(' ', $placeholder)[0] }}</div>
            <span class="cat-pill__name">{{ ltrim(strstr($placeholder, ' ')) }}</span>
            <span class="cat-pill__count">— productos</span>
            <span class="cat-pill__arrow">→</span>
        </div>
        @endforeach
        @endforelse
    </div>
    </div>

</section>

{{-- ============================================================
     PRODUCTOS DESTACADOS
============================================================ --}}
<section class="featured-section" aria-labelledby="featured-heading">
    {{-- Aviso de precios --}}
    <div class="price-notice" style="display:flex;align-items:center;justify-content:center;gap:0.6rem;padding:0.6rem 1rem;background:rgba(255,200,0,0.08);border:1px solid rgba(255,200,0,0.25);border-radius:var(--radius);font-size:0.85rem;color:var(--text-2);margin-bottom:1rem;text-align:center;max-width:800px;margin-left:auto;margin-right:auto;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" style="flex-shrink:0;color:#ffc800;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span><strong>Precios de contado/transferencia</strong>. Los precios pueden variar. Son precios de lista sujetos a cambios sin previo aviso.</span>
    </div>

    <div class="featured-header">
        <div>
            <span class="sec-label">Lo mejor de la tienda</span>
            <h2 class="sec-title" id="featured-heading">PRODUCTOS<br>DESTACADOS</h2>
        </div>
        <a href="{{ route('catalogo.index') }}" class="btn btn-outline">Catálogo completo →</a>
    </div>

    <div class="products-grid">
        @forelse($productosDestacados as $producto)
        @include('components.product-card', ['producto' => $producto])
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:5rem 0;color:var(--text-3);">
            <div style="font-size:3.5rem;margin-bottom:1rem">📦</div>
            <p>Los productos se mostrarán aquí.</p>
        </div>
        @endforelse
    </div>
</section>

{{-- ============================================================
     PROMOCIONES
============================================================ --}}
@if($promociones->count() > 0)
<section class="promo-strip" aria-labelledby="promo-heading">
    <div class="promo-strip__inner">
        <span class="sec-label">Ofertas activas</span>
        <h2 class="sec-title" id="promo-heading">PROMOCIONES</h2>

        <div class="promo-grid">
            @foreach($promociones->take(3) as $promo)
            <div class="promo-card">
                <span class="promo-card__tag">Promo</span>
                <h3 class="promo-card__title">{{ $promo->title }}</h3>
                <p class="promo-card__desc">{{ Str::limit($promo->description, 100) }}</p>
                @php
                    $ahora = now();
                    $muestraTiempo = '';
                    $startDate = $promo->start_date ? \Carbon\Carbon::parse($promo->start_date) : null;
                    $endDate = $promo->end_date ? \Carbon\Carbon::parse($promo->end_date) : null;
                    
                    if ($startDate && $startDate > $ahora) {
                        // La promo aún no ha comenzado
                        $diff = $startDate->diffForHumans(['parts' => 2, 'join' => true, 'short' => true]);
                        $muestraTiempo = 'Empieza en ' . $diff;
                    } elseif ($endDate && $endDate >= $ahora) {
                        // La promo está corriendo
                        $diff = $endDate->diffForHumans(['parts' => 2, 'join' => true, 'short' => true]);
                        $muestraTiempo = 'Finaliza en ' . $diff;
                    }
                @endphp
                @if($muestraTiempo)
                    <p class="promo-card__time">{{ $muestraTiempo }}</p>
                @endif
                <a href="{{ route('promociones.index') }}" class="btn btn-lime" style="font-size:0.78rem;padding:9px 18px;">
                    Ver promoción →
                </a>
            </div>
            @endforeach
        </div>

        <div style="text-align:center;margin-top:2.5rem;">
            <a href="{{ route('promociones.index') }}" class="btn btn-outline">Ver todas las promociones</a>
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     NOSOTROS / MAPA
============================================================ --}}
<section class="about-section" aria-labelledby="about-heading">
    
    {{-- Mapa a la izquierda en desktop --}}
    <div class="about__map-wrap">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3350.358977304016!2d-68.83435650000001!3d-32.888675899999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x967e092283f797bf%3A0x545fd2d1106d8b5a!2sSER!5e0!3m2!1ses-419!2sar!4v1771630104700!5m2!1ses-419!2sar"
            allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"
            style="width:100%;height:400px;border:0;border-radius:var(--radius-xl);"
            title="Ubicación de SER Electrónica en Mendoza">
        </iframe>
        <div class="about__map-pin">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Lavalle 299, Mendoza Capital
        </div>
    </div>
    
    {{-- Contenido a la derecha en desktop --}}
    <div class="about__content">
        <span class="sec-label">Dónde estamos</span>
        <h2 class="sec-title" id="about-heading">ENCONTRANOS<br>EN MENDOZA</h2>

        <p style="color:var(--text-2);margin-top:1.2rem;line-height:1.75;margin-bottom:0.8rem;font-size:1.1rem;">
            Somos una tienda especializada en electrónica ubicada en el centro de Mendoza. Más de 10 años vendiendo equipos de audio, altavoces pasivos y activos, y equipamiento de las mejores marcas.
        </p>
        <p style="color:var(--text-2);line-height:1.75;font-size:1.1rem;margin-bottom:2rem;">
            Nuestro equipo brinda asesoramiento real para que encontrés exactamente lo que necesitás al mejor precio.
        </p>

        <div class="about__features">
            <div class="feature-item">
                <div class="feature-item__icon">📍</div>
                <div class="feature-item__title">Ubicación</div>
                <div class="feature-item__text">Lavalle 299, Mendoza Capital</div>
            </div>
            <div class="feature-item">
                <div class="feature-item__icon">🕘</div>
                <div class="feature-item__title">Horario</div>
                <div class="feature-item__text">Lun–Vie 9–18h · Sáb 9–13h</div>
            </div>
            <div class="feature-item">
                <div class="feature-item__icon">📞</div>
                <div class="feature-item__title">Teléfono</div>
                <div class="feature-item__text">0261 337-2353</div>
            </div>
            <div class="feature-item">
                <div class="feature-item__icon">⚡</div>
                <div class="feature-item__title">Soporte Técnico</div>
                <div class="feature-item__text">Soporte Técnico disponible</div>
            </div>
            <div class="feature-item feature-item--recycle">
                <div class="feature-item__icon">♻️</div>
                <div class="feature-item__title">Reciclaje Responsable</div>
                <div class="feature-item__text">Reciclamos equipos electrónicos, pilas y baterías para cuidar el medio ambiente. ¡Traenos los tuyos!</div>
            </div>
        </div>

        <div class="about__map-mobile">
            <div class="about__map-wrap">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3350.358977304016!2d-68.83435650000001!3d-32.888675899999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x967e092283f797bf%3A0x545fd2d1106d8b5a!2sSER!5e0!3m2!1ses-419!2sar!4v1771630104700!5m2!1ses-419!2sar"
                    allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    style="width:100%;border:0;border-radius:var(--radius-xl);"
                    title="Ubicación de SER Electrónica en Mendoza">
                </iframe>
                <div class="about__map-pin">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Lavalle 299
                </div>
            </div>
        </div>

        <div style="margin-top:2rem;display:flex;gap:1rem;flex-wrap:wrap;">
            <a href="https://wa.me/5492613372353" target="_blank" rel="noopener" class="btn btn-lime">
                Consultar por WhatsApp
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     RESEÑAS
============================================================ --}}
<section class="reviews-section" aria-labelledby="reviews-heading">
    <div class="reviews-inner">
        <div class="reviews-header">
            <div>
                <span class="sec-label">Google Reviews</span>
                <h2 class="sec-title" id="reviews-heading">LO QUE DICEN<br>NUESTROS CLIENTES</h2>
            </div>
            <div class="reviews-score">
                <span class="reviews-score__num">4.3</span>
                <span class="reviews-score__stars">★★★★☆</span>
                <span class="reviews-score__total">16 opiniones en Google</span>
            </div>
        </div>

        <div class="reviews-grid">
            @php
            // Set locale to Spanish for Carbon
            \Carbon\Carbon::setLocale('es');
            $reviews = [
                ['name' => 'Agus Taffe', 'date' => '2025-11-15', 'text' => 'La atención un lujo, los productos de primera. El equipo me ayudó con todo, incluso con algo de un juego. 11/10.', 'rating' => 5],
                ['name' => 'José Antonio Chaile', 'date' => '2025-10-20', 'text' => 'Excelente atención y precios. Muy buena calidad en sus productos. Unos genios, los recomiendo totalmente.', 'rating' => 5],
                ['name' => 'Marcos D.', 'date' => '2025-08-10', 'text' => 'Hay buenas marcas en equipo de música y altavoces pasivos y activos. Excelente asesoramiento y muy buenos precios.', 'rating' => 5],
            ];
            @endphp
            @foreach($reviews as $review)
            <article class="review-card">
                <div class="review-card__stars">{{ str_repeat('★', $review['rating']) }}</div>
                <p class="review-card__text">{{ $review['text'] }}</p>
                <div class="review-card__author">
                    <div class="review-card__avatar" aria-hidden="true">{{ substr($review['name'], 0, 1) }}</div>
                    <div>
                        <div class="review-card__name">{{ $review['name'] }}</div>
                        <div class="review-card__date">{{ \Carbon\Carbon::parse($review['date'])->diffForHumans() }}</div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<script>
// Toggle de categorías en móviles
(function() {
    const toggle = document.getElementById('js-cats-toggle');
    const grid = document.getElementById('js-cats-grid');
    const fadeLeft = document.getElementById('cats-fade-left');
    const fadeRight = document.getElementById('cats-fade-right');
    
    // Función para actualizar la visibilidad de los gradientes
    function updateCatsFades() {
        if (!grid) return;
        
        const scrollLeft = grid.scrollLeft;
        const scrollWidth = grid.scrollWidth - grid.clientWidth;
        
        // Fade izquierdo visible cuando no estamos al inicio
        if (fadeLeft) {
            if (scrollLeft > 5) {
                fadeLeft.classList.add('visible');
            } else {
                fadeLeft.classList.remove('visible');
            }
        }
        
        // Fade derecho visible cuando no estamos al final
        if (fadeRight) {
            if (scrollLeft < scrollWidth - 5) {
                fadeRight.classList.add('visible');
            } else {
                fadeRight.classList.remove('visible');
            }
        }
    }
    
    if (grid) {
        grid.addEventListener('scroll', updateCatsFades);
        // Verificar al cargar
        updateCatsFades();
    }
    
    if (toggle && grid) {
        toggle.addEventListener('click', function() {
            grid.classList.toggle('open');
            toggle.classList.toggle('open');
            
            if (grid.classList.contains('open')) {
                toggle.innerHTML = 'Ocultar <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>';
            } else {
                toggle.innerHTML = 'Ver categorías <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>';
            }
        });
    }
})();

// ============================================================
// MODAL DE VISTA RÁPIDA DEL PRODUCTO
// ============================================================
const quickViewModal = document.getElementById('quick-view-modal');
const quickViewClose = document.getElementById('quick-view-close');
const quickViewContent = document.getElementById('quick-view-content');

// Función para abrir el modal
window.openQuickView = function(slug) {
    fetch('/api/public/products/slug/' + slug)
        .then(response => response.json())
        .then(data => {
            const discountBadge = data.discount_percentage 
                ? `<span class="product-modal__discount">-${data.discount_percentage}%</span>` 
                : '';
            
            const priceSection = data.discount_percentage
                ? `<div class="product-modal__prices">
                        <span class="product-modal__price--old">${data.price_formatted}</span>
                        <span class="product-modal__price">${data.price_with_discount_formatted}</span>
                   </div>`
                : `<div class="product-modal__prices">
                        <span class="product-modal__price">${data.price_formatted}</span>
                   </div>`;
            
            const imageSection = data.image 
                ? `<img src="${data.image}" alt="${data.name}" class="product-modal__img">`
                : `<div class="product-modal__img product-modal__img--placeholder">📦</div>`;
            
            const detailsSection = data.marca || data.modelo || data.sku
                ? `<div class="product-modal__details">
                        ${data.marca ? `<div class="product-modal__detail"><span>Marca:</span> ${data.marca}</div>` : ''}
                        ${data.modelo ? `<div class="product-modal__detail"><span>Modelo:</span> ${data.modelo}</div>` : ''}
                        ${data.sku ? `<div class="product-modal__detail"><span>SKU:</span> ${data.sku}</div>` : ''}
                        ${data.stock !== null ? `<div class="product-modal__detail"><span>Stock:</span> ${data.stock > 0 ? data.stock + ' unidades' : 'Sin stock'}</div>` : ''}
                   </div>`
                : '';
            
            quickViewContent.innerHTML = `
                <div class="product-modal__grid">
                    <div class="product-modal__image-wrap">
                        ${discountBadge}
                        ${imageSection}
                    </div>
                    <div class="product-modal__info">
                        <span class="product-modal__category">${data.category || 'Sin categoría'}</span>
                        <h2 class="product-modal__name">${data.name}</h2>
                        ${priceSection}
                        <div class="product-modal__desc">
                            <h4>Descripción</h4>
                            <p>${data.description || 'Sin descripción disponible.'}</p>
                        </div>
                        ${detailsSection}
                        <a href="/catalogo/${data.slug}" class="product-modal__btn">Ver producto completo</a>
                    </div>
                </div>
            `;
            
            quickViewModal.classList.add('open');
            document.body.style.overflow = 'hidden';
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar el producto');
        });
};

// Cerrar modal
if (quickViewClose) {
    quickViewClose.addEventListener('click', function() {
        quickViewModal.classList.remove('open');
        document.body.style.overflow = '';
    });
}

// Cerrar al hacer clic fuera
if (quickViewModal) {
    quickViewModal.addEventListener('click', function(e) {
        if (e.target === quickViewModal) {
            quickViewModal.classList.remove('open');
            document.body.style.overflow = '';
        }
    });
}

// Cerrar con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && quickViewModal && quickViewModal.classList.contains('open')) {
        quickViewModal.classList.remove('open');
        document.body.style.overflow = '';
    }
});
</script>

{{-- Modal de Vista Rápida --}}
<div id="quick-view-modal" class="quick-view-modal">
    <div class="quick-view-modal__backdrop"></div>
    <div class="quick-view-modal__container">
        <button id="quick-view-close" class="quick-view-modal__close" aria-label="Cerrar">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
        <div id="quick-view-content" class="quick-view-modal__content">
            {{-- Contenido cargado dinámicamente --}}
        </div>
    </div>
</div>

@endsection