<?php

namespace App\Http\Controllers;

use App\Models\OutboundLogistic;
use App\Models\OutboundLogisticReport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\OutboundLogisticExport;



class OutboundLogisticReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = now()->toDateString();

        return view('/laporan/logistik-keluar', [
            "title" => "Laporan Logistik Keluar",
            "outboundLogistics" => OutboundLogistic::where('hasExpired', '=', '0')
                ->where('outboundDate', '>=', $now)
                ->where('outboundDate', '<=', $now)
                ->orderByDesc('outboundDate')
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
     * @param  \App\Models\OutboundLogisticReport  $outboundLogisticReport
     * @return \Illuminate\Http\Response
     */
    public function show(OutboundLogisticReport $outboundLogisticReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OutboundLogisticReport  $outboundLogisticReport
     * @return \Illuminate\Http\Response
     */
    public function edit(OutboundLogisticReport $outboundLogisticReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OutboundLogisticReport  $outboundLogisticReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OutboundLogisticReport $outboundLogisticReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OutboundLogisticReport  $outboundLogisticReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(OutboundLogisticReport $outboundLogisticReport)
    {
        //
    }

    public function print(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $outboundLogistics = OutboundLogistic::where('hasExpired', '=', '0')
            ->where('outboundDate', '>=', $from)
            ->where('outboundDate', '<=', $to)
            ->orderBy('outboundDate')
            ->oldest()
            ->get();


        view()->share('outboundLogistics', $outboundLogistics);
        $pdf = PDF::loadView('/ekspor/logistik-keluar/pdf', [
            "title" => "Logistik Keluar",
            "from" => $from,
            "to" => $to
        ])
            ->setPaper('f4', 'portrait');
        return $pdf->stream();
    }

    public function export(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $format = $request->input('format');

        if ($format == 'ods') {
            return (new OutboundLogisticExport($from, $to))->download('OutboundLogistics.ods', \Maatwebsite\Excel\Excel::ODS);
        } elseif ($format == 'pdf') {
            $outboundLogistics = OutboundLogistic::where('hasExpired', '=', '0')
                ->where('outboundDate', '>=', $from)
                ->where('outboundDate', '<=', $to)
                ->orderBy('outboundDate')
                ->oldest()
                ->get();

            view()->share('outboundLogistics', $outboundLogistics);
            $pdf = PDF::loadView('/ekspor/logistik-keluar/pdf', [
                "title" => "Logistik Keluar",
                "from" => $from,
                "to" => $to
            ])
                ->setPaper('f4', 'portrait');
            return $pdf->download('OutboundLogistics.pdf');
        } elseif ($format == 'xls') {
            return (new OutboundLogisticExport($from, $to))->download('OutboundLogistics.xls', \Maatwebsite\Excel\Excel::XLS);
        } elseif ($format == 'xlsx') {
            return (new OutboundLogisticExport($from, $to))->download('OutboundLogistics.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        }
    }

    public function sortDate(Request $request)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required',
        ]);

        $from = $request->from;
        $to = $request->to;

        $sortedDate = OutboundLogistic::where('hasExpired', '=', '0')
            ->where('outboundDate', '>=', $from)
            ->where('outboundDate', '<=', $to)
            ->orderBy('outboundDate')
            ->oldest()
            ->get();

        return view('/laporan/logistik-keluar', [
            "title" => "Logistik Keluar",
            "outboundLogistics" => $sortedDate,
        ]);
    }

    public function resetDate()
    {
        return redirect('/laporan/logistik-keluar');
    }
}
