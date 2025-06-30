<?php

namespace AppModules\cart\Infrastructure\Persistence\Models;

use AppModules\Product\Infrastructure\Persistence\Models\ProductModel;
use AppModules\User\Infrastructure\Persistence\Models\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class CartModel extends Model
{
    //
    use HasApiTokens, HasRoles, Notifiable;

    public $timestamps = true;
    protected $table = 'carts';
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

}
