<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSectionSku extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function formSection()
    {
        return $this->belongsTo(FormSection::class, 'form_section_id', 'id');
    }
    public function sku()
    {
        return $this->hasOne(Sku::class, 'id', 'sku_id');
    }
}
