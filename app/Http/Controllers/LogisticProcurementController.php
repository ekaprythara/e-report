<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogisticProcurement;
use Illuminate\Support\Facades\Auth;

class LogisticProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/data-master/jenis-pengadaan', [
            "title" => "Jenis Pengadaan",
            "logisticProcurements" => LogisticProcurement::orderByDesc('id')
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
            'name' => 'required|min:3|max:30|unique:logistic_procurements,name'
        ]);

        $validated['user_id'] = Auth::user()->id;

        LogisticProcurement::create($validated);
        return redirect('/data-master/jenis-pengadaan')->with('create', 'Data pengadaan logistik berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LogisticProcurement  $logisticProcurement
     * @return \Illuminate\Http\Response
     */
    public function show(LogisticProcurement $logisticProcurement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogisticProcurement  $logisticProcurement
     * @return \Illuminate\Http\Response
     */
    public function edit(LogisticProcurement $logisticProcurement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LogisticProcurement  $logisticProcurement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "name" => "required|min:3|max:30|unique:logistic_procurements,name,$id"
        ];

        $request->validateWithBag("edit$id", $rules);

        $data = [
            "name" => $request->name,
        ];

        LogisticProcurement::where('id', $id)
            ->update($data);
        return redirect('/data-master/jenis-pengadaan')->with('update', 'Data jenis pengadaan berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogisticProcurement  $logisticProcurement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LogisticProcurement::destroy($id);
        return redirect('/data-master/jenis-pengadaan')->with('delete', 'Data jenis pengadaan berhasil dihapus');
    }
}
