<?php

namespace App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class ShopAddress extends Model
{
    protected $table='shop_addresses';

    protected $fillable=[
        'shop_no','street','landmark','city','state','pincode',
    ];
}
