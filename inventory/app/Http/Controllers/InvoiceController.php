<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceMeta;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseMeta;
use App\Models\Supplier;
use App\Models\Unit;



class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::latest()->paginate(10);
        $title = "Invoices Info";
       return view('invoice.index',["invoices"=>$invoices,"title"=>$title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoice_no = $this->uniqueNumber();
     
        $customers = Supplier::where('status', 2)->get();
        $categories = Category::all();
        $units = Unit::all();
        return view('invoice.create',['invoice_no'=>$invoice_no, 'customers'=>$customers, 'categories'=>$categories, 'units'=>$units]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_no' => 'required',
            'customer_id' => 'required',
            'paid_amount' => 'required',
            'total_amount' => 'required',
            'paid_amount' => 'required',
            'category_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
        ]);

        $invoice = Invoice::create([
            'invoice_no' => $request->invoice_no,
            'supplier_id' => $request->customer_id,
            'paid_amount' => $request->paid_amount,
            'total_amount' => $request->total_amount,
            'due_amount' => (int)$request->total_amount-(int)$request->paid_amount,
        ]);

        for ($i=0; $i < count($request->category_id); $i++) { 
                InvoiceMeta::create([
                    'invoice_id' => $invoice->id,
                    'category_id' => $request->category_id[$i],
                    'product_id' => $request->product_id[$i],
                    'quantity' => $request->quantity[$i],
                    'unit_price' => $request->unit_price[$i],
                    'unit_id' => $request->unit_id[$i]
                ]);
            }

        return redirect()->route('invoice.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::find($id);
        $title = "Invoice View";
       return view('invoice.show',["invoice"=>$invoice,"title"=>$title]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
    
        $customers = Supplier::where('status', 2)->get();
        $categories = Category::all();
     
        $units = Unit::all();
        return view('invoice.edit', ['invoice'=>$invoice,'customers'=>$customers,'categories'=>$categories,'units'=>$units]);
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
        $request->validate([
            'invoice_no' => 'required',
            'customer_id' => 'required',
            'paid_amount' => 'required',
            'total_amount' => 'required',
            'paid_amount' => 'required',
            'category_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
        ]);

        $invoice = Invoice::create([
            'invoice_no' => $request->invoice_no,
            'supplier_id' => $request->customer_id,
            'paid_amount' => $request->paid_amount,
            'total_amount' => $request->total_amount,
            'due_amount' => (int)$request->total_amount-(int)$request->paid_amount,
        ]);

        for ($i=0; $i < count($request->category_id); $i++) { 
                InvoiceMeta::create([
                    'invoice_id' => $invoice->id,
                    'category_id' => $request->category_id[$i],
                    'product_id' => $request->product_id[$i],
                    'quantity' => $request->quantity[$i],
                    'unit_price' => $request->unit_price[$i],
                    'unit_id' => $request->unit_id[$i]
                ]);
            }

        return redirect()->route('invoice.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        foreach ($invoice->invoiceMeta as $item) {
            $item->delete();
        }

        $invoice->delete();

        return back();
    }

    public function uniqueNumber()
    {
        $invoice = Invoice::latest()->first();
        if ($invoice) {
            $name = $invoice->invoice_no;
            $number = explode('_', $name);
            $invoice_no = 'INV_'. str_pad((int)$number[1] + 1, 6, "0", STR_PAD_LEFT);
        }else {
            $invoice_no = 'INV_000001';
        }
        return $invoice_no;
    }

    public function getProduct($id)
    {
        $products = Product::where('category_id', $id)->get();
        return response()->json($products);
    }
}