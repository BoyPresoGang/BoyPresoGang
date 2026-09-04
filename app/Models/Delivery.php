<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'customer_id',
        'delivery_date',
        'status',
    ];
}