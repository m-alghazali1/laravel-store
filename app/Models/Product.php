<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description','old_price', 'price','quantity', 'category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(){
        return $this->hasMany(CartItem::class);
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }
}
