<!DOCTYPE html>
<html>

<head>
    <style>
        .aksara {
            font-family: 'bali simbar dwijendra';
            font-style: normal;
            font-weight: 400;
            padding-top: 7px;
            padding-bottom: 15px;
        }

        .text-right {
            text-align: right;
        }

        .page-break {
            page-break-before: auto;
        }

        .footer {
            float: right;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        #head {
            width: 100%;
            line-height: 5px;
        }

        #head tr td {
            text-align: center;
            font-size: small;
        }

        #head tr td hr {
            width: 90%;
        }

        #title {
            text-align: center;
            line-height: 2px;
            padding: 5px 5px 5px;
        }

        #body {
            border-collapse: collapse;
            width: 100%;
            font-size: 10pt;
            color: black;
        }

        #body td,
        #body th {
            padding: 5px;
            border: 1px solid black;
        }

        #body tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #body th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            background-color: #FEB139;
            color: black;
        }

        #foot {
            width: 100%;
            margin-top: 20px;
            font-size: small;
            text-align: left;
            line-height: 5px;
        }
    </style>
</head>

<body>
    <div class="page-break">
        <table id="head">
            <tr>
                <td>
                    <img src="{{ public_path('/img/logo-pemprov.png') }}" alt="Logo Pemprov Bali" width="150"
                        height="150">
                </td>
                <td>
                    <h2 class="aksara">p) m) ri nÓ ;¾ ¿ epÉo pi nŠi ¿ b lø</h2>
                    <h2>PEMERINTAH PROVINSI BALI</h2>
                    <h2 class="aksara">b d n/¾ ¿ p) n \á¡ l \ n/¾ ¿ ¿ b) ZÇÿ n ¿ ¿ d6 r ;¾</h2>
                    <h2>BADAN PENANGGULANGAN BENCANA DAERAH</h2>
                    <p>Jalan D.I. Panjaitan No. 6 Denpasar - Bali 80235</p>
                    <p>Telp: 0361-245397, Fax: 0361-245395</p>
                    <p>Laman: <a href="http://www.bpbd.baliprov.go.id/">bpbd.baliprov.go.id</a>, Surel:
                        bpbd@baliprov.go.id
                    </p>
                </td>
            </tr>
        </table>
        <hr>
        <div id="title">
            <h3>LAPORAN STOK LOGISTIK</h3>
        </div>
    </div>

    <div>
        <table id="body">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Logistik</th>
                    <th>Jenis Logistik</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logistics as $logistic)
                    <tr>
                        <td class="text-right">{{ $loop->iteration }}</td>
                        <td>{{ $logistic->name }}</td>
                        <td>{{ $logistic->logisticType->name }}</td>
                        <td class="text-right">{{ $logistic->stock }}</td>
                        <td>{{ $logistic->standardUnit->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer page-break">
        <table id="foot">
            <tr>
                <td>
                    <p>Denpasar,
                        @php
                            $date = Carbon\Carbon::now()->locale('id');
                            $date->settings(['formatFunction' => 'translatedFormat']);
                            echo $date->format('d F Y');
                        @endphp
                    </p>
                    <p>
                        {{ Auth::user()->level->name }}
                        @if (Auth::user()->level_id == '1')
                            Kedaruratan dan Logistik
                        @else
                            Logistik dan Peralatan
                        @endif
                    </p>
                    <p>BPBD Provinsi Bali</p>
                    <p></p>
                    <p></p>
                    <p></p>
                    <p></p>
                    <p></p>
                    <strong><u>{{ Auth::user()->name }}</u></strong>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
