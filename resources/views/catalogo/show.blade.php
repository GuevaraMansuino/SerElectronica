@extends('layouts.app')

@section('title', $producto->name . ' – SER Electrónica')
@section('meta_description', Str::limit($producto->description, 155))

@push('styles')
<style>
/* ================================================================
   PRODUCTO DETALLE
================================================================ */
.page-banner {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 2.5rem 5vw;
}

.page-banner__inner { max-width: 1320px; margin: 0 auto; }

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.78rem;
    color: var(--text-3);
    flex-wrap: wrap;
}

.breadcrumb a { color: var(--text-2); transition: color var(--t); }
.breadcrumb a:hover { color: var(--lime); }
.breadcrumb span { color: var(--lime); }

/* ================================================================
   PRODUCT LAYOUT
================================================================ */
.product-layout {
    display: grid;
    grid-template-columns: 1.05fr 1fr;
    gap: 4.5rem;
    max-width: 1320px;
    margin: 0 auto;
    padding: 4rem 5vw 5rem;
    align-items: start;
}

/* ================================================================
   GALERÍA
================================================================ */
.gallery {}

.gallery__main {
    aspect-ratio: 4 / 3;
    border-radius: var(--radius-xl);
    overflow: hidden;
    background: var(--surface);
    border: 1px solid var(--border-solid);
    position: relative;
}

.gallery__main img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: opacity 0.2s ease;
}

/* Navigation arrows */
.gallery__nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid var(--border-solid);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all var(--t);
    color: var(--text-2);
    z-index: 10;
}

.gallery__nav:hover {
    background: var(--lime);
    color: var(--bg);
    border-color: var(--lime);
}

.gallery__nav--prev { left: 12px; }
.gallery__nav--next { right: 12px; }

/* Placeholder sin imagen */
.gallery__placeholder {
    width: 100%; height: 100%;
    display: grid;
    place-items: center;
    font-size: 5rem;
    color: var(--text-3);
}

/* Badge nuevo */
.gallery__badge {
    position: absolute;
    top: 14px; left: 14px;
    background: var(--lime);
    color: var(--bg);
    font-family: var(--font-mono);
    font-size: 0.62rem;
    font-weight: 500;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 3px;
}

/* Corner decorators */
.gallery__corners { position: absolute; inset: 0; pointer-events: none; }

.gallery__corner {
    position: absolute;
    width: 20px; height: 20px;
    border-color: var(--lime);
    border-style: solid;
    opacity: 0.5;
}

.gallery__corner--tl { top: 10px; left: 10px; border-width: 2px 0 0 2px; }
.gallery__corner--tr { top: 10px; right: 10px; border-width: 2px 2px 0 0; }
.gallery__corner--bl { bottom: 10px; left: 10px; border-width: 0 0 2px 2px; }
.gallery__corner--br { bottom: 10px; right: 10px; border-width: 0 2px 2px 0; }

/* Thumbnails */
.gallery__thumbnails {
    display: flex;
    gap: 0.75rem;
    margin-top: 1rem;
    overflow-x: auto;
    padding: 4px;
}

.gallery__thumb {
    flex-shrink: 0;
    width: 72px;
    height: 72px;
    border-radius: var(--radius);
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all var(--t);
    background: var(--surface);
}

.gallery__thumb:hover {
    border-color: var(--text-3);
}

.gallery__thumb.active {
    border-color: var(--lime);
}

.gallery__thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ================================================================
   PRODUCT INFO
================================================================ */
.product-info {}

.product-info__cat {
    font-family: var(--font-mono);
    font-size: 0.68rem;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    color: var(--lime);
    margin-bottom: 0.7rem;
}

.product-info__name {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3.2rem);
    font-weight: 800;
    letter-spacing: 0.02em;
    line-height: 1;
    color: var(--text);
    margin-bottom: 1.5rem;
}

/* Price block */
.price-block {
    background: var(--surface);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.price-block::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: var(--lime);
    border-radius: 0 2px 2px 0;
}

.price-block__value {
    font-family: var(--font-display);
    font-size: 3rem;
    font-weight: 800;
    color: var(--lime);
    letter-spacing: 0.02em;
    line-height: 1;
}

.price-block__label {
    font-family: var(--font-mono);
    font-size: 0.62rem;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: var(--text-3);
    display: block;
    margin-bottom: 4px;
}

.price-block__note {
    text-align: right;
    font-size: 0.78rem;
    color: var(--text-3);
    max-width: 140px;
    line-height: 1.4;
}

/* Description */
.product-info__desc {
    font-size: 0.95rem;
    color: var(--text-2);
    line-height: 1.8;
    margin-bottom: 2rem;
    font-weight: 300;
}

/* Actions */
.product-actions {
    display: flex;
    flex-direction: column;
    gap: 0.9rem;
    margin-bottom: 2.2rem;
}

