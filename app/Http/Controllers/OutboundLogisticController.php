<?php

namespace App\Http\Controllers;

use App\Models\Logistic;
use App\Models\Receiver;
use App\Models\ReceiverUnit;
use Illuminate\Http\Request;
use App\Models\InboundLogistic;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OutboundLogistic;
use Illuminate\Support\Facades\Auth;

class OutboundLogisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = now()->toDateString();

        return view('/transaksi/logistik-keluar', [
            "title" => "Logistik Keluar",
            "outboundLogistics" => OutboundLogistic::with(['inboundLogistic', 'receiver'])
                ->where('hasExpired', '=', '0')
                ->where('outboundDate', '>=', $now)
                ->where('outboundDate', '<=', $now)
                ->orderByDesc('outboundDate')
                ->latest()
                ->get(),
            "inboundLogistics" => InboundLogistic::with(['logistic', 'supplier', 'logisticProcurement'])
                ->where('stock', '>', '0')
                ->orderBy('logistic_id')
                ->orderBy('expiredDate')
                ->oldest()
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
        $request->validate([
            'outboundDate' => 'required|date',
            'receiver_id' => 'required',
            'inboundLogistic_id.*' => 'required',
            'quantity.*' => 'required|numeric|gt:0|regex:/^[0-9]+$/',
            'description' => 'nullable|min:3|max:30',
        ]);

        foreach ($request->inboundLogistic_id as $key => $value) {
            $data = [
                'outboundDate' => $request->outboundDate,
                'receiver_id' => $request->receiver_id,
                'inboundLogistic_id' => $request->inboundLogistic_id[$key],
                'quantity' => $request->quantity[$key],
                'description' => $request->description,
            ];

            $data['hasExpired'] = '0';
            $data['user_id'] = Auth::user()->id;

            // Cek
            $inboundLogistic = InboundLogistic::where('id', $request->inboundLogistic_id[$key])->value('stock');
            if ($request->quantity[$key] > $inboundLogistic) {
                return redirect('/transaksi/logistik-keluar')->with('delete', 'Jumlah lebih besar daripada stok yang tersedia.');
            }

            // Mengurangi Stok
            $id = $request->inboundLogistic_id[$key];
            $items = InboundLogistic::all()->where('id', $id);
            foreach ($items as $item) {
                Logistic::find($item->logistic_id)
                    ->decrement('stock', $request->quantity[$key]);
            }

            // Mengurangi Logistik Masuk
            InboundLogistic::where('id', $id)
                ->decrement('stock', $request->quantity[$key]);

            // Store
            OutboundLogistic::create($data);
        }
        return redirect('/transaksi/logistik-keluar')->with('create', 'Data logistik keluar berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OutboundLogistic  $outboundLogistic
     * @return \Illuminate\Http\Response
     */
    public function show(OutboundLogistic $outboundLogistic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OutboundLogistic  $outboundLogistic
     * @return \Illuminate\Http\Response
     */
    public function edit(OutboundLogistic $outboundLogistic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OutboundLogistic  $outboundLogistic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OutboundLogistic $outboundLogistic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OutboundLogistic  $outboundLogistic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items = OutboundLogistic::all()->where('id', $id);

        // Menambah Logistik Masuk
        foreach ($items as $item) {
            $a = InboundLogistic::all()->where('id', $item->inboundLogistic_id);
            foreach ($a as $inboundLogistic) {
                $inboundLogistic->stock += $item->quantity;
            }
        }
        $inboundLogistic->save();

        // Menambah Stok Logistik
        foreach ($items as $item) {
            $inboundLogistics = InboundLogistic::all()->where('id', $item->inboundLogistic_id);
            foreach ($inboundLogistics as $inboundLogistic) {
                $logistic = Logistic::find($inboundLogistic->logistic_id);
            }
            $logistic->stock += $item->quantity;
        }
        $logistic->save();

        OutboundLogistic::destroy($id);
        return redirect('/transaksi/logistik-keluar')->with('delete', 'Data logistik keluar berhasil dihapus');
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

        return view('/transaksi/logistik-keluar', [
            "title" => "Logistik Keluar",
            "outboundLogistics" => $sortedDate,
            "inboundLogistics" => InboundLogistic::all(),
        ]);
    }

    public function resetDate()
    {
        return redirect('/transaksi/logistik-keluar');
    }
}
