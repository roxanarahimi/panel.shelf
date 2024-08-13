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
        return $this->belongsTo(Visitor::class,  'visitor_id','id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
     public function sections()
    {
        return $this->hasMany(FormSection::class, 'form_id', 'id');
    }

}
