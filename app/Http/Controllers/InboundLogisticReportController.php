<?php

namespace App\Http\Controllers;

use App\Models\Logistic;
use App\Models\Supplier;
use App\Models\StandardUnit;
use Illuminate\Http\Request;
use App\Models\InboundLogistic;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LogisticProcurement;
use App\Models\InboundLogisticReport;
use App\Exports\InboundLogisticExport;


class InboundLogisticReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = now()->toDateString();

        return view('/laporan/logistik-masuk', [
            "title" => "Laporan Logistik Masuk",
            "inboundLogistics" => InboundLogistic::with(['logistic', 'supplier', 'logisticProcurement'])
                ->where('inboundDate', '>=', $now)
                ->where('inboundDate', '<=', $now)
                ->orderByDesc('inboundDate')
                ->latest()
                ->get(),
            "logistics" => Logistic::all(),
            "suppliers" => Supplier::all(),
            "logisticProcurements" => LogisticProcurement::all()
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
     * @param  \App\Models\InboundLogisticReport  $inboundLogisticReport
     * @return \Illuminate\Http\Response
     */
    public function show(InboundLogisticReport $inboundLogisticReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InboundLogisticReport  $inboundLogisticReport
     * @return \Illuminate\Http\Response
     */
    public function edit(InboundLogisticReport $inboundLogisticReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InboundLogisticReport  $inboundLogisticReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InboundLogisticReport $inboundLogisticReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InboundLogisticReport  $inboundLogisticReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(InboundLogisticReport $inboundLogisticReport)
    {
        //
    }

    public function print(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $inboundLogistics = InboundLogistic::with('logistic', 'supplier', 'logisticProcurement')
            ->where('inboundDate', '>=', $from)
            ->where('inboundDate', '<=', $to)
            ->orderBy('inboundDate')
            ->oldest()
            ->get();

        view()->share('inboundLogistics', $inboundLogistics);
        $pdf = PDF::loadView('/ekspor/logistik-masuk/pdf', [
            "title" => "Logistik Masuk",
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
            return (new InboundLogisticExport($from, $to))->download('InboundLogistics.ods', \Maatwebsite\Excel\Excel::ODS);
        } elseif ($format == 'pdf') {
            $inboundLogistics = InboundLogistic::with(['logistic', 'supplier', 'logisticProcurement'])
                ->where('inboundDate', '>=', $from)
                ->where('inboundDate', '<=', $to)
                ->orderBy('inboundDate')
                ->oldest()
                ->get();

            view()->share('inboundLogistics', $inboundLogistics);
            $pdf = PDF::loadView('/ekspor/logistik-masuk/pdf', [
                "title" => "Logistik Masuk",
                "from" => $from,
                "to" => $to
            ])
                ->setPaper('f4', 'portrait');
            return $pdf->download('InboundLogistics.pdf');
        } elseif ($format == 'xls') {
            return (new InboundLogisticExport($from, $to))->download('InboundLogistics.xls', \Maatwebsite\Excel\Excel::XLS);
        } elseif ($format == 'xlsx') {
            return (new InboundLogisticExport($from, $to))->download('InboundLogistics.xlsx', \Maatwebsite\Excel\Excel::XLSX);
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

        $sortedDate = InboundLogistic::with(['logistic', 'supplier', 'logisticProcurement'])
            ->where('inboundDate', '>=', $from)
            ->where('inboundDate', '<=', $to)
            ->orderBy('inboundDate')
            ->oldest()
            ->get();

        return view('/laporan/logistik-masuk', [
            "title" => "Logistik Masuk",
            "inboundLogistics" => $sortedDate,
            "logistics" => Logistic::with('logisticType', 'standardUnit'),
            "suppliers" => Supplier::all(),
            "logisticProcurements" => LogisticProcurement::all(),
        ]);
    }

    public function resetDate()
    {
        return redirect('/laporan/logistik-masuk');
    }
}
