<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    //use HasFactory;
    use SoftDeletes;
    protected $table = 'invoice_items';
    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
        'subtotal',
    ];

    public function invoice(){
        return $this->belongsTo('App\Models\Invoice', 'invoice_id', 'id');

    }
    public function product(){
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');

    }

}
