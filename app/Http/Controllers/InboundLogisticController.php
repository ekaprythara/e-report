<?php

namespace App\Http\Controllers;

use App\Models\Logistic;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\InboundLogistic;
use App\Models\OutboundLogistic;
use App\Models\LogisticProcurement;
use Illuminate\Support\Facades\Auth;

class InboundLogisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = now()->toDateString();

        return view('/transaksi/logistik-masuk', [
            "title" => "Logistik Masuk",
            "inboundLogistics" => InboundLogistic::with(['logistic', 'supplier', 'logisticProcurement'])
                ->where('inboundDate', '>=', $now)
                ->where('inboundDate', '<=', $now)
                ->orderByDesc('inboundDate')
                ->latest()
                ->get(),
            "logistics" => Logistic::with(['logisticType', 'standardUnit'])->get(),
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
        // Validation
        $request->validate([
            'inboundDate' => 'required|date',
            'supplier_id' => 'required',
            'logisticProcurement_id' => 'required',
            "logistic_id.*" => "required",
            "amount.*" => "required|numeric|gt:0|regex:/^[0-9]+$/",
            "stock.*" => "required|numeric|gt:0|regex:/^[0-9]+$/",
            "expiredDate.*" => "nullable|date",
            'description' => "nullable|min:3|max:30",
        ]);

        // Multiple input
        foreach ($request->logistic_id as $key => $value) {
            $data = [
                'inboundDate' => $request->inboundDate,
                'supplier_id' => $request->supplier_id,
                'logisticProcurement_id' => $request->logisticProcurement_id,
                'logistic_id' => $request->logistic_id[$key],
                'amount' => $request->amount[$key],
                'stock' => $request->amount[$key],
                'expiredDate' => $request->expiredDate[$key],
                'description' => $request->description,
            ];

            $data['user_id'] = Auth::user()->id;

            // Add the stock
            Logistic::where('id', $request->logistic_id[$key])
                ->increment('stock', $request->amount[$key]);

            // Store
            InboundLogistic::create($data);
        }
        return redirect('/transaksi/logistik-masuk')->with('create', 'Data logistik masuk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InboundLogistic  $inboundLogistic
     * @return \Illuminate\Http\Response
     */
    public function show(InboundLogistic $inboundLogistic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InboundLogistic  $inboundLogistic
     * @return \Illuminate\Http\Response
     */
    public function edit(InboundLogistic $inboundLogistic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InboundLogistic  $inboundLogistic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InboundLogistic  $inboundLogistic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $c = OutboundLogistic::all()->where('inboundLogistic_id', $id)->count();
        // dd($c !== 0);
        if ($c !== 0) {
            $a = OutboundLogistic::all()->where('inboundLogistic_id', $id);
            $b = OutboundLogistic::all()->where('inboundLogistic_id', $id)->count('array');
            $v = 0;
            for ($i = 0; $i < $b; $i++) {
                foreach ($a as $z[]) {
                    $z[$i]->quantity;
                }
                $v += $z[$i]->quantity;
            }
            // dd($v);
            $_items = InboundLogistic::all()->where('id', $id);
            foreach ($_items as $item) {
                $_logistics = Logistic::find($item->logistic_id);
                $_logistics->stock -= $item->amount;
            }
            $_logistics->stock += $v;
            // dd($_logistics);
            $_logistics->save();
        } else {
            $items = InboundLogistic::all()->where('id', $id);
            foreach ($items as $item) {
                $logistics = Logistic::find($item->logistic_id);
                $logistics->stock += 0;
                $logistics->stock -= $item->amount;
            }
            // dd($logistics);
            $logistics->save();
        }

        InboundLogistic::destroy($id);
        return redirect('/transaksi/logistik-masuk')->with('delete', 'Data logistik masuk berhasil dihapus');
    }

    public function sortDate(Request $request)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required',
        ]);

        $from = $request->from;
        $to = $request->to;

        $sortedDate = InboundLogistic::where('inboundDate', '>=', $from)
            ->where('inboundDate', '<=', $to)
            ->orderBy('inboundDate')
            ->oldest()
            ->get();

        return view('/transaksi/logistik-masuk', [
            "title" => "Logistik Masuk",
            "inboundLogistics" => $sortedDate,
            "logistics" => Logistic::all(),
            "suppliers" => Supplier::all(),
            "logisticProcurements" => LogisticProcurement::all()
        ]);
    }

    public function resetDate()
    {
        return redirect('/transaksi/logistik-masuk');
    }
}
