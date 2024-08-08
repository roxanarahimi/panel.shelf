<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }
   public function scores()
    {
        return $this->hasone(CustomerGradeScore::class, 'customer_id', 'id');
    }
    public function forms()
    {
        return $this->hasMany(Form::class, 'customer_id', 'id');
    }
}
