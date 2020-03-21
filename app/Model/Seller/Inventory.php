<?php

namespace App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable=[
        'product_id','stock_quantity','principle_amount',
    ];
}
