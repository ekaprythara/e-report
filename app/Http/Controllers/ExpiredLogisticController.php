<?php

namespace App\Http\Controllers;

use App\Models\Logistic;
use Illuminate\Http\Request;
use App\Models\InboundLogistic;
use App\Models\OutboundLogistic;
use Illuminate\Support\Facades\Auth;

class ExpiredLogisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = now()->toDateString();

        return view('/transaksi/logistik-kedaluwarsa', [
            "title" => "Logistik Kedaluwarsa",
            "outboundLogistics" => OutboundLogistic::with(['inboundLogistic', 'receiver'])
                ->where('hasExpired', '=', '1')
                ->where('outboundDate', '>=', $now)
                ->where('outboundDate', '<=', $now)
                ->orderByDesc('outboundDate')
                ->latest()
                ->get(),
            "inboundLogistics" => InboundLogistic::with(['logistic', 'supplier', 'logisticProcurement'])
                ->where('stock', '>', '0')
                ->where('expiredDate', '<', $now)
                ->orderBy('expiredDate')
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
            'inboundLogistic_id.*' => 'required',
            'quantity.*' => 'required|numeric|gt:0|regex:/^[0-9]+$/',
            'description' => 'nullable|min:3|max:30',
        ]);

        foreach ($request->inboundLogistic_id as $key => $value) {
            $data = [
                'outboundDate' => $request->outboundDate,
                'inboundLogistic_id' => $request->inboundLogistic_id[$key],
                'quantity' => $request->quantity[$key],
                'description' => $request->description,
            ];

            $data['hasExpired'] = '1';
            $data['user_id'] = Auth::user()->id;

            // Cek
            $inboundLogistic = InboundLogistic::where('id', $request->inboundLogistic_id[$key])->value('stock');
            if ($request->quantity[$key] > $inboundLogistic) {
                return redirect('/transaksi/logistik-kedaluwarsa')->with('delete', 'Jumlah lebih besar daripada stok yang tersedia.');
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
        return redirect('/transaksi/logistik-kedaluwarsa')->with('create', 'Data logistik kedaluwarsa berhasil ditambahkan');
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
        return redirect('/transaksi/logistik-kedaluwarsa')->with('delete', 'Data logistik kedaluwarsa berhasil dihapus');
    }

    public function sortDate(Request $request)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required',
        ]);

        $from = $request->from;
        $to = $request->to;

        $sortedDate = OutboundLogistic::where('hasExpired', '=', '1')
            ->where('outboundDate', '>=', $from)
            ->where('outboundDate', '<=', $to)
            ->orderBy('outboundDate')
            ->oldest()
            ->get();

        return view('/transaksi/logistik-kedaluwarsa', [
            "title" => "Logistik Kedaluwarsa",
            "outboundLogistics" => $sortedDate,
            "inboundLogistics" => InboundLogistic::all(),
        ]);
    }

    public function resetDate()
    {
        return redirect('/transaksi/logistik-kedaluwarsa');
    }
}
