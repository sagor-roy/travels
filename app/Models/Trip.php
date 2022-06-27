<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'type_id',
        'route_id',
        'schedule_id',
        'price',
        'status',
    ];

    
    public function types() {
        return $this->belongsTo(Fleet::class,'type_id');
    }

    public function routes() {
        return $this->belongsTo(Routee::class,'route_id');
    }

    public function schedules() {
        return $this->belongsTo(Schedule::class,'schedule_id');
    }

    public function vehicles() {
        return $this->belongsTo(Vehicles::class,'type_id','type_id');
    }

}
