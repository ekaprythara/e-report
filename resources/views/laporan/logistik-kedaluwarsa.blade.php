@extends('/layouts/main')

@section('body')
    <div class="h1 fw-bold">Laporan Logistik Kedaluwarsa</div>
    <div class="container-fluid rounded p-3 bg-white mb-3">
        <div class="d-flex justify-content-end align-items-center mb-2">
            <button type="button" class="btn btn-success dropdown-toggle me-2" data-bs-toggle="dropdown" aria-expanded="false">
                Ekspor
            </button>
            <ul class="dropdown-menu">
                <li><a href="/laporan/logistik-kedaluwarsa/ekspor/ods" class="dropdown-item">ODS</a></li>
                <li><a href="/laporan/logistik-kedaluwarsa/ekspor/pdf" class="dropdown-item">PDF</a></li>
                <li><a href="/laporan/logistik-kedaluwarsa/ekspor/xls" class="dropdown-item">XLS</a></li>
                <li><a href="/laporan/logistik-kedaluwarsa/ekspor/xlsx" class="dropdown-item">XLSX</a></li>
            </ul>
            <a href="/laporan/logistik-kedaluwarsa/print" type="button" class="btn btn-success">Cetak</a>
        </div>

        <div class="table-responsive p-0 pt-3 pb-3">
            <table id="tb-stokLogistik" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Logistik</th>
                        <th>Penyuplai</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Kedaluwarsa</th>
                        <th>Jenis Pengadaan</th>
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
                            <td class="text-right">{{ $inboundLogistic->stock }}</td>
                            <td>{{ $inboundLogistic->logistic->standardUnit->name }}</td>
                            <td>{{ $inboundLogistic->expiredDate }}</td>
                            <td>
                                {{ $inboundLogistic->logisticProcurement->name ?? $inboundLogistic->logisticProcurement }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
