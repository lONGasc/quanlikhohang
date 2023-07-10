<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(8);
        $title = "Product Info";
       return view('product.index',["products"=>$products,"title"=>$title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::latest()->get();
        $suppliers = Supplier::where('status',1)->get();
        return view('product.create',['categories'=>$categories , 'suppliers'=>$suppliers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'brand' => 'string',
        ]);
        $image = "";
        if($request->hasFile('image')){
            $image = time().'.'.$request->file('image')->extension();
            $request->file("image")->move("uploads/product",$image);
        }
 
        Product::create([
            'name' => $request->name,
            'image' => $image ? $image : "",
            'category_id' => $request->category_id,
            'supplier_id' =>$request->supplier_id,
            'brand' => $request->brand,
        ]);
     
          
    
        return redirect()->route('product.index');
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
         $categories = Category::all();
        $suppliers = Supplier::where('status',1)->get();
        return view('product.edit',['categories'=>$categories , 'suppliers'=>$suppliers ,'product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $request->validate([
            'name' => 'required|string',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'brand' => 'string',
        ]);

        // if($request->file("photo")){
        //     //---
        //     //lay anh cu de xoa
        //     $oldPhoto = Product::where("id","=",$id)->select("photo")->first();
        //     if(isset($oldPhoto->photo) && file_exists("uploads/product/".$image->image) && $oldPhoto != "")

        //         @unlink("uploads/products/".$oldPhoto->photo);//dau @ de che dau loi


       
      
        if($request->file("image")){
            $image = Product::where("id","=",$id)->first();
        if(isset($image->image) && file_exists("uploads/product/".$image->image)&& $image != ""){
        
          
                @unlink('uploads/product/'.$image->image);
            
            }
        
            
            $image = time().'.'.$request->file('image')->extension();
            $request->file("image")->move("uploads/product/",$image);
        }
            $product->update([
            'name' => $request->name,
            'image' => $image ? $image : "",
            'category_id' => $request->category_id,
            'supplier_id' =>$request->supplier_id,
            'brand' => $request->brand,
        ]);
     
          
    
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
 
            $image = Product::where("id","=",$id)->first();
        if(isset($image->image) && file_exists("uploads/product/".$image->image)&& $image != ""){
        
          
                @unlink('uploads/product/'.$image->image);
            
            }
   
        
        Product::destroy($id);
        return back();
    }
}
