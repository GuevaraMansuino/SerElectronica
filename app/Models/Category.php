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
        'icono_emoji'
    ];

    protected $appends = [
        // Spanish aliases for backward compatibility
        'nombre',
        'icono_emoji'
    ];

    // Spanish aliases
    public function getNombreAttribute()
    {
        return $this->name;
    }

    public function getIconoEmojiAttribute()
    {
        return $this->attributes['icono_emoji'] ?? '⚡';
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
