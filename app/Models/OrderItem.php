<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['quantity', 'price_at_purchase', 'order_id', 'product_id'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
     public function order(){
        return $this->belongsTo(Order::class);
    }
}
