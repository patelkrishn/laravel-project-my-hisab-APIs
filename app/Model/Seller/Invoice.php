<?php

namespace App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable=[
        'invoice_id','payment_id','user_id','seller_id','product_id','invoice_quantity','product_price','total_amount','total_payable_amount','status',
    ];
}
