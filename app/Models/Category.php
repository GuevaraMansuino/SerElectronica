<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Promotion;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected $appends = [
        // Spanish alias for backward compatibility
        'nombre',
    ];

    // Spanish alias
    public function getNombreAttribute()
    {
        return $this->name;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Spanish alias for backward compatibility
    public function productos()
    {
        return $this->hasMany(Product::class);
    }

    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'category_promotion');
    }
}
