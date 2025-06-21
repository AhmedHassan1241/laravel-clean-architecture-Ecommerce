<?php

namespace AppModules\Product\Infrastructure\Persistence\Models;

use AppModules\product\Infrastructure\Persistence\Factories\ProductModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property mixed|string $name
 */
class ProductModel extends Authenticatable
{
    //
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public $timestamps = true;

    protected $table = 'products';
    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return ProductModelFactory::new();
    }

    protected static function booted()
    {
        static::addGlobalScope('active', function ($query) {
            $query->where('is_active', true);
        });
    }

    public function scopePriceBetween($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function getFormattedNameAttribute()
    {
        return ucfirst($this->name);
    }

    public function inStock()
    {
        return $this->stock > 0;
    }
}
