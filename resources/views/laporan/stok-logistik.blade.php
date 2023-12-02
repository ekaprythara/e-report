@extends('/layouts/main')

@section('body')
    <div class="h1 fw-bold">Stok Logistik</div>
    <div class="container-fluid rounded p-3 bg-white mb-3">

        <div class="d-flex justify-content-end align-items-start mb-2">
            <button type="button" class="btn btn-success dropdown-toggle me-2" data-bs-toggle="dropdown" aria-expanded="false">
                Ekspor
            </button>
            <ul class="dropdown-menu">
                <li><a href="/laporan/stok-logistik/ekspor/ods" class="dropdown-item">ODS</a></li>
                <li><a href="/laporan/stok-logistik/ekspor/pdf" class="dropdown-item">PDF</a></li>
                <li><a href="/laporan/stok-logistik/ekspor/xls" class="dropdown-item">XLS</a></li>
                <li><a href="/laporan/stok-logistik/ekspor/xlsx" class="dropdown-item">XLSX</a></li>
            </ul>
            <a href="/laporan/stok-logistik/print" type="button" class="btn btn-success">Cetak</a>
        </div>

        <div class="table-responsive p-0 pt-3 pb-3">
            <table id="tb-stokLogistik" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Logistik</th>
                        <th>Jenis Logistik</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logistics as $logistic)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $logistic->name }}</td>
                            <td>{{ $logistic->logisticType->name }}</td>
                            <td class="text-right">{{ $logistic->stock }}</td>
                            <td>{{ $logistic->standardUnit->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
