<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <table>
        <tr>
            <td colspan="9" style="text-align: center;">
                <b>PEMERINTAH PROVINSI BALI</b>
            </td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: center;">
                <b>Badan Penanggulangan Bencana Daerah</b>
            </td>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="9" style="text-align: center;">
                <b>LAPORAN LOGISTIK MASUK</b>
            </td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: center;">
                <b>@php
                    $start = Carbon\Carbon::parse($from)->locale('id');
                    $start->settings(['formatFunction' => 'translatedFormat']);
                    echo $start->format('d F Y');
                @endphp -
                    @php
                        $end = Carbon\Carbon::parse($to)->locale('id');
                        $end->settings(['formatFunction' => 'translatedFormat']);
                        echo $end->format('d F Y');
                    @endphp</b>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th><b>No.</b></th>
                <th><b>Tanggal Masuk</b></th>
                <th><b>Logistik</b></th>
                <th><b>Penyuplai</b></th>
                <th><b>Jumlah</b></th>
                <th><b>Satuan</b></th>
                <th><b>Kadaluarsa</b></th>
                <th><b>Jenis Pengadaan</b></th>
                <th><b>Keterangan</b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inboundLogistics as $inboundLogistic)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $inboundLogistic->inboundDate }}</td>
                    <td>{{ $inboundLogistic->logistic->name }}</td>
                    <td>
                        {{ $inboundLogistic->supplier->name ?? $inboundLogistic->supplier }}
                    </td>
                    <td>{{ $inboundLogistic->amount }}</td>
                    <td>{{ $inboundLogistic->logistic->standardUnit->name }}</td>
                    <td>{{ $inboundLogistic->expiredDate }}</td>
                    <td>
                        {{ $inboundLogistic->logisticProcurement->name ?? $inboundLogistic->logisticProcurement }}
                    </td>
                    <td>{{ $inboundLogistic->description }}</td>
                </tr>
            @endforeach
            {{-- <tr></tr>
            <tr></tr>
            <tr>
                <td colspan="9" style="text-align: right;">
                    <b>
                        Denpasar,
                        @php
                            $date = Carbon\Carbon::now()->locale('id');
                            $date->settings(['formatFunction' => 'translatedFormat']);
                            echo $date->format('d F Y');
                        @endphp
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="9" style="text-align: right;">
                    <b>
                        {{ Auth::user()->level->name }}
                        @if (Auth::user()->level_id == '1')
                            Kedaruratan dan Logistik
                        @else
                            Logistik dan Peralatan
                        @endif
                    </b>
                </td>
            </tr>
            <tr>
                <td colspan="9" rowspan="4">
                </td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr>
                <td colspan="9" style="text-align: right; vertical-align:top; text-decoration:underline;">
                    <b>
                        {{ Auth::user()->name }}
                    </b>
                </td>
            </tr> --}}
        </tbody>
    </table>
</body>

</html>
