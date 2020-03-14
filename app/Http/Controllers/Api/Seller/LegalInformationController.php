<?php

namespace App\Http\Controllers\Api\Seller;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Seller\LegalInformation;

class LegalInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $legal_information=LegalInformation::join('sellers','sellers.legal_information_id','=','legal_informations.id')
                            ->where('sellers.id',Auth::user()->id)
                            ->select('legal_informations.*')
                            ->first();
        return response()->json(['legal_information' => $legal_information], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $legalInformationId=LegalInformation::insertGetId([
            'shop_name'=>$request->shop_name,
            'shop_pan'=>$request->shop_pan,
            'shop_gstin'=>$request->shop_gstin,
        ]);
        if ($legalInformationId) {
            if (Seller::where('id',Auth::user()->id)->update([
                'legal_information_id'=>$legalInformationId
            ])) {
                return response()->json(['message' => 'Legal Information added successfully.'], 200);
            }else{
                return response()->json(['message' => 'Error while adding legal Information.'], 226);
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
        LegalInformation::where('id',$id)->update([
            'shop_name'=>$request->shop_name,
            'shop_pan'=>$request->shop_pan,
            'shop_gstin'=>$request->shop_gstin,
        ]);
        return response()->json(['message' => 'Legal Information update successfully.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (LegalInformation::where('id',$id)->delete()) {
            Seller::where('id',Auth::user()->id)->update([
                'legal_information_id'=>NULL
            ]);
            return response()->json(['message'=>'Legal Information delete successfully.'],200);
        }
        return response()->json(['message'=>'Problem while deleting legal Information.'],226);
    }
}
