<?php

namespace App\Http\Controllers;

use App\Models\ReceiverUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiverUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/data-master/unit-penerima', [
            "title" => "Unit Penerima",
            "receiverUnits" => ReceiverUnit::orderByDesc('id')
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
            'name' => 'required|min:3|max:30|unique:receiver_units,name',
            'address' => 'nullable|min:3|max:35',
            'email' => 'nullable|min:5|max:30|email:rfc,dns|unique:receiver_units,email',
            'telephone' => 'nullable|numeric|digits_between:10,13|unique:receiver_units,telephone'
        ]);

        $validated['user_id'] = Auth::user()->id;

        ReceiverUnit::create($validated);
        return redirect('/data-master/unit-penerima')->with('create', 'Data unit penerima berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReceiverUnit  $receiverUnit
     * @return \Illuminate\Http\Response
     */
    public function show(ReceiverUnit $receiverUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReceiverUnit  $receiverUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(ReceiverUnit $receiverUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReceiverUnit  $receiverUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReceiverUnit $receiverUnit, $id)
    {
        $rules = [
            "name" => "required|min:3|max:30|unique:receiver_units,name,$id",
            "address" => 'nullable|min:3|max:35',
            "email" => "nullable|min:5|max:30|email:rfc,dns|unique:receiver_units,email,$id",
            "telephone" => "nullable|numeric|digits_between:10,13|unique:receiver_units,telephone,$id"
        ];

        $request->validateWithBag("edit$id", $rules);

        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ];

        ReceiverUnit::where('id', $id)
            ->update($data);
        return redirect('/data-master/unit-penerima')->with('update', 'Data unit penerima berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReceiverUnit  $receiverUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ReceiverUnit::destroy($id);
        return redirect('/data-master/unit-penerima')->with('delete', 'Data unit penerima berhasil dihapus');
    }
}
