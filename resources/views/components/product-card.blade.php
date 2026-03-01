<article class="product-card">
    <div class="product-card__img">
        @if($producto->image)
            <img src="{{ asset('storage/' . $producto->image) }}"
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

        <div class="product-card__footer">
            <div>
                @if($producto->has_promotion)
                    <small>Precio</small>
                    <span class="product-card__price" style="text-decoration:line-through;color:var(--text-3);font-size:0.85em;">
                        ${{ number_format($producto->price, 0, ',', '.') }}
                    </span>
                    <div>
                        <small>Con promo:</small>
                        <span class="product-card__price">
                            ${{ number_format($producto->final_price, 0, ',', '.') }}
                        </span>
                    </div>
                @else
                    <small>Precio</small>
                    <span class="product-card__price">
                        ${{ number_format($producto->price, 0, ',', '.') }}
                    </span>
                @endif
            </div>

            <a href="{{ route('producto.show', $producto->slug) }}" class="product-card__cta">
                Ver más
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>
    </div>
</article>