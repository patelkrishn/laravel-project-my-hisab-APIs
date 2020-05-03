<?php

namespace App\Http\Controllers\Api\Seller;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Model\Seller\Invoice;
use App\Model\Seller\Product;
use App\Model\Seller\Inventory;
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
        
        $today_sales=Invoice::where(['seller_id'=>Auth::user()->id,])
                            ->whereDate('created_at', $now)
                            ->sum('total_amount');
        $this_month_sales=Invoice::where(['seller_id'=>Auth::user()->id,])
                                    ->whereMonth('created_at', Carbon::now('+05:30')->format('m'))
                                    ->whereYear('created_at', Carbon::now('+05:30')->format('Y'))
                                    ->sum('total_amount');
        $this_year_sales=Invoice::where(['seller_id'=>Auth::user()->id,])
                                ->whereYear('created_at', Carbon::now('+05:30')->format('Y'))
                                ->sum('total_amount');
        $yesterday_sales=Invoice::where(['seller_id'=>Auth::user()->id,])
                                    ->whereDate('created_at', Carbon::now('+05:30')->subDay()->format('Y-m-d'))
                                    ->sum('total_amount');
        $last_month_sales=Invoice::where(['seller_id'=>Auth::user()->id,])
                                    ->whereMonth('created_at', Carbon::now('+05:30')->subMonth()->format('m'))
                                    ->whereYear('created_at', Carbon::now('+05:30')->subMonth()->format('Y'))
                                    ->sum('total_amount');
        $last_year_sales=Invoice::where(['seller_id'=>Auth::user()->id])
                                ->whereYear('created_at', Carbon::now('+05:30')->subYear()->format('Y'))
                                ->sum('total_amount');
        $expense_today_so_far=Inventory::where(['seller_id'=>Auth::user()->id])->sum('paid_amount');
        $earning_today_so_far=0;
        foreach (Product::where(['seller_id'=>Auth::user()->id])->get() as $item) {
            $earning_today_so_far=$earning_today_so_far+($item->product_total_sales*$item->product_price);
        }
        $highestSaleData=Product::where(['seller_id'=>Auth::user()->id])->select('product_name','product_total_sales')->get();
        $highestSale=array(
            'series'=>array(),
            'options'=>array(
                'theme'=>array(
                    'palette'=>'palette10'
                ),
                'labels'=>array()
            )
        );
        foreach ($highestSaleData as $item) {
            array_push($highestSale['series'],$item->product_total_sales);
            array_push($highestSale['options']['labels'],$item->product_name);
        }
        return response()->json([
            'todaySales'=>$today_sales,
            'thisMonthSales'=>$this_month_sales,
            'thisYearSales'=>$this_year_sales,
            'yesterdaySales'=>$yesterday_sales,
            'lastMonthSales'=>$last_month_sales,
            'lastYearSales'=>$last_year_sales,
            'expenseTodaySoFar'=>$expense_today_so_far,
            'earningTodaySoFar'=>$earning_today_so_far,
            'highestSale'=>$highestSale
        ],200);
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
