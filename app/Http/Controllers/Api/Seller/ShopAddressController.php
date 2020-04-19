<?php

namespace App\Http\Controllers\Api\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Model\Seller\ShopAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShopAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop_address = ShopAddress::join('sellers', 'sellers.address_id', '=', 'shop_addresses.id')
            ->where('sellers.id', Auth::user()->id)
            ->select('shop_addresses.*')
            ->first();
        if ($shop_address == null) {
            $shop_address = array(
                'shop_no' => null,
                'street' => null,
                'landmark' => null,
                'city' => null,
                'state' => null,
                'pincode' => null
            );
        }
        return response()->json(['shop_address' => $shop_address], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shopAddressId = ShopAddress::insertGetId([
            'shop_no' => $request->shop_no,
            'street' => $request->street,
            'landmark' => $request->landmark,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
        ]);
        if ($shopAddressId) {
            if (Seller::where('id', Auth::user()->id)->update([
                'address_id' => $shopAddressId
            ])) {
                if (Seller::where(['id' => Auth::user()->id, ['legal_information_id', '!=', null]])->count() == 1) {
                    Seller::where('id', Auth::user()->id)->update(['is_verified' => true]);
                }
                return response()->json(['message' => 'Shop address added successfully.'], 200);
            } else {
                return response()->json(['message' => 'Error while adding shop address.'], 226);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $seller = Seller::where('id', $id)->first();
        if ($seller->address_id == null) {
            $shopAddressId = ShopAddress::insertGetId([
                'shop_no' => $request->shop_no,
                'street' => $request->street,
                'landmark' => $request->landmark,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
            ]);
            if ($shopAddressId) {
                if (Seller::where('id', Auth::user()->id)->update([
                    'address_id' => $shopAddressId
                ])) {
                    if (Seller::where(['id' => Auth::user()->id, ['legal_information_id', '!=', null]])->count() == 1) {
                        Seller::where('id', Auth::user()->id)->update(['is_verified' => true]);
                    }
                    return response()->json(['message' => 'Shop address added successfully.'], 200);
                } else {
                    return response()->json(['message' => 'Error while adding shop address.'], 226);
                }
            }
        } else {
            ShopAddress::where('id', $seller->address_id)->update([
                'shop_no' => $request->shop_no,
                'street' => $request->street,
                'landmark' => $request->landmark,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
            ]);
            return response()->json(['message' => 'Shop address update successfully.'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (ShopAddress::where('id', $id)->delete()) {
            Seller::where('sellers.id', Auth::user()->id)->update([
                'address_id' => NULL
            ]);
            return response()->json(['message' => 'Shop address delete successfully.'], 200);
        }
        return response()->json(['message' => 'Problem while deleting shop address.'], 226);
    }
}
