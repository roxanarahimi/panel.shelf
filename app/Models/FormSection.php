<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSection extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function form()
    {
        return $this->belongsTo(Form::class, 'id', 'form_id');
    }
    public function skus()
    {
        return $this->hasMany(FormSectionSku::class, 'form_section_id', 'id')->orderBy('id');
    }
    public function skuCategory()
    {
        return $this->hasOne(SkuCategory::class, 'id','sku_category_id');
    }
    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
}
