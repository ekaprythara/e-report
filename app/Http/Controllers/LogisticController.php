<?php

namespace App\Http\Controllers;

use App\Models\Logistic;
use App\Models\LogisticType;
use App\Models\StandardUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/data-master/logistik', [
            "title" => "Logistik",
            "logistics" => Logistic::with(['logisticType', 'standardUnit'])
                ->orderByDesc('id')
                ->get(),
            "logisticTypes" => LogisticType::all(),
            "standardUnits" => StandardUnit::all()
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
            'name' => 'required|min:3|max:30|unique:logistics,name',
            'logisticType_id' => 'required',
            'standardUnit_id' => 'required',
            'stock' => 'required',
        ]);

        $validated['user_id'] = Auth::user()->id;

        Logistic::create($validated);
        return redirect('/data-master/logistik')->with('create', 'Data logistik berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Logistic  $logistic
     * @return \Illuminate\Http\Response
     */
    public function show(Logistic $logistic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Logistic  $logistic
     * @return \Illuminate\Http\Response
     */
    public function edit(Logistic $logistic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Logistic  $logistic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "name" => "required|min:3|max:30|unique:logistics,name,$id",
            "logisticType_id" => 'required',
            "standardUnit_id" => 'required',
        ];

        $request->validateWithBag("edit$id", $rules);

        $data = [
            'name' => $request->name,
            'logisticType_id' => $request->logisticType_id,
            'standardUnit_id' => $request->standardUnit_id,
        ];

        Logistic::where('id', $id)
            ->update($data);
        return redirect('/data-master/logistik')->with('update', 'Data logistik berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Logistic  $logistic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $a = Logistic::where('id', $id)->get('stock');
        foreach ($a as $b) {
            $b->stock;
        }
        if ($b->stock != 0) {
            return redirect('/data-master/logistik')->with('update', "Logistik ini masih memiliki $b->stock stok yang tersisa");
        }

        Logistic::destroy($id);
        return redirect('/data-master/logistik')->with('delete', 'Data logistik berhasil dihapus');
    }
}
