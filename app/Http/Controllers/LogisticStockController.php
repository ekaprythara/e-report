<?php

namespace App\Http\Controllers;

use App\Models\Logistic;
use Illuminate\Http\Request;
use App\Models\LogisticStock;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LogisticStockExport;
use App\Models\InboundLogistic;

class LogisticStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/laporan/stok-logistik', [
            "title" => "Stok Logistik",
            "logistics" => Logistic::all()
                ->sortBy('name'),
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LogisticStock  $logisticStock
     * @return \Illuminate\Http\Response
     */
    public function show(LogisticStock $logisticStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LogisticStock  $logisticStock
     * @return \Illuminate\Http\Response
     */
    public function edit(LogisticStock $logisticStock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LogisticStock  $logisticStock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogisticStock $logisticStock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogisticStock  $logisticStock
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogisticStock $logisticStock)
    {
        //
    }

    public function print()
    {
        $logistics = Logistic::all()
            ->sortBy('name');

        view()->share('logistics', $logistics);
        $pdf = PDF::loadView('/ekspor/stok-logistik/pdf')
            ->setPaper('f4', 'portrait')
            ->setOptions([
                'tempDir' => public_path(),
                'chroot' => public_path('/img'),
            ]);
        return $pdf->stream();
    }

    public function ods()
    {
        return (new LogisticStockExport)->download('LogisticStock.ods', \Maatwebsite\Excel\Excel::ODS);
    }

    public function pdf()
    {
        $logistics = Logistic::all()
            ->sortBy('name');

        view()->share('logistics', $logistics);
        $pdf = PDF::loadView('/ekspor/stok-logistik/pdf')
            ->setPaper('f4', 'portrait');
        return $pdf->download('LogisticStock.pdf');
    }

    public function xls()
    {
        return (new LogisticStockExport)->download('LogisticStock.xls', \Maatwebsite\Excel\Excel::XLS);
    }

    public function xlsx()
    {
        return (new LogisticStockExport)->download('LogisticStock.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
