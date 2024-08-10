<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandSkuCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function brand()
    {
        return $this->belongsTo(Brand::class,  'brand_id', 'id');
    }

    public function skuCategory()
    {
        return $this->belongsTo(SkuCategory::class,  'sku_category_id', 'id');
    }

}
