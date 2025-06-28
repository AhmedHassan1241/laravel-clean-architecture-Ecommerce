<?php

namespace AppModules\User\Infrastructure\Persistence\Models;

use AppModules\User\Infrastructure\Persistence\Factories\ProfileModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ProfileModel extends Authenticatable
{
    //
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'profiles'; // 👈 مهم جداً

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return ProfileModelFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class);

    }

    public function getImageUrl(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
