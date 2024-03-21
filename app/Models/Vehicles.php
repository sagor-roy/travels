<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    use HasFactory;
    protected $fillable = [
        'regis',
        'type_id',
        'engine_no',
        'model_no',
        'chasis_no',
        'owner',
        'owner_phone',
        'brand',
        'status',
    ];

    public function types() {
        return $this->belongsTo(Fleet::class,'type_id')->select('id','type')->where('status',1);
    }

    public function trip() {
        return $this->belongsTo(Trip::class,'type_id','type_id');
    }
}
