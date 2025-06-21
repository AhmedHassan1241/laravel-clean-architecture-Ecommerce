<?php

namespace AppModules\Category\Infrastructure\Persistence\Models;


use AppModules\Category\Infrastructure\Persistence\Factories\CategoryModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class CategoryModel extends Authenticatable
{
    use HasFactory, HasRoles;

    public $timestamps = true;

    protected $table = 'categories';

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return CategoryModelFactory::new();
    }

    public function parent()
    {
        return $this->belongsTo(CategoryModel::class, 'parent_id');
    }

    public function activeChildren()
    {
        return $this->children()->where('is_active', true);
    }

    public function children()
    {
        return $this->hasMany(CategoryModel::class, 'parent_id');
    }

    public function isTopLevel()
    {
        return is_null($this->parent_id);
    }

}
