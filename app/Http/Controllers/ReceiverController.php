<?php

namespace App\Http\Controllers;

use App\Models\Receiver;
use App\Models\ReceiverUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/data-master/penerima', [
            "title" => "Penerima",
            "receivers" => Receiver::with('receiverUnit')->orderByDesc('id')
                ->get(),
            "receiverUnits" => ReceiverUnit::all()
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
            'name' => 'required|min:3|max:30',
            'phone' => 'nullable|numeric|digits_between:10,13|unique:receivers,phone',
            'receiverUnit_id' => 'required',
            'description' => 'nullable|min:3|max:30'
        ]);

        $validated['user_id'] = Auth::user()->id;

        Receiver::create($validated);
        return redirect('/data-master/penerima')->with('create', 'Data penerima berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receiver  $receiver
     * @return \Illuminate\Http\Response
     */
    public function show(Receiver $receiver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receiver  $receiver
     * @return \Illuminate\Http\Response
     */
    public function edit(Receiver $receiver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receiver  $receiver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "name" => 'required|min:3|max:30',
            "phone" => "nullable|numeric|digits_between:10,13|unique:receivers,phone,$id",
            "receiverUnit_id" => 'required',
            "description" => 'nullable|min:5|max:30'
        ];

        $request->validateWithBag("edit$id", $rules);

        $data = [
            "name" =>  $request->name,
            "phone" =>  $request->phone,
            "receiverUnit_id" =>  $request->receiverUnit_id,
            "description" =>  $request->description,
        ];

        Receiver::where('id', $id)
            ->update($data);
        return redirect('/data-master/penerima')->with('update', 'Data penerima berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receiver  $receiver
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Receiver::destroy($id);
        return redirect('/data-master/penerima')->with('delete', 'Data penerima berhasil dihapus');
    }
}
