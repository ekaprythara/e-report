<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InboundLogistic;
use App\Models\Logistic;
use App\Models\OutboundLogistic;
use App\Models\Receiver;
use App\Models\Supplier;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now = now()->toDateString();

        return view('/dashboard/beranda', [
            "title" => "Beranda",
            "users" => User::count(),
            "receivers" => Receiver::count(),
            "logistics" => Logistic::count(),
            "suppliers" => Supplier::count(),
            "inboundLogistics" => InboundLogistic::where('inboundDate', $now)
                ->count(),
            "outboundLogistics" => OutboundLogistic::where('hasExpired', '=', '0')
                ->where('outboundDate', $now)
                ->count(),
            "expiredLogisticsKabid" => InboundLogistic::where('expiredDate', '<=', now())
                ->where('stock', '>', '0')
                ->count(),
            "expiredLogisticsPegawai" => OutboundLogistic::where('hasExpired', '=', '1')
                ->where('outboundDate', $now)
                ->count(),
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
}
