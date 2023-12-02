<?php

namespace App\Http\Controllers;

use App\Models\InboundLogistic;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ExpiredExport;

class ExpiredController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/laporan/logistik-kedaluwarsa', [
            "title" => "Laporan Logistik Kedaluwarsa",
            "inboundLogistics" => InboundLogistic::with(['logistic', 'supplier', 'logisticProcurement'])
                ->where('stock', '>', '0')
                ->where('expiredDate', '<=', now())
                ->orderBy('expiredDate')
                ->latest()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function print()
    {
        $inboundLogistics = InboundLogistic::with(['logistic', 'supplier', 'logisticProcurement'])
            ->where('expiredDate', '<=', now())
            ->where('stock', '>', '0')
            ->orderBy('expiredDate')
            ->latest()
            ->get();
        view()->share('inboundLogistics', $inboundLogistics);
        $pdf = PDF::loadView('/ekspor/logistik-kedaluwarsa/pdf')
            ->setPaper('f4', 'portrait');
        return $pdf->stream();
    }

    public function csv()
    {
        return (new ExpiredExport)->download('Expired.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function ods()
    {
        return (new ExpiredExport)->download('Expired.ods', \Maatwebsite\Excel\Excel::ODS);
    }

    public function pdf()
    {
        $inboundLogistics = InboundLogistic::with(['logistic', 'supplier', 'logisticProcurement'])
            ->where('expiredDate', '<=', now())
            ->where('stock', '>', '0')
            ->orderBy('expiredDate')
            ->latest()
            ->get();
        view()->share('inboundLogistics', $inboundLogistics);
        $pdf = PDF::loadView('/ekspor/logistik-kedaluwarsa/pdf')
            ->setPaper('f4', 'portrait');
        return $pdf->download('Expired.pdf');
    }

    public function xls()
    {
        return (new ExpiredExport)->download('Expired.xls', \Maatwebsite\Excel\Excel::XLS);
    }

    public function xlsx()
    {
        return (new ExpiredExport)->download('Expired.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
