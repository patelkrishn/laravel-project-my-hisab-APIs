<?php

namespace App\Http\Controllers\Api\Seller;

use Illuminate\Http\Request;
use App\Model\Seller\Invoice;
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
        $invoices=Invoice::join('products','products.id','=','invoices.product_id')
                            ->select('invoices.*','products.product_name')
                            ->where(['invoices.seller_id'=>Auth::user()->id,'invoices.status'=>1])->get();
        $output=json_encode($invoices);
        return $output;
        // return response()->json(['invoices' => $invoices], 200);
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
                'status'=>1,
            ]);
            return 01;
        }else{
            InvoiceId::create([
                'invoice_name'=>$invoice_id+1,
                'seller_id'=>Auth::user()->id,
                'status'=>1,
            ]);
            return $invoice_id+1;
        }
    }
    
    public function store(Request $request)
    {
        $invoices=Invoice::where([
            'seller_id'=>Auth::user()->id,
            'status'=>1
        ]);
        if ($invoices->count() == 0) {
            $invoice_id=$this->getUniqueInvoiceId();
            // dd($invoice_id);
            if ($this->storeData($request->all(),$invoice_id)) {
                return json_encode(['message'=>'Product added to invoice succesfully.'],200);
            }else{
                return json_encode(['message'=>'Problem while adding Product to invoice.'],401);
            }
        }else{
            $invoices=Invoice::where(['seller_id'=>Auth::user()->id,'status'=>1])->first();
            // dd($invoices['invoice_id']);
            if ($this->storeData($request->all(),$invoices['invoice_id'])) {
                return json_encode(['message'=>'Product added to invoice succesfully.'],200);
            }else{
                return json_encode(['message'=>'Problem while adding Product to invoice.'],401);
            }
        }
    }

    private function storeData($request,$invoice_id)
    {
        $invoice_data = Invoice::where([
            'product_id' => $request['product_id'],
            'seller_id' => Auth::user()->id,
            'status' => 1
        ]);
        if ($invoice_data->count() == 1) {
            $invoice_data=$invoice_data->first();
            // dd($invoice_data);
            $invoice_data->invoice_quantity = $invoice_data->invoice_quantity+$request['invoice_quantity'];
            $invoice_data->total_amount = $invoice_data->total_amount+$request['total_amount'];
            // dd($invoice_data->total_amount);
            return $invoice_data->save();
        } else {
            return Invoice::create([
                'invoice_id' => $invoice_id,
                'product_id'=>$request['product_id'],
                'seller_id'=>Auth::user()->id,
                'invoice_quantity'=>$request['invoice_quantity'],
                'product_price'=>$request['product_price'],
                'total_amount'=>$request['total_amount'],
                'total_payable_amount'=>$request['total_amount'],
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Seller\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $invoice=Invoice::join('products','products.id','=','invoices.product_id')
                        ->where('invoices.id',$invoice->id)
                        ->select('invoices.*','products.product_name')
                        ->first();
        return response()->json(['invoice'=>$invoice],200);
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
