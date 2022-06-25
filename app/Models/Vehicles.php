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
        return $this->belongsTo(Fleet::class,'type_id')->where('status',1);
    }
}
