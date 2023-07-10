<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::latest()->paginate(8);
        $title = "Unit Info";
       return view('unit.index',["units"=>$units,"title"=>$title]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('unit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'short_form' => 'required|string',
        ]);
        Unit::create([
            'name' => $request->name,
            'short_form' => $request->short_form
        ]);
        return redirect()->route('unit.index');
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
        $unit = Unit::find($id);

        return view('unit.edit',["unit"=>$unit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unit = Unit::find($id);
        $request->validate([
            'name' => 'required|string',
            'short_form' => 'required|string',
        ]);
        $unit->update([
            'name' => $request->name,
            'short_form' => $request->short_form
           
        ]);
      
      
        return redirect()->route('unit.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Unit::destroy($id);
        return back();
    }
}
