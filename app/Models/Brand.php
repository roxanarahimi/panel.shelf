<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function skuCategories()
    {
        return $this->hasMany(BrandSkuCategory::class, 'brand_id', 'id');
    }
}
