<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function customers()
    {
        return $this->hasMany(Customer::class,  'sector_id', 'id');
    }
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }
}