.btn-whatsapp {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 14px 24px;
    background: #25D366;
    color: #fff;
    border: none;
    border-radius: var(--radius);
    font-size: 0.95rem;
    font-weight: 700;
    font-family: var(--font-body);
    letter-spacing: 0.05em;
    cursor: pointer;
    transition: all var(--t);
    text-decoration: none;
}

.btn-whatsapp:hover {
    background: #1daa53;
    box-shadow: 0 8px 24px rgba(37,211,102,0.3);
    transform: translateY(-2px);
}

.btn-call {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    background: transparent;
    color: var(--text-2);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius);
    font-size: 0.88rem;
    font-weight: 600;
    font-family: var(--font-body);
    cursor: pointer;
    transition: all var(--t);
    text-decoration: none;
}

.btn-call:hover {
    border-color: var(--lime);
    color: var(--lime);
    background: var(--lime-dim);
}

/* Specs */
.specs-block {
    background: var(--surface);
    border: 1px solid var(--border-solid);
    border-radius: var(--radius-lg);
    overflow: hidden;
}

.specs-block__header {
    padding: 0.9rem 1.3rem;
    border-bottom: 1px solid var(--border-solid);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--surface-2);
}

.specs-block__header svg { color: var(--lime); }

.specs-block__title {
    font-family: var(--font-mono);
    font-size: 0.65rem;
    text-transform: uppercase;
    letter-spacing: 0.18em;
    color: var(--lime);
}

.spec-row {
    display: grid;
    grid-template-columns: 1fr 1.5fr;
    gap: 1rem;
    padding: 0.85rem 1.3rem;
    border-bottom: 1px solid var(--border-solid);
    font-size: 0.86rem;
}

.spec-row:last-child { border-bottom: none; }

.spec-key { color: var(--text-3); }
.spec-val { color: var(--text); font-weight: 500; }

.spec-val.available {
    color: var(--lime);
    display: flex;
    align-items: center;
    gap: 5px;
}

.spec-val.available::before {
    content: '';
    width: 7px; height: 7px;
    background: var(--lime);
    border-radius: 50%;
    display: inline-block;
    animation: pulse-dot 2s ease infinite;
}

/* ================================================================
   RELACIONADOS
================================================================ */
.related-section {
    background: var(--surface);
    border-top: 1px solid var(--border);
    padding: 5rem 5vw;
}

.related-inner { max-width: 1320px; margin: 0 auto; }

.related-header { margin-bottom: 2.5rem; }

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(252px, 1fr));
    gap: 1.3rem;
}

/* ================================================================
   RESPONSIVE
================================================================ */
@media (max-width: 960px) {
    .product-layout { grid-template-columns: 1fr; gap: 2.5rem; }
}
</style>
@endpush

@section('content')

{{-- BANNER --}}
<div class="page-banner">
    <div class="page-banner__inner">
        <nav class="breadcrumb" aria-label="Migas de pan">
            <a href="{{ route('home') }}">Inicio</a>
            <span>›</span>
            <a href="{{ route('catalogo.index') }}">Catálogo</a>
            <span>›</span>
            <a href="{{ route('catalogo.index', ['categoria' => $producto->category->slug]) }}">
                {{ $producto->category->name }}
            </a>
            <span>›</span>
            <span>{{ $producto->name }}</span>
        </nav>
    </div>
</div>

