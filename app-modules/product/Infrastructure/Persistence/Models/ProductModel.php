<?php

namespace AppModules\Product\Infrastructure\Persistence\Models;

use AppModules\cart\Infrastructure\Persistence\Models\CartItemsModel;
use AppModules\cart\Infrastructure\Persistence\Models\CartModel;
use AppModules\Category\Infrastructure\Persistence\Models\CategoryModel;
use AppModules\product\Infrastructure\Persistence\Factories\ProductModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property mixed|string $name
 */
class ProductModel extends Model
{
    //
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

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

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeHasStock($query, $min = 1)
    {
        return $query->where('stock', '>=', $min);
    }

    public function getFormattedNameAttribute()
    {
        return ucfirst($this->name);
    }

    public function inStock()
    {
        return $this->stock > 0;
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryModel::class, 'category_product', 'product_id', 'category_id');
    }


    public function images()
    {
        return $this->hasMany(ProductImageModel::class, 'product_id');
    }

    public function cart()
    {
        return $this->hasMany(CartModel::class, 'product_id');
    }

}
