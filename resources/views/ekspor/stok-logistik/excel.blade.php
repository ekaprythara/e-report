<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <table>
        <tr>
            <td colspan="5" style="text-align: center;">
                <b>PEMERINTAH PROVINSI BALI</b>
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">
                <b>Badan Penanggulangan Bencana Daerah</b>
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: center;">
                <b>LAPORAN STOK LOGISTIK</b>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th><b>No.</b></th>
                <th><b>Logistik</b></th>
                <th><b>Jenis Logistik</b></th>
                <th><b>Stok</b></th>
                <th><b>Satuan</b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logistics as $logistic)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $logistic->name }}</td>
                    <td>{{ $logistic->logisticType->name }}</td>
                    <td>
                        @if ($logistic->stock == 0)
                            0
                        @else
                            {{ $logistic->stock }}
                        @endif
                    </td>
                    <td>{{ $logistic->standardUnit->name }}</td>
                </tr>
            @endforeach
            <tr></tr>
            <tr></tr>
            <tr>
                <td colspan="5" style="text-align: right;">
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
                <td colspan="5" style="text-align: right;">
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
                <td colspan="5" rowspan="4">
                </td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr></tr>
            <tr>
                <td colspan="5" style="text-align: right; vertical-align:top; text-decoration:underline;">
                    <b>
                        {{ Auth::user()->name }}
                    </b>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
