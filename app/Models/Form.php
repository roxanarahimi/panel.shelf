<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id', 'id');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class, 'customer_id', 'id');
    }
    public function skuCategories()
    {
        return $this->hasMany(SkuCategory::class, 'sku_category_id', 'id');
    }
    public function brands()
    {
        return $this->hasMany(BrandSkuCategory::class, 'brand_id', 'id');
    }
    public function sku()
    {
        return $this->hasMany(FormSku::class, 'form_id', 'id');
    }
}
