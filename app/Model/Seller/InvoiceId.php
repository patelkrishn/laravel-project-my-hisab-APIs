<?php

namespace App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class InvoiceId extends Model
{
    protected $fillable=[
        'invoice_name','seller_id','status'
    ];
}
