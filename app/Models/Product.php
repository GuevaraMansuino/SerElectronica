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
        'thumbnail_url',
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
        return $query->with(['category', 'promotions', 'category.promotions']);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para búsqueda avanzada de productos
     * - Búsqueda parcial en múltiples campos
     * - Expansión de sinónimos
     * - Búsqueda fuzzy (tolerante a errores menores)
     */
    public function scopeSearch($query, $searchTerm)
    {
        if (!$searchTerm) return $query;
        
        $term = trim($searchTerm);
        $termLower = mb_strtolower($term);
        
        // Obtener términos expandidos (sinónimos)
        $expandedTerms = $this->expandSearchTerms($termLower);
        
        // Agregar el término original a los expandidos
        array_unshift($expandedTerms, $termLower);
        
        // Eliminar duplicados
        $expandedTerms = array_unique($expandedTerms);
        
        return $query->where(function($q) use ($term, $termLower, $expandedTerms) {
            // 1. BÚSQUEDA EXACTA EN NOMBRE (máxima prioridad)
            $q->where(function($nameQuery) use ($term, $termLower) {
                $nameQuery
                    ->where('name', 'LIKE', "{$term}%")  // Comienza con
                    ->orWhere('name', 'LIKE', "%{$term}%");  // Contiene
            });
            
            // 2. BÚSQUEDA EN MARCA
            $q->orWhere(function($marcaQuery) use ($termLower) {
                $marcaQuery
                    ->where('marca', 'LIKE', "{$termLower}%")
                    ->orWhere('marca', 'LIKE', "%{$termLower}%");
            });
            
            // 3. BÚSQUEDA EN MODELO
            $q->orWhere(function($modeloQuery) use ($termLower) {
                $modeloQuery
                    ->where('modelo', 'LIKE', "{$termLower}%")
                    ->orWhere('modelo', 'LIKE', "%{$termLower}%");
            });
            
            // 4. BÚSQUEDA EN NOMBRE DE CATEGORÍA (usando sinónimos)
            $q->orWhereHas('category', function($categoryQuery) use ($expandedTerms) {
                $categoryQuery->where(function($catTermQuery) use ($expandedTerms) {
                    foreach ($expandedTerms as $synTerm) {
                        $catTermQuery->orWhere('name', 'LIKE', "%{$synTerm}%");
                    }
                });
            });
            
            // 5. BÚSQUEDA EN DESCRIPCIÓN (menor prioridad)
            $q->orWhere(function($descQuery) use ($expandedTerms) {
                foreach ($expandedTerms as $synTerm) {
                    $descQuery->orWhere('description', 'LIKE', "%{$synTerm}%");
                }
            });
            
            // 6. BÚSQUEDA FUZZY: términos similares (usando función de MySQL)
            // Esto encuentra "repe" aunque escriba "repee" o "repi"
            $q->orWhereRaw(
                "(name LIKE ? OR marca LIKE ? OR modelo LIKE ?)",
                ["%{$term}%", "%{$term}%", "%{$term}%"]
            );
        })
        // Ordenar por relevancia: nombre > marca > modelo > otros
        ->orderByRaw(
            "CASE 
                WHEN name LIKE ? THEN 1
                WHEN name LIKE ? THEN 2
                WHEN marca LIKE ? THEN 3
                WHEN marca LIKE ? THEN 4
                WHEN modelo LIKE ? THEN 5
                ELSE 6
            END",
            ["{$term}%", "%{$term}%", "{$term}%", "%{$term}%", "%{$term}%"]
        );
    }
    
    /**
     * Expandir términos de búsqueda usando sinónimos
     * Convierte "repe" en ["repe", "repetidor", "extensor", "amplificador", ...]
     */
    private function expandSearchTerms(string $term): array
    {
        $synonyms = config('search-synonyms', []);
        $expanded = [];
        
        // Buscar el término en las claves de sinónimos
        foreach ($synonyms as $key => $synonymList) {
            // Si el término coincide con una clave o está contenido en ella
            if ($term === $key || mb_strpos($key, $term) !== false || mb_strpos($term, $key) !== false) {
                // Agregar todos los sinónimos de esta clave
                $expanded = array_merge($expanded, $synonymList);
            }
            
            // También buscar en los valores (sinónimos)
            foreach ($synonymList as $synonym) {
                if ($term === $synonym || mb_strpos($synonym, $term) !== false || mb_strpos($term, $synonym) !== false) {
                    // Agregar la clave principal y todos los sinónimos
                    $expanded[] = $key;
                    $expanded = array_merge($expanded, $synonymList);
                }
            }
        }
        
        // Búsqueda de variaciones comunes (singular/plural, con/sin tilde)
        $variations = $this->getTermVariations($term);
        $expanded = array_merge($expanded, $variations);
        
        return array_unique($expanded);
    }
    
    /**
     * Generar variaciones de un término (singular/plural, con/sin tilde)
     */
    private function getTermVariations(string $term): array
    {
        $variations = [];
        
        // Agregar versión sin tildes
        $sinTildes = $this->removeAccents($term);
        if ($sinTildes !== $term) {
            $variations[] = $sinTildes;
        }
        
        // Agregar versión con tildes si no la tiene
        $conTildes = $this->addAccents($term);
        if ($conTildes !== $term) {
            $variations[] = $conTildes;
        }
        
        // Agregar versión singular/plural
        if (mb_substr($term, -1) === 's') {
            // Es plural, agregar singular
            $variations[] = mb_substr($term, 0, -1);
        } else {
            // Es singular, agregar plural
            $variations[] = $term . 's';
        }
        
        // Variaciones comunes en electrónica
        $termLower = mb_strtolower($term);
        if (in_array($termLower, ['wifi', 'usb', 'hdmi', 'led', 'tv', 'pc', 'dtf', 'rgb', '4k', '5g'])) {
            // Estos términos ya son estándar, no necesitan variación
        }
        
        return $variations;
    }
    
    /**
     * Remover acentos de un string
     */
    private function removeAccents(string $str): string
    {
        $accents = [
            'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
            'ñ' => 'n', 'Ñ' => 'N'
        ];
        return strtr($str, $accents);
    }
    
    /**
     * Agregar acentos a un string (versión simple)
     */
    private function addAccents(string $str): string
    {
        $accents = [
            'a' => 'á', 'e' => 'é', 'i' => 'í', 'o' => 'ó', 'u' => 'ú',
            'A' => 'Á', 'E' => 'É', 'I' => 'Í', 'O' => 'Ó', 'U' => 'Ú',
            'n' => 'ñ', 'N' => 'Ñ'
        ];
        return strtr($str, $accents);
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
        return $best ? $best['final_price'] : round($this->price ?? 0, 2);
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

        // Verificar si es el nuevo formato JSON con multiple tamanios
        $imageData = json_decode($this->image, true);
        
        if ($imageData && isset($imageData['medium'])) {
            // Nuevo formato: devuelve la version medium por defecto
            return asset('storage/' . $imageData['medium']);
        }

        // Formato legacy: ruta directa
        return asset('storage/' . $this->image);
    }

    /**
     * Obtener URL de thumbnail (300x300)
     */
    public function getThumbnailUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        $imageData = json_decode($this->image, true);
        
        if ($imageData && isset($imageData['thumb'])) {
            return asset('storage/' . $imageData['thumb']);
        }

        // Legacy: usar la imagen original
        return asset('storage/' . $this->image);
    }

    /**
     * Obtener URL de imagen grande (1200x1200)
     */
    public function getLargeImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        $imageData = json_decode($this->image, true);
        
        if ($imageData && isset($imageData['large'])) {
            return asset('storage/' . $imageData['large']);
        }

        // Legacy: usar la imagen original
        return asset('storage/' . $this->image);
    }

    /**
     * Obtener datos completos de imagen
     */
    public function getImageDataAttribute()
    {
        if (!$this->image) {
            return null;
        }

        return json_decode($this->image, true);
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
