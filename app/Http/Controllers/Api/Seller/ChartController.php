<?php

namespace App\Http\Controllers\Api\Seller;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\Seller\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now=Carbon::now('+05:30')->format('Y-m-d');
        $charts=Invoice::where('seller_id',Auth::user()->id)->get();
        $first=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 00:00:00'],
            ['created_at','<',$now.' 01:00:00'],
        ])->sum('total_amount');
        $second=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 01:00:00'],
            ['created_at','<',$now.' 02:00:00'],
        ])->sum('total_amount');
        $third=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 02:00:00'],
            ['created_at','<',$now.' 03:00:00'],
        ])->sum('total_amount');
        $fourth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 03:00:00'],
            ['created_at','<',$now.' 04:00:00'],
        ])->sum('total_amount');
        $fifth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 04:00:00'],
            ['created_at','<',$now.' 05:00:00'],
        ])->sum('total_amount');
        $sixth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 05:00:00'],
            ['created_at','<',$now.' 06:00:00'],
        ])->sum('total_amount');
        $seventh=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 06:00:00'],
            ['created_at','<',$now.' 07:00:00'],
        ])->sum('total_amount');
        $eighth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 07:00:00'],
            ['created_at','<',$now.' 08:00:00'],
        ])->sum('total_amount');
        $nineth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 08:00:00'],
            ['created_at','<',$now.' 09:00:00'],
        ])->sum('total_amount');
        $tenth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 09:00:00'],
            ['created_at','<',$now.' 10:00:00'],
        ])->sum('total_amount');
        $eleventh=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 10:00:00'],
            ['created_at','<',$now.' 11:00:00'],
        ])->sum('total_amount');
        $twelveth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 11:00:00'],
            ['created_at','<',$now.' 12:00:00'],
        ])->sum('total_amount');
        $thirteenth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 12:00:00'],
            ['created_at','<',$now.' 13:00:00'],
        ])->sum('total_amount');
        $fourteenth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 13:00:00'],
            ['created_at','<',$now.' 14:00:00'],
        ])->sum('total_amount');
        $fifteenth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 14:00:00'],
            ['created_at','<',$now.' 15:00:00'],
        ])->sum('total_amount');
        $sixteenth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 15:00:00'],
            ['created_at','<',$now.' 16:00:00'],
        ])->sum('total_amount');
        $seventeenth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 16:00:00'],
            ['created_at','<',$now.' 17:00:00'],
        ])->sum('total_amount');
        $eighteenth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 17:00:00'],
            ['created_at','<',$now.' 18:00:00'],
        ])->sum('total_amount');
        $nineteenth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 18:00:00'],
            ['created_at','<',$now.' 19:00:00'],
        ])->sum('total_amount');
        $twentyth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 19:00:00'],
            ['created_at','<',$now.' 20:00:00'],
        ])->sum('total_amount');
        $twentyfirst=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 20:00:00'],
            ['created_at','<',$now.' 21:00:00'],
        ])->sum('total_amount');
        $twentysecond=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 21:00:00'],
            ['created_at','<',$now.' 22:00:00'],
        ])->sum('total_amount');
        $twentythird=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 22:00:00'],
            ['created_at','<',$now.' 23:00:00'],
        ])->sum('total_amount');
        $twentyfourth=Invoice::where([
            'seller_id'=>Auth::user()->id,
            ['created_at','>',$now.' 23:00:00'],
            ['created_at','<',$now.' 24:00:00'],
        ])->sum('total_amount');
        $output=array(
            ['Time', 'Sales'],
            ['01 AM', $first],
            ['02 AM', $second],
            ['03 AM', $third],
            ['04 AM', $fourth],
            ['05 AM', $fifth],
            ['06 AM', $sixth],
            ['07 AM', $seventh],
            ['08 AM', $eighth],
            ['09 AM', $nineth],
            ['10 AM', $tenth],
            ['11 AM', $eleventh],
            ['12 AM', $twelveth],
            ['01 PM', $thirteenth],
            ['02 PM', $fourteenth],
            ['03 PM', $fifteenth],
            ['04 PM', $sixteenth],
            ['05 PM', $seventeenth],
            ['06 PM', $eighteenth],
            ['07 PM', $nineteenth],
            ['08 PM', $twentyth],
            ['09 PM', $twentyfirst],
            ['10 PM', $twentysecond],
            ['11 PM', $twentythird],
            ['12 PM', $twentyfourth],
        );
        // dd($last_24_hour);
        return response()->json(['charts'=>$output],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
