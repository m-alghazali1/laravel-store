<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'address_id', 'status'];


    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
