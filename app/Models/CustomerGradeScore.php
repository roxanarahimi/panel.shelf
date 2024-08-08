<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGradeScore extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function customer()
    {
        return $this->belongsTo(Sector::class, 'sector_id', 'id');
    }
    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id', 'id');
    }
}
