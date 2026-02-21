@extends('layouts.app')

@section('title', 'Promociones – SER Electrónica')
@section('meta_description', 'Promociones y ofertas activas en SER Electrónica. Audio, equipos y tecnología con los mejores precios en Mendoza.')

@push('styles')
<style>
/* ================================================================
   PROMOCIONES — PÁGINA PÚBLICA
================================================================ */

.page-banner {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 3.5rem 5vw 3rem;
}

.page-banner__inner {
    max-width: 1320px;
    margin: 0 auto;
}

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
   GRID DE PROMOCIONES
================================================================ */
.promos-section {
    max-width: 1320px;
    margin: 0 auto;
    padding: 4rem 5vw 6rem;
}

/* Grid masonry-like con primera card grande */
.promos-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.4rem;
}

/* Primera card ocupa 2 columnas */
.promos-grid .promo-card:first-child {
    grid-column: span 2;
}

.promo-card {
    background: var(--surface);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius-xl);
    overflow: hidden;
    position: relative;
    display: flex;
    flex-direction: column;
    transition: all var(--t);
    min-height: 280px;
}

.promo-card:hover {
    border-color: var(--lime);
    transform: translateY(-5px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.4), 0 0 0 1px rgba(182,255,59,0.15);
}

/* Background de imagen --*/
.promo-card__bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0.12;
    transition: opacity var(--t);
}

.promo-card:hover .promo-card__bg { opacity: 0.18; }

/* Glow decorativo */
.promo-card__glow {
    position: absolute;
    top: -60px;
    right: -60px;
    width: 240px;
    height: 240px;
    background: radial-gradient(circle, rgba(182,255,59,0.07) 0%, transparent 60%);
    pointer-events: none;
}

/* Contenido */
.promo-card__body {
    position: relative;
    z-index: 1;
    padding: 2rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.promo-card__tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: var(--lime);
    color: var(--bg);
    font-family: var(--font-mono);
    font-size: 0.62rem;
    font-weight: 500;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    padding: 4px 11px;
    border-radius: 3px;
    align-self: flex-start;
    margin-bottom: 1rem;
}

.promo-card__tag-dot {
    width: 6px; height: 6px;
    background: var(--bg);
    border-radius: 50%;
    animation: pulse-dot 2s ease infinite;
}

@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.4; transform: scale(0.7); }
}

.promo-card__title {
    font-family: var(--font-display);
    font-size: clamp(1.5rem, 3vw, 2.2rem);
    font-weight: 800;
    letter-spacing: 0.03em;
    line-height: 1.05;
    color: var(--text);
    margin-bottom: 0.8rem;
}

/* Card grande: título más grande */
.promos-grid .promo-card:first-child .promo-card__title {
    font-size: clamp(2rem, 4vw, 3rem);
}

.promo-card__desc {
    font-size: 0.9rem;
    color: var(--text-2);
    line-height: 1.7;
    flex: 1;
    margin-bottom: 1.5rem;
    font-weight: 300;
}

.promo-card__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 1.2rem;
    border-top: 1px solid var(--border-solid);
    gap: 1rem;
    flex-wrap: wrap;
}

.promo-card__vence {
    font-family: var(--font-mono);
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: var(--text-3);
}

.promo-card__vence-date {
    color: var(--text-2);
    display: block;
    margin-top: 1px;
}

/* ================================================================
   ESTADO VACÍO
================================================================ */
.empty-promos {
    text-align: center;
    padding: 6rem 2rem;
    grid-column: 1 / -1;
}

.empty-promos__icon { font-size: 4rem; margin-bottom: 1rem; }
.empty-promos h2 {
    font-family: var(--font-display);
    font-size: 2rem;
    color: var(--text-2);
    margin-bottom: 0.5rem;
}

.empty-promos p {
    font-size: 0.95rem;
    color: var(--text-3);
    margin-bottom: 2rem;
}

/* ================================================================
   CTA CONTACTO
================================================================ */
.contact-cta {
    background: var(--surface);
    border-top: 1px solid var(--border);
    padding: 5rem 5vw;
    text-align: center;
}

.contact-cta__inner {
    max-width: 600px;
    margin: 0 auto;
}

.contact-cta__title {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    letter-spacing: 0.04em;
    color: var(--text);
    margin-bottom: 0.8rem;
}

.contact-cta__sub {
    font-size: 0.95rem;
    color: var(--text-2);
    line-height: 1.7;
    margin-bottom: 2rem;
}

