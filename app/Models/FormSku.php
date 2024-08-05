<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSku extends Model
{
    use HasFactory;
    protected $guarded= 'id';

    public function sku()
    {
        return $this->hasMany(Sku::class, 'id', 'sku_id');
    }
}
