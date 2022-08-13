<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;
    protected $table = 'carts';
    protected $fillable = [
        'customer_id',
        'subtotal',
        'discount',
        'tax',
        'total_price',
        'notes',
    ];

    /***
        public function cart_invoice(){
            return $this->hasOne('App\Cart', 'invoice_id', 'id');

        }
    */
    public function cart_items(){
        return $this->hasMany('App\Models\CartItem','cart_id', 'id');

    }
    public function customer(){
        return $this-> belongsTo('App\Models\Customer', 'customer_id', 'id');
    }
    // public function cart_item()
    // {
    //     return $this->belongsToMany(Product::class, 'cart_items')->withPivot('quantity');
    // }


}
