<?php

namespace AppModules\product\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImageModel extends Model
{
    //
    protected $table = 'product_images';
    protected $fillable = ['product_id', 'image_path'];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }
}
