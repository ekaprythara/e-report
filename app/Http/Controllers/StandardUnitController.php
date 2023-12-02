<?php

namespace App\Http\Controllers;

use App\Models\StandardUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StandardUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/data-master/satuan', [
            "title" => "Satuan",
            "standardUnits" => StandardUnit::orderByDesc('id')
                ->get(),
        ]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:30|unique:standard_units,name'
        ]);

        $validated['user_id'] = Auth::user()->id;

        StandardUnit::create($validated);
        return redirect('/data-master/satuan')->with('create', 'Data satuan berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StandardUnit  $standardUnit
     * @return \Illuminate\Http\Response
     */
    public function show(StandardUnit $standardUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StandardUnit  $standardUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(StandardUnit $standardUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StandardUnit  $standardUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "name" => "required|min:3|max:30|unique:standard_units,name,$id"
        ];

        $request->validateWithBag("edit$id", $rules);

        $data = [
            "name" => $request->name
        ];

        StandardUnit::where('id', $id)
            ->update($data);
        return redirect('/data-master/satuan')->with('update', 'Data satuan berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StandardUnit  $standardUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StandardUnit::destroy($id);
        return redirect('/data-master/satuan')->with('delete', 'Data satuan berhasil dihapus');
    }
}
