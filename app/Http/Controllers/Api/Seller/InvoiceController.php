<?php

namespace App\Http\Controllers\Api\Seller;

use Illuminate\Http\Request;
use App\Model\Seller\Invoice;
use App\Model\Seller\Product;
use App\Model\Seller\InvoiceId;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices=InvoiceId::
                            // join('products','products.id','=','invoices.product_id')
                            // ->select('invoices.*','products.product_name')
                            where(['seller_id'=>Auth::user()->id])->get();
        // $output=json_encode($invoices);
        // return $output;
        return response()->json(['invoices' => $invoices], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    private function getUniqueInvoiceId()
    {
        $invoice_id=InvoiceId::where('seller_id',Auth::user()->id)->max('invoice_name');
        if ($invoice_id==NULL) {
            InvoiceId::create([
                'invoice_name'=>01,
                'seller_id'=>Auth::user()->id,
                'invoice_amount'=>0,
                'status'=>false,
            ]);
            return 01;
        }else{
            InvoiceId::create([
                'invoice_name'=>$invoice_id+1,
                'seller_id'=>Auth::user()->id,
                'invoice_amount'=>0,
                'status'=>false,
            ]);
            return $invoice_id+1;
        }
    }
    
    public function store(Request $request)
    {
        $invoice_id=$this->getUniqueInvoiceId();
            if ($this->storeData($request->all(),$invoice_id)) {
                return json_encode(['message'=>'Product added to invoice succesfully.','invoice_id'=>$invoice_id],200);
            }else{
                return json_encode(['message'=>'Problem while adding Product to invoice.'],423);
            }
        return response()->json(['message'=>$test],200);
    }

    private function storeData($request,$invoice_id)
    {
        $total_payable_amount=0;
        foreach($request as $item){
            $total_payable_amount=floatval($total_payable_amount)+floatval($item['total_amount']);
        }
        foreach($request as $item){
            Invoice::create([
                'invoice_id' => $invoice_id,
                'product_id'=>$item['product_id'],
                'seller_id'=>Auth::user()->id,
                'invoice_quantity'=>$item['invoice_quantity'],
                'product_price'=>$item['product_price'],
                'total_amount'=>$item['total_amount'],
                'status'=>false,
                'total_payable_amount'=>$total_payable_amount,
            ]);
            $product=Product::where('id',$item['product_id'])->first();
                Product::where('id',$item['product_id'])->update([
                    'product_stock_quantity'=>floatval($product->product_stock_quantity)-floatval($item['invoice_quantity']),
                    'product_total_sales'=>floatval($product->product_total_sales)+floatval($item['invoice_quantity'])
                ]);
        } 
        InvoiceId::where('invoice_name',$invoice_id)->update(['invoice_amount'=>$total_payable_amount]);
        return true;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Seller\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice=Invoice::join('products','products.id','=','invoices.product_id')
                        ->where('invoices.invoice_id',$id)
                        ->select('invoices.*','products.product_name')
                        ->get();
        return response()->json(['invoices'=>$invoice],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Seller\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Seller\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        $invoice->invoice_quantity=$request->invoice_quantity;
        $invoice->total_amount=$request->total_amount;
        if ($invoice->save()) {
            return response()->json(['message'=>'Item update successfully in invoice.'],200);
        }else{
            return response()->json(['message'=>'Problem while updating item in invoice.'],401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Seller\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        if ($invoice->delete()) {
            return response()->json(['message'=>'Product deleted successfully from invoice.'],200);
        }else{
            return response()->json(['message'=>'Problem while deleting Product from invoice.'],401);
        }
    }
}
