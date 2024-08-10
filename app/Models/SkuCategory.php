<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkuCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function skus()
    {
        return $this->hasMany(Sku::class,  'sku_category_id', 'id')->orderByDesc('id');
    }
    public function subsets()
    {
        return $this->hasMany(Sku::class,  'sku_category_id', 'id')->orderByDesc('id');
    }
    public function brands()
    {
        return $this->hasMany(BrandSkuCategory::class,  'sku_category_id','id');
    }
}
