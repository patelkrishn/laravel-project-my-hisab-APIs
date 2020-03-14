<?php

namespace App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        'seller_id',
            'product_name','product_sku','product_price','product_stock_quantity','product_total_sales',
    ];
}
