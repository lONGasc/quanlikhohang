<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Image;
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::where("status",1)->paginate(8);
        $title = "Suppliers Info";
       return view('supplier.index',["suppliers"=>$suppliers,"title"=>$title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required|unique:suppliers,email',
            'phone' => 'required|numeric|unique:suppliers,phone',
            'address' => 'required',
        ]);
        $image = "";
        if($request->hasFile('image')){
            $image = time().'.'.$request->file('image')->extension();
            $request->file("image")->move("uploads/supplier",$image);
        }
 
        Supplier::create([
            'name' => $request->name,
            'image' => $image ? $image : "",
            'email' => $request->email,
            'phone' =>$request->phone,
            'address' => $request->address,
            'status' =>$request->status,
        ]);
     
          
        if ($request->status == 1) {
            return redirect()->route('supplier.index');
        }
        return redirect()->route('customer.index');
       
        
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
        $supplier = Supplier::find($id);

       return view('supplier.edit',["supplier"=>$supplier]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supplier = Supplier::find($id);
        if($request->phone != $supplier->phone){
            $request->validate([
               
                'phone' => 'required|numeric|unique:suppliers,phone',
              
            ]);
        }
        if($request->email != $supplier->email){
            $request->validate([
              
                
                'email' => 'required|unique:suppliers,email',
             
            ]);
        }
        $request->validate([
            'name' => 'required|string',
            'image' => 'image|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
        ]);
   
        if($request->file("image")){
            $image = Supplier::where("id","=",$id)->first();
        if(isset($image->image) && file_exists("uploads/supplier/".$image->image)&& $image != ""){
        
          
                @unlink('uploads/supplier/'.$image->image);
            
            }
        
            
            $image = time().'.'.$request->file('image')->extension();
            $request->file("image")->move("uploads/supplier/",$image);
        }

        // if($request->file("image")){           
        //     $photo = time()."_".$request->file("image")->getClientOriginalName();
        //     //thuc hien upload anh
        //     $request->file("image")->move("uploads/products",$photo);
        // }   
        $supplier->update([
            'name' => $request->name,
            'image' => $image ? $image : $supplier->image,
            'email' => $request->email,
            'phone' =>$request->phone,
            'address' => $request->address,
            'status' =>$request->status
        ]);
      
        if ($request->status == 1) {
            return redirect()->route('supplier.index');
        }
        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      

        $image = Supplier::where("id","=",$id)->first();
        if(isset($image->image) && file_exists("uploads/supplier/".$image->image)&& $image != ""){
        
          
                @unlink('uploads/supplier/'.$image->image);
            
            }
   
        
            
            Supplier::destroy($id);
            return back();
     

    }
}
