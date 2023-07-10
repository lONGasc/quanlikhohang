<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $productCount = Product::all()->count();
        $purchaseCount = Purchase::wheredate('created_at', Carbon::today())->sum('total_amount');
        $invoiceCount = Invoice::wheredate('created_at', Carbon::today())->sum('total_amount');
        $unpaidInvoices = Invoice::where('due_amount', '!=', 0)->get();
        $unpaidPurchase = Purchase::where('due_amount', '!=', 0)->get();
        return view('home',['productCount'=>$productCount, 'purchaseCount'=>$purchaseCount, 'invoiceCount'=>$invoiceCount,'unpaidInvoices'=>$unpaidInvoices,'unpaidPurchase'=>$unpaidPurchase]);
    }
    public function report($type)
    {
        if( $type == 'invoice' ){
            $reports = Invoice::all();
        }
        else{
        $reports = Purchase::all();
        }
        return view('report.index',["reports"=>$reports,'type'=>$type]);
    }
}
