<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
use App\Models\Promotion;

class Product extends Model
{
    use HasFactory;

    // Caché en memoria para la mejor promoción (se calcula solo una vez)
    protected ?array $_bestPromotionCache = null;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'is_active',
        'is_new',
        'destacado',
        'marca',
        'modelo',
    ];

    protected $appends = [
        // Solo atributos necesarios para la vista pública
        'final_price',
        'has_promotion',
        'promotion_id',
        'promotion_title',
        'discount_type',
        'discount_value',
        'image_url',
    ];

    protected $casts = [
        'is_new' => 'boolean',
        'is_active' => 'boolean',
        'destacado' => 'boolean'
    ];

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeWithRelations($query)
    {
        return $query->with(['category', 'promotions']);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Spanish alias for backward compatibility
    public function categoria()
    {
        return $this->belongsTo(Category::class);
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'product_promotion');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODO CENTRAL: OBTENER PROMOCIÓN (CON CACHÉ - solo 1 ejecución por producto)
    |--------------------------------------------------------------------------
    */

    /**
     * Obtener la mejor promoción (con caché para evitar ejecuciones múltiples)
     */
    private function getBestPromotion()
    {
        // Usar caché si ya se calculó
        if ($this->_bestPromotionCache !== null) {
            return $this->_bestPromotionCache;
        }
        
        $price = $this->price;
        $now = now();

        // 1. PRIMERO: Promociones directas activas (relación ya cargada)
        $directPromos = $this->promotions
            ?->filter(function ($promo) use ($now) {
                return $promo->is_active 
                    && ($promo->start_date === null || \Carbon\Carbon::parse($promo->start_date)->lte($now))
                    && ($promo->end_date === null || \Carbon\Carbon::parse($promo->end_date)->gte($now));
            }) ?? collect();

        // Si hay promociones directas, tomar la mejor
        if ($directPromos->isNotEmpty()) {
            $bestDirectPrice = $price;
            $bestDirectPromo = null;

            foreach ($directPromos as $promo) {
                $discounted = $price;

                if (!is_null($promo->discount_percentage)) {
                    $discounted -= $price * ($promo->discount_percentage / 100);
                }

                if (!is_null($promo->discount_amount)) {
                    $discounted -= $promo->discount_amount;
                }

                $discounted = max($discounted, 0);

                if ($discounted < $bestDirectPrice) {
                    $bestDirectPrice = $discounted;
                    $bestDirectPromo = $promo;
                }
            }

            if ($bestDirectPromo) {
                $this->_bestPromotionCache = [
                    'promotion' => $bestDirectPromo,
                    'final_price' => round($bestDirectPrice, 2),
                    'discount_value' => round($price - $bestDirectPrice, 2),
                ];
                return $this->_bestPromotionCache;
            }
        }

        // 2. SEGUNDO: Si no hay promos directas, buscar en la categoría
        $categoryPromos = $this->category
            ? $this->category->promotions
                ->filter(function ($promo) use ($now) {
                    return $promo->is_active 
                        && ($promo->start_date === null || \Carbon\Carbon::parse($promo->start_date)->lte($now))
                        && ($promo->end_date === null || \Carbon\Carbon::parse($promo->end_date)->gte($now));
                })
            : collect();

        if ($categoryPromos->isEmpty()) {
            $this->_bestPromotionCache = null;
            return null;
        }

        $bestPrice = $price;
        $bestPromo = null;

        foreach ($categoryPromos as $promo) {
            $discounted = $price;

            if (!is_null($promo->discount_percentage)) {
                $discounted -= $price * ($promo->discount_percentage / 100);
            }

            if (!is_null($promo->discount_amount)) {
                $discounted -= $promo->discount_amount;
            }

            $discounted = max($discounted, 0);

            if ($discounted < $bestPrice) {
                $bestPrice = $discounted;
                $bestPromo = $promo;
            }
        }

        if (!$bestPromo) {
            $this->_bestPromotionCache = null;
            return null;
        }

        $this->_bestPromotionCache = [
            'promotion' => $bestPromo,
            'final_price' => round($bestPrice, 2),
            'discount_value' => round($price - $bestPrice, 2),
        ];
        
        return $this->_bestPromotionCache;
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getFinalPriceAttribute()
    {
        $best = $this->getBestPromotion();
        return $best ? $best['final_price'] : round($this->price, 2);
    }

    public function getHasPromotionAttribute()
    {
        return $this->getBestPromotion() !== null;
    }

    public function getPromotionIdAttribute()
    {
        $best = $this->getBestPromotion();
        return $best ? $best['promotion']->id : null;
    }

    public function getPromotionTitleAttribute()
    {
        $best = $this->getBestPromotion();
        return $best ? $best['promotion']->title : null;
    }

    public function getDiscountTypeAttribute()
    {
        $best = $this->getBestPromotion();

        if (!$best) {
            return null;
        }

        $promo = $best['promotion'];

        return !is_null($promo->discount_percentage)
            ? 'percentage'
            : 'amount';
    }

    public function getDiscountValueAttribute()
    {
        $best = $this->getBestPromotion();
        return $best ? $best['discount_value'] : 0;
    }

    /*
    |--------------------------------------------------------------------------
    | IMAGE URL ACCESSOR
    |--------------------------------------------------------------------------
    */

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        // The image field already contains the full path (e.g., 'products/filename.jpg')
        return asset('storage/' . $this->image);
    }

    public function getMarcaAttribute()
    {
        return $this->attributes['marca'] ?? null;
    }

    public function getIsNewAttribute()
    {
        return $this->attributes['is_new'] ?? false;
    }

    // Spanish aliases for backward compatibility
    public function getNombreAttribute()
    {
        return $this->name;
    }

    public function getImagenAttribute()
    {
        return $this->image;
    }

    public function getPrecioAttribute()
    {
        return $this->price;
    }

    public function getDescripcionAttribute()
    {
        return $this->description;
    }

    public function getCategoriaAttribute()
    {
        return $this->category;
    }

    public function getActivoAttribute()
    {
        return $this->is_active ?? true;
    }

    public function getDestacadoAttribute()
    {
        return $this->attributes['destacado'] ?? false;
    }

    /**
     * Limpiar caché de promoción (usar después de actualizar el producto)
     */
    public function clearPromotionCache()
    {
        $this->_bestPromotionCache = null;
    }
}
