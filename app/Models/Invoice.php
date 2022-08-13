<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    //use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'cart_id',
        'subtotal',
        'discount',
        'tax',
        'total_price',
        'notes'
    ];

    public function customer(){
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }
    public function invoice_items(){
        return $this->hasMany('App\Models\InvoiceItem', 'invoice_id', 'id');
    }
}