.contact-cta__actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

/* ================================================================
   RESPONSIVE
================================================================ */
@media (max-width: 900px) {
    .promos-grid {
        grid-template-columns: 1fr 1fr;
    }
    .promos-grid .promo-card:first-child {
        grid-column: span 2;
    }
}

@media (max-width: 600px) {
    .promos-grid {
        grid-template-columns: 1fr;
    }
    .promos-grid .promo-card:first-child {
        grid-column: span 1;
    }
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
            <span>Promociones</span>
        </nav>
        <span class="sec-label">Ofertas activas</span>
        <h1 class="sec-title">PROMOCIONES</h1>
    </div>
</div>

{{-- GRILLA DE PROMOS --}}
<section class="promos-section" aria-labelledby="promos-heading">

    @if($promociones->count() > 0)
    <div class="promos-grid">
        @foreach($promociones as $promo)
        <article class="promo-card">
            {{-- Fondo imagen si tiene --}}
            @if($promo->image)
            <div class="promo-card__bg"
                 style="background-image: url('{{ asset('storage/' . $promo->image) }}')"
                 aria-hidden="true">
            </div>
            @endif

            <div class="promo-card__glow" aria-hidden="true"></div>

            <div class="promo-card__body">
                <span class="promo-card__tag">
                    <span class="promo-card__tag-dot" aria-hidden="true"></span>
                    Promo activa
                </span>

                <h2 class="promo-card__title">{{ $promo->title }}</h2>
                <p class="promo-card__desc">{{ $promo->description }}</p>

                <div class="promo-card__footer">
                    <div>
                        @if($promo->end_date)
                            <span class="promo-card__vence">
                                Válida hasta
                                <span class="promo-card__vence-date">
                                    {{ $promo->end_date->format('d \d\e F \d\e Y') }}
                                </span>
                            </span>
                        @else
                            <span class="promo-card__vence">
                                Vigencia
                                <span class="promo-card__vence-date">Indefinida</span>
                            </span>
                        @endif
                    </div>

                    <a href="https://wa.me/5492613372353?text=Hola!+Quiero+consultar+sobre+la+promo:+{{ urlencode($promo->title) }}"
                       target="_blank"
                       rel="noopener"
                       class="btn btn-lime"
                       style="font-size:0.82rem;padding:9px 18px;">
                        Consultar promo →
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    {{-- PRODUCTOS EN PROMOCIÓN --}}
    @if($productosEnPromo->count() > 0)
    <div style="margin-top:4rem;">
        <h2 style="font-family:var(--font-display);font-size:1.8rem;margin-bottom:1.5rem;color:var(--text);">
            📦 Productos en Promoción
        </h2>
        <div class="products-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.5rem;">
            @foreach($productosEnPromo as $producto)
            <article class="product-card">
                <a href="{{ route('producto.show', $producto->slug) }}" class="product-card__img">
                    @if($producto->image)
                    <img src="{{ asset('storage/'.$producto->image) }}" alt="{{ $producto->name }}" loading="lazy">
                    @else
                    <div class="product-card__placeholder">📷</div>
                    @endif
                    @if($producto->is_new)
                    <span class="product-card__badge">NUEVO</span>
                    @endif
                    @if($producto->has_promotion)
                    <span class="product-card__tag">
                        <span class="product-card__tag-dot"></span>
                        OFERTA
                    </span>
                    @endif
                </a>
                <div class="product-card__content">
                    <div class="product-card__cat">{{ $producto->category->name ?? 'Sin categoría' }}</div>
                    <h3 class="product-card__title">
                        <a href="{{ route('producto.show', $producto->slug) }}">{{ $producto->name }}</a>
                    </h3>
                    @if($producto->marca)
                    <div class="product-card__marca">{{ $producto->marca }}</div>
                    @endif
                    <div class="product-card__price">
                        @if($producto->has_promotion && $producto->final_price < $producto->price)
                        <span class="price-original">${{ number_format($producto->price, 0, ',', '.') }}</span>
                        <span class="price-final">${{ number_format($producto->final_price, 0, ',', '.') }}</span>
                        <span class="price-discount">-{{ round(($producto->price - $producto->final_price) / $producto->price * 100) }}%</span>
                        @else
                        <span class="price-final">${{ number_format($producto->price, 0, ',', '.') }}</span>
                        @endif
                    </div>
                    <a href="{{ route('producto.show', $producto->slug) }}" class="btn btn-outline" style="width:100%;justify-content:center;margin-top:0.8rem;">
                        Ver producto
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
    @endif

    @elseif($productosEnPromo->count() > 0)
    {{-- Hay productos en promo pero sin promos activas definidas --}}
    <div style="margin-top:2rem;">
        <h2 style="font-family:var(--font-display);font-size:1.8rem;margin-bottom:1.5rem;color:var(--text);">
            📦 Productos en Oferta
        </h2>
        <div class="products-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.5rem;">
            @foreach($productosEnPromo as $producto)
            <article class="product-card">
                <a href="{{ route('producto.show', $producto->slug) }}" class="product-card__img">
                    @if($producto->image)
                    <img src="{{ asset('storage/'.$producto->image) }}" alt="{{ $producto->name }}" loading="lazy">
                    @else
                    <div class="product-card__placeholder">📷</div>
                    @endif
                    @if($producto->is_new)
                    <span class="product-card__badge">NUEVO</span>
                    @endif
                    @if($producto->has_promotion)
                    <span class="product-card__tag">
                        <span class="product-card__tag-dot"></span>
                        OFERTA
                    </span>
                    @endif
                </a>
                <div class="product-card__content">
                    <div class="product-card__cat">{{ $producto->category->name ?? 'Sin categoría' }}</div>
                    <h3 class="product-card__title">
                        <a href="{{ route('producto.show', $producto->slug) }}">{{ $producto->name }}</a>
                    </h3>
                    @if($producto->marca)
                    <div class="product-card__marca">{{ $producto->marca }}</div>
                    @endif
                    <div class="product-card__price">
                        @if($producto->has_promotion && $producto->final_price < $producto->price)
                        <span class="price-original">${{ number_format($producto->price, 0, ',', '.') }}</span>
                        <span class="price-final">${{ number_format($producto->final_price, 0, ',', '.') }}</span>
                        <span class="price-discount">-{{ round(($producto->price - $producto->final_price) / $producto->price * 100) }}%</span>
                        @else
                        <span class="price-final">${{ number_format($producto->price, 0, ',', '.') }}</span>
                        @endif
                    </div>
                    <a href="{{ route('producto.show', $producto->slug) }}" class="btn btn-outline" style="width:100%;justify-content:center;margin-top:0.8rem;">
                        Ver producto
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
    @else
    {{-- Estado vacío --}}
    <div class="empty-promos">
        <div class="empty-promos__icon">🎁</div>
        <h2>No hay promociones activas</h2>
        <p>Por el momento no tenemos promos activas, pero podés consultar nuestros precios directamente.</p>
        <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;">
            <a href="{{ route('catalogo.index') }}" class="btn btn-lime">Ver catálogo</a>
            <a href="https://wa.me/5492613372353" target="_blank" rel="noopener" class="btn btn-outline">
                Consultar por WhatsApp
            </a>
        </div>
    </div>
    @endif

</section>

{{-- CTA CONTACTO --}}
<section class="contact-cta" aria-labelledby="cta-heading">
    <div class="contact-cta__inner">
        <h2 class="contact-cta__title" id="cta-heading">
            ¿QUERÉS MÁS<br>INFORMACIÓN?
        </h2>
        <p class="contact-cta__sub">
            Consultanos por WhatsApp o teléfono. Nuestro equipo te asesora sin compromiso sobre cualquier producto o promoción.
        </p>
        <div class="contact-cta__actions">
            <a href="https://wa.me/5492613372353?text=Hola!+Quiero+consultar+sobre+sus+promociones"
               target="_blank"
               rel="noopener"
               class="btn btn-lime">
                <svg width="17" height="17" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5 -.669 -.5 . - . - . - . - . - . - . - . - . - . - . - . - . - . - . - . - . - . - . - .

                    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.852L.054 23.948l6.257-1.64A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.878 0-3.642-.493-5.163-1.354l-.37-.22-3.838 1.006 1.024-3.74-.241-.385A9.955 9.955 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                </svg>
                Consultar por WhatsApp
            </a>
            <a href="tel:02613372353" class="btn btn-outline">
                📞 0261 337-2353
            </a>
            <a href="{{ route('catalogo.index') }}" class="btn btn-outline">
                Ver catálogo completo
            </a>
        </div>
    </div>
</section>

@endsection