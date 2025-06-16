<?php


namespace AppModules\User\Infrastructure\Persistence\Models;


use AppModules\User\Infrastructure\Persistence\Factories\UserModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class UserModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = true; // اسم الجدول في قاعدة البيانات
    protected $table = 'users';  // لو عايز Laravel يدير created_at, updated_at
    protected $fillable = ['name', 'email', 'password']; // الحقول القابلة للكتابة
    protected $hidden = ['password']; // اخفاء كلمة السر في الردود

//
    protected static function newFactory()
    {
        return UserModelFactory::new();
    }

    protected function profile()
    {
        return $this->hasOne(ProfileModel::class);
    }
}
