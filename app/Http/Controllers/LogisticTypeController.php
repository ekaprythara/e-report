<?php

namespace App\Http\Controllers;

use App\Models\LogisticType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogisticTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/data-master/jenis-logistik', [
            "title" => "Jenis Logistik",
            "logisticTypes" => LogisticType::orderByDesc('id')
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
            'name' => 'required|min:3|max:30|unique:logistic_types,name',
            'expiredDate' => 'required|boolean'
        ]);

        $validated['user_id'] = Auth::user()->id;

        LogisticType::create($validated);
        return redirect('/data-master/jenis-logistik')->with('create', 'Data jenis logistik berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LogisticType  $logisticType
     * @return \Illuminate\Http\Response
     */
    public function show(LogisticType $logisticType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogisticType  $logisticType
     * @return \Illuminate\Http\Response
     */
    public function edit(LogisticType $logisticType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LogisticType  $logisticType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "name" => "required|min:3|max:30|unique:logistic_types,name,$id",
            "expiredDate" => 'required|boolean'
        ];

        $request->validateWithBag("edit$id", $rules);

        $data = [
            "name" => $request->name,
            "expiredDate" => $request->expiredDate,
        ];

        LogisticType::where('id', $id)
            ->update($data);
        return redirect('/data-master/jenis-logistik')->with('update', 'Data jenis logistik berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogisticType  $logisticType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LogisticType::destroy($id);
        return redirect('/data-master/jenis-logistik')->with('delete', 'Data jenis logistik berhasil dihapus');
    }
}
