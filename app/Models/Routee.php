<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Routee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'from',
        'to',
        'distance',
        'duration',
        'status',
        'map'
    ];

    public function froms() {
        return $this->belongsTo(Destination::class,'from');
    }

    public function too() {
        return $this->belongsTo(Destination::class,'to');
    }
}
