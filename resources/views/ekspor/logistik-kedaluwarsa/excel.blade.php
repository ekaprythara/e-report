<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <table>
        <tr>
            <td colspan="7" style="text-align: center;">
                <b>PEMERINTAH PROVINSI BALI</b>
            </td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: center;">
                <b>Badan Penanggulangan Bencana Daerah</b>
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td colspan="7" style="text-align: center;">
                <b>LAPORAN KEDALUWARSA</b>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th><b>No.</b></th>
                <th><b>Logistik</b></th>
                <th><b>Penyuplai</b></th>
                <th><b>Stok</b></th>
                <th><b>Satuan</b></th>
                <th><b>Kedaluwarsa</b></th>
                <th><b>Jenis Pengadaan</b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inboundLogistics as $inboundLogistic)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $inboundLogistic->logistic->name }}</td>
                    <td>
                        {{ $inboundLogistic->supplier->name ?? $inboundLogistic->supplier }}
                    </td>
                    <td>{{ $inboundLogistic->stock }}</td>
                    <td>{{ $inboundLogistic->logistic->standardUnit->name }}</td>
                    <td>{{ $inboundLogistic->expiredDate }}</td>
                    <td>
                        {{ $inboundLogistic->logisticProcurement->name ?? $inboundLogistic->logisticProcurement }}
                    </td>
                </tr>
            @endforeach
            <tr></tr>
            <tr></tr>
            <tr>
                <td colspan="7" style="text-align: right;">
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
                <td colspan="7" style="text-align: right;">
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
                <td colspan="7" rowspan="4">
                </td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr>
                <td colspan="7" style="text-align: right; vertical-align:top; text-decoration:underline;">
                    <b>
                        {{ Auth::user()->name }}
                    </b>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
