<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
use App\Models\Product;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
    'title',
    'description',
    'discount_percentage',
    'discount_amount',
    'start_date',
    'end_date',
    'is_active'
    ];

    protected $appends = [
        // Spanish aliases for backward compatibility
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'activa'
    ];

    // Spanish aliases
    public function getTituloAttribute()
    {
        return $this->title;
    }

    public function getDescripcionAttribute()
    {
        return $this->description;
    }

    public function getFechaInicioAttribute()
    {
        return $this->start_date ? \Carbon\Carbon::parse($this->start_date) : null;
    }

    public function getFechaFinAttribute()
    {
        return $this->end_date ? \Carbon\Carbon::parse($this->end_date) : null;
    }

    public function getActivaAttribute()
    {
        return $this->is_active;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_promotion');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_promotion');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }


}
