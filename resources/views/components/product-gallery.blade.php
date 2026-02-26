@props([
    'images' => [],
    'productName' => '',
    'isNew' => false,
    'showThumbnails' => true
])

{{--
    Uso:
    @include('components.product-gallery', [
        'images' => $product->images->pluck('image_path')->toArray(),
        'productName' => $product->name,
        'isNew' => $product->is_new,
        'showThumbnails' => true
    ])
    
    Con imagen única:
    @include('components.product-gallery', [
        'images' => [$product->image],
        'productName' => $product->name
    ])
--}}

<div class="gallery">
    {{-- Main Image --}}
    <div class="gallery__main">
        @if(count($images) > 0)
            <img src="{{ $images[0] }}" alt="{{ $productName }}" id="gallery-main-image">
        @else
            <div class="gallery__placeholder">📷</div>
        @endif
        
        {{-- Navigation Arrows --}}
        @if(count($images) > 1)
            <button class="gallery__nav gallery__nav--prev" onclick="changeImage(-1)" aria-label="Imagen anterior">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </button>
            <button class="gallery__nav gallery__nav--next" onclick="changeImage(1)" aria-label="Imagen siguiente">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 18l6-6-6-6"/>
                </svg>
            </button>
        @endif
        
        {{-- Badge Nuevo --}}
        @if($isNew)
            <span class="gallery__badge">Nuevo</span>
        @endif
        
        {{-- Corner Decorators --}}
        <div class="gallery__corners">
            <span class="gallery__corner gallery__corner--tl"></span>
            <span class="gallery__corner gallery__corner--tr"></span>
            <span class="gallery__corner gallery__corner--bl"></span>
            <span class="gallery__corner gallery__corner--br"></span>
        </div>
    </div>
    
    {{-- Thumbnails --}}
    @if($showThumbnails && count($images) > 1)
        <div class="gallery__thumbnails">
            @foreach($images as $index => $image)
                <button class="gallery__thumb {{ $index === 0 ? 'active' : '' }}" 
                        onclick="selectImage({{ $index }})"
                        aria-label="Ver imagen {{ $index + 1 }}">
                    <img src="{{ $image }}" alt="{{ $productName }} - Imagen {{ $index + 1 }}">
                </button>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
    let currentImageIndex = 0;
    const images = @json($images);
    
    function changeImage(direction) {
        currentImageIndex += direction;
        if (currentImageIndex < 0) currentImageIndex = images.length - 1;
        if (currentImageIndex >= images.length) currentImageIndex = 0;
        updateGallery();
    }
    
    function selectImage(index) {
        currentImageIndex = index;
        updateGallery();
    }
    
    function updateGallery() {
        const mainImage = document.getElementById('gallery-main-image');
        if (mainImage && images[currentImageIndex]) {
            mainImage.src = images[currentImageIndex];
        }
        
        // Update thumbnails
        document.querySelectorAll('.gallery__thumb').forEach((thumb, index) => {
            thumb.classList.toggle('active', index === currentImageIndex);
        });
    }
</script>
@endpush
