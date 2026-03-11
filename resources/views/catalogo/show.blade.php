@extends('layouts.app')

@section('title', $producto->name . ' – SER Electrónica')
@section('meta_description', Str::limit($producto->description, 155))

@push('css')
<link rel="stylesheet" href="{{ asset('css/producto-detalle.css') }}">
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
                @if($producto->has_promotion)
                    <span class="price-block__original">${{ number_format($producto->price, 0, ',', '.') }}</span>
                    <div class="price-block__promo">${{ number_format($producto->final_price, 0, ',', '.') }}</div>
                    <span class="price-block__badge">{{ $producto->promotion_title }}</span>
                @else
                    <span class="price-block__value">${{ number_format($producto->price, 0, ',', '.') }}</span>
                @endif
            </div>
            <p class="price-block__note">Para consultas escríbanos por WhatsApp</p>
        </div>

        {{-- Aviso de precios --}}
        <div class="price-notice">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span><strong>Precio de contado/transferencia.</strong></span>
        </div>

        <div class= "price-notice">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span><strong>Los precios pueden variar.</strong> Son precios de <strong>Lista</strong> sujetos a cambios sin previo aviso.</span>
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
                    <div class="product-card__footer">
                        <div>
                            <small>Precio</small>
                            <span class="product-card__price">${{ number_format($rel->precio, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('producto.show', $rel->slug) }}" class="product-card__cta">
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