{{-- PRODUCT --}}
<div class="product-layout">

    {{-- GALLERY --}}
    <div class="gallery">
        <div class="gallery__main">
            @php
                // Combinar imagen principal + gallery images
                $allImages = collect();
                if($producto->image) {
                    $allImages->push(['path' => $producto->image, 'is_primary' => true]);
                }
                foreach($producto->images as $img) {
                    $allImages->push(['path' => $img->image_path, 'is_primary' => false]);
                }
            @endphp
            
            @if($allImages->count() > 0)
                <img src="{{ asset('storage/' . $allImages[0]['path']) }}"
                     alt="{{ $producto->name }}" id="main-img">
                
                @if($allImages->count() > 1)
                <button class="gallery__nav gallery__nav--prev" onclick="changeImage(-1)" aria-label="Imagen anterior">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button class="gallery__nav gallery__nav--next" onclick="changeImage(1)" aria-label="Siguiente imagen">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                </button>
                @endif
            @else
                <div class="gallery__placeholder">📦</div>
            @endif

            @if($producto->is_new)
                <span class="gallery__badge">Nuevo</span>
            @endif

            <div class="gallery__corners" aria-hidden="true">
                <span class="gallery__corner gallery__corner--tl"></span>
                <span class="gallery__corner gallery__corner--tr"></span>
                <span class="gallery__corner gallery__corner--bl"></span>
                <span class="gallery__corner gallery__corner--br"></span>
            </div>
        </div>

        {{-- Thumbnails --}}
        @if($allImages->count() > 1)
        <div class="gallery__thumbnails">
            @foreach($allImages as $index => $img)
            <button class="gallery__thumb {{ $index === 0 ? 'active' : '' }}" 
                    onclick="selectImage({{ $index }})" 
                    aria-label="Ver imagen {{ $index + 1 }}">
                <img src="{{ asset('storage/' . $img['path']) }}" alt="Miniatura {{ $index + 1 }}">
            </button>
            @endforeach
        </div>
        @endif
    </div>

    {{-- INFO --}}
    <div class="product-info">
        <p class="product-info__cat">{{ $producto->category->name }}</p>
        <h1 class="product-info__name">{{ strtoupper($producto->name) }}</h1>

        <div class="price-block">
            <div>
                <span class="price-block__label">Precio</span>
                <span class="price-block__value">${{ number_format($producto->price, 0, ',', '.') }}</span>
            </div>
            <p class="price-block__note">Para consultas escríbanos por WhatsApp</p>
        </div>

        <p class="product-info__desc">{{ $producto->description }}</p>

        <div class="product-actions">
            <a href="https://wa.me/5492613372353?text=Hola!+Me+interesa+el+producto:+{{ urlencode($producto->name) }}"
               target="_blank" rel="noopener"
               class="btn-whatsapp">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.118 1.528 5.852L.054 23.948l6.257-1.64A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.878 0-3.642-.493-5.163-1.354l-.37-.22-3.838 1.006 1.024-3.74-.241-.385A9.955 9.955 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                </svg>
                Consultar por WhatsApp
            </a>
            <a href="tel:02613372353" class="btn-call">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11.5a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .84h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.09a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0121.15 15l.77 1.92z"/></svg>
                Llamar: 0261 337-2353
            </a>
        </div>

        {{-- Specs --}}
        <div class="specs-block">
            <div class="specs-block__header">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                <span class="specs-block__title">Ficha del producto</span>
            </div>

            <div class="spec-row">
                <span class="spec-key">Categoría</span>
                <span class="spec-val">{{ $producto->category->name }}</span>
            </div>
            @if($producto->marca)
            <div class="spec-row">
                <span class="spec-key">Marca</span>
                <span class="spec-val">{{ $producto->marca }}</span>
            </div>
            @endif
            @if($producto->modelo)
            <div class="spec-row">
                <span class="spec-key">Modelo</span>
                <span class="spec-val">{{ $producto->modelo }}</span>
            </div>
            @endif
            <div class="spec-row">
                <span class="spec-key">Disponibilidad</span>
                <span class="spec-val available">Consultar en tienda</span>
            </div>
            <div class="spec-row">
                <span class="spec-key">Ubicación</span>
                <span class="spec-val">Lavalle 299, Mendoza</span>
            </div>
        </div>
    </div>
</div>

{{-- RELACIONADOS --}}
@if($relacionados->count() > 0)
<section class="related-section" aria-labelledby="related-heading">
    <div class="related-inner">
        <div class="related-header">
            <span class="sec-label">También te puede interesar</span>
            <h2 class="sec-title" id="related-heading">PRODUCTOS<br>RELACIONADOS</h2>
        </div>

        <div class="products-grid">
            @foreach($relacionados as $rel)
            <article class="product-card">
                <div class="product-card__img">
                    @if($rel->imagen)
                        <img src="{{ asset('storage/'.$rel->imagen) }}" alt="{{ $rel->nombre }}" loading="lazy">
                    @else
                        <div style="display:grid;place-items:center;height:100%;font-size:2.5rem;color:var(--text-3)">📦</div>
                    @endif
                </div>
                <div class="product-card__body">
                    <span class="product-card__cat">{{ $rel->categoria->nombre }}</span>
                    <h3 class="product-card__name">{{ $rel->nombre }}</h3>
                    <p class="product-card__desc">{{ Str::limit($rel->descripcion, 80) }}</p>
                    <div class="product-card__footer">
                        <div>
                            <small>Precio</small>
                            <span class="product-card__price">${{ number_format($rel->precio, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('catalogo.show', $rel->slug) }}" class="product-card__cta">
                            Ver más
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
// Image gallery data
const imageUrls = [
    @foreach($allImages as $img)
    '{{ asset('storage/' . $img['path']) }}',
    @endforeach
];

let currentImageIndex = 0;

// Change image by direction (prev/next buttons)
function changeImage(direction) {
    currentImageIndex += direction;
    
    // Wrap around
    if (currentImageIndex < 0) {
        currentImageIndex = imageUrls.length - 1;
    } else if (currentImageIndex >= imageUrls.length) {
        currentImageIndex = 0;
    }
    
    updateMainImage();
}

// Select specific image by index (thumbnail click)
function selectImage(index) {
    currentImageIndex = index;
    updateMainImage();
}

// Update main image and thumbnail active state
function updateMainImage() {
    const mainImg = document.getElementById('main-img');
    if (mainImg && imageUrls[currentImageIndex]) {
        mainImg.src = imageUrls[currentImageIndex];
    }
    
    // Update thumbnail active state
    const thumbs = document.querySelectorAll('.gallery__thumb');
    thumbs.forEach((thumb, index) => {
        if (index === currentImageIndex) {
            thumb.classList.add('active');
        } else {
            thumb.classList.remove('active');
        }
    });
}
</script>
@endpush