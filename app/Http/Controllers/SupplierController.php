<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/data-master/penyuplai', [
            "title" => "Penyuplai",
            "suppliers" => Supplier::orderByDesc('id')
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
            'name' => 'required|min:3|max:30|unique:suppliers,name',
            'address' => 'nullable|min:3|max:35',
            'contactPerson' => 'required|min:3|max:30',
            'telephone' => 'nullable|numeric|digits_between:10,13|unique:suppliers,telephone'
        ]);

        $validated['user_id'] = Auth::user()->id;

        Supplier::create($validated);
        return redirect('/data-master/penyuplai')->with('create', 'Data penyuplai berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "name" => "required|min:3|max:30|unique:suppliers,name,$id",
            "address" => 'nullable|min:5|max:35',
            "contactPerson" => "required|min:3|max:30|unique:suppliers,contactPerson,$id",
            "telephone" => "nullable|numeric|digits_between:10,13|unique:suppliers,telephone,$id"
        ];

        $request->validateWithBag("edit$id", $rules);

        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'contactPerson' => $request->contactPerson,
            'telephone' => $request->telephone,
        ];

        Supplier::where('id', $id)
            ->update($data);
        return redirect('/data-master/penyuplai')->with('update', 'Data penyuplai berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Supplier::destroy($id);
        return redirect('/data-master/penyuplai')->with('delete', 'Data penyuplai berhasil dihapus');
    }
}
