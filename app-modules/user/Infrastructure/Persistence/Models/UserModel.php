<?php


namespace AppModules\User\Infrastructure\Persistence\Models;


use AppModules\cart\Infrastructure\Persistence\Models\CartModel;
use AppModules\User\Infrastructure\Persistence\Factories\UserModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class UserModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public $timestamps = true; // اسم الجدول في قاعدة البيانات
    protected $table = 'users';  // لو عايز Laravel يدير created_at, updated_at
    protected $fillable = ['name', 'email', 'password', 'role']; // الحقول القابلة للكتابة
    protected $hidden = ['password']; // اخفاء كلمة السر في الردود
//    protected $guard_name = 'sanctum'; // <<< هذا هو المفتاح لحل مشكلتك

//
    protected static function newFactory()
    {
        return UserModelFactory::new();
    }

    public function cart()
    {
        return $this->hasOne(CartModel::class, 'user_id');
    }

    protected function profile()
    {
        return $this->hasOne(ProfileModel::class);
    }
}
