<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $guarded = ['id'];

    public function order() { return $this->belongsTo(Order::class); }
    public function courier() { return $this->belongsTo(User::class, 'courier_id'); }
}
