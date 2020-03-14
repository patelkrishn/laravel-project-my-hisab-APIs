<?php

namespace App\Model\Seller;

use Illuminate\Database\Eloquent\Model;

class LegalInformation extends Model
{
    protected $table='legal_informations';

    protected $fillable=[
        'shop_name','shop_pan','shop_gstin',
    ];
}
