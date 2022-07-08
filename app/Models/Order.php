<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'name',
        'email',
        'number',
        'gender',
        'method',
        'transaction',
        'ticked_no',
        'date',
        'time',
        'seat',
        'price',
        'status',
    ];

    public function trip() {
        return $this->belongsTo(Trip::class,'trip_id');
    }
}
