<?php


namespace AppModules\User\Infrastructure\Persistence\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasApiTokens;

    public $timestamps = true;  // لو عايز Laravel يدير created_at, updated_at
    protected $table = 'users'; // اسم الجدول في قاعدة البيانات
    protected $fillable = ['name', 'email', 'password']; // الحقول القابلة للكتابة
    protected $hidden = ['password']; // اخفاء كلمة السر في الردود
}
