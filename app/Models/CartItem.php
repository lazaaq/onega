<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    //use HasFactory;
    use SoftDeletes;
    
    protected $table = 'cart_items';
    protected $fillable = [
        'cart_id',
        'product_id',
        'discount',
        'quantity',
        'subtotal',
    ];

    public function cart(){
        return $this->belongsTo('App\Models\Cart', 'cart_id', 'id');

    }
    public function product(){
        return $this->hasOne('App\Models\Product', 'id', 'product_id');

    }
}
