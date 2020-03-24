<?php

namespace App\Http\Controllers\Api\Seller;

use Illuminate\Http\Request;
use App\Model\Seller\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=Product::where(['seller_id'=>Auth::user()->id,'is_delete'=>0])->get();
        $output=json_encode($product);
        return $output;
        // return response()->json(['products' => $product], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Product::create([
            'seller_id'=>Auth::user()->id,
            'product_name'=>$request->product_name,
            'product_sku'=>$request->product_sku,
            'product_price'=>$request->product_price,
            'product_stock_quantity'=>$request->product_stock_quantity,
            'product_total_sales'=>$request->product_total_sales,
            'is_delete'=>0,
        ]);
        return response()->json(['message'=>'Product added succesfully.'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::where('id',$id)->first();
        return response()->json(['product'=>$product],200);
        // return json_encode(['product'=>$product]);
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
        Product::where('id',$id)->update([
            'product_name'=>$request->product_name,
            'product_sku'=>$request->product_sku,
            'product_price'=>$request->product_price,
            'product_stock_quantity'=>$request->product_stock_quantity,
            'product_total_sales'=>$request->product_total_sales,
        ]);
        return response()->json(['message'=>'Product update successfully.'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Product::where('id',$id)->update(['is_delete'=>1])) {
            return response()->json(['message'=>'Product delete successfully.'],200);
        }
        return response()->json(['message'=>'Problem while deleting product.'],226);
    }
}
