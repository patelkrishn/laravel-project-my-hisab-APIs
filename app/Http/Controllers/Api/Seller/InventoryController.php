<?php

namespace App\Http\Controllers\Api\Seller;

use Illuminate\Http\Request;
use App\Model\Seller\Product;
use App\Model\Seller\Inventory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories=Inventory::join('products','products.id','=','inventories.product_id')
                                ->select('inventories.*','products.product_name','products.product_sku')
                                ->where('inventories.seller_id',Auth::user()->id)
                                ->get();
        return response()->json(['inventories'=>$inventories],200); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product=Product::find($request->product_id);
        $total_stock_quantity=$product->product_stock_quantity+$request->stock_quantity;
        $product->product_stock_quantity=$total_stock_quantity;
        $product->save();
        // $paid_amount=0;
        $paid_amount=$request->principle_amount*$request->stock_quantity;
        if (Inventory::create([
            'product_id'=>$request->product_id,
            'seller_id'=>Auth::user()->id,
            'stock_quantity'=>$request->stock_quantity,
            'total_stock_quantity'=>$total_stock_quantity,
            'principle_amount'=>$request->principle_amount,
            'paid_amount'=>$paid_amount
        ])) {
            Inventory::where('product_id',$request->product_id)->update([
                'total_stock_quantity'=>$total_stock_quantity
            ]);
            return response()->json(['message'=>'Inventory added successfully.'],200);
        }else{
            return response()->json(['message'=>'Problem while adding inventory'],204);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        return response()->json($inventory);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function list($id)
    {
        $inventory=Inventory::where('product_id',$id)->get();
        return response()->json($inventory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        $inventory->stock_quantity=$request->stock_quantity;
        $inventory->principle_amount=$request->principle_amount;
        if ($inventory->save()) {
            return json_encode(['message'=>'Inventory update successfully.'],200);
        }else{
            return json_encode(['message'=>'Problem while updating inventory'],204);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        $product=Product::find($inventory->product_id);
        $product->product_stock_quantity=$product->product_stock_quantity-$inventory->stock_quantity;
        $product->save();
        if ($inventory->delete()) {
            return json_encode(['message'=>'Inventory delete successfully.'],200);
        }else{
            return json_encode(['message'=>'Problem while deleting inventory'],204);
        }
    }
}
