@extends('/layouts/main')

@section('body')
    <div class="h1 fw-bold">Laporan Logistik Keluar</div>
    <div class="container-fluid rounded p-3 bg-white mb-3">
        <form action="/laporan/logistik-keluar/sort">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="d-flex align-items-start d-inline me-auto col-5">
                    <div class="input-group me-2">
                        <span class="input-group-text" id="mulai">Mulai</span>
                        <input type="text" class="form-control date-picker @error('from') is-invalid @enderror"
                            name="from" value="{{ request('from') ?? now()->toDateString() }}" aria-describedby="mulai">
                        @error('from')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-group me-2">
                        <span class="input-group-text" id="sampai">Sampai</span>
                        <input type="text" class="form-control date-picker @error('to') is-invalid @enderror"
                            name="to" value="{{ request('to') ?? now()->toDateString() }}" aria-describedby="sampai">
                        @error('to')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary me-2">
                        Cari
                    </button>
        </form>
        <form action="/laporan/logistik-keluar/reset" method="post">
            @csrf
            <button type="submit" class="btn btn-primary bi bi-arrow-clockwise"></button>
        </form>
    </div>
    <div class="d-flex d-inline justify-content-end mb-2">

        <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#export">
            Ekspor
        </button>
        <div class="modal fade" id="export" tabindex="-1" aria-labelledby="exportLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="exportLabel">Ekspor Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/laporan/logistik-keluar/ekspor">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="exportFrom" class="form-label">Mulai</label>
                                    <input type="text" class="form-control date-picker" id="exportFrom" name="from"
                                        value="{{ now()->toDateString() }}">
                                </div>
                                <div class="col">
                                    <label for="exportTo" class="form-label">Sampai</label>
                                    <input type="text" class="form-control date-picker" id="exportTo" name="to"
                                        value="{{ now()->toDateString() }}">
                                </div>
                            </div>
                            <label for="format" class="form-label">Format</label>
                            <select class="form-select" id="format" name="format">
                                <option value="ods">ODS</option>
                                <option value="pdf">PDF</option>
                                <option value="xls">XLS</option>
                                <option value="xlsx">XLSX</option>
                            </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Ekspor</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Cetak
        </button>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Cetak Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/laporan/logistik-keluar/print">
                            <div class="row">
                                <div class="col">
                                    <label for="printFrom" class="form-label">Mulai</label>
                                    <input type="text" class="form-control date-picker" id="printFrom" name="from"
                                        value="{{ now()->toDateString() }}">
                                </div>
                                <div class="col">
                                    <label for="printTo" class="form-label">Sampai</label>
                                    <input type="text" class="form-control date-picker" id="printTo" name="to"
                                        value="{{ now()->toDateString() }}">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Cetak</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="table-responsive p-0 pt-3 pb-3">
        <table id="tb-logKeluar" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Keluar</th>
                    <th>Logistik</th>
                    <th>Penyuplai</th>
                    <th>Unit Penerima</th>
                    <th>Penerima</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($outboundLogistics as $outboundLogistic)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $outboundLogistic->outboundDate }}</td>
                        <td>{{ $outboundLogistic->inboundLogistic->logistic->name }}</td>
                        <td>{{ $outboundLogistic->inboundLogistic->supplier->name ?? $outboundLogistic->inboundLogistic->supplier }}
                        </td>
                        <td>
                            {{ $outboundLogistic->receiver->receiverUnit->name ?? '' }}
                        </td>
                        <td>
                            @if (isset($outboundLogistic->receiver->receiverUnit->name))
                                {{ $outboundLogistic->receiver->name }}
                            @endif
                        </td>
                        <td class="text-right">{{ $outboundLogistic->quantity }}</td>
                        <td>{{ $outboundLogistic->inboundLogistic->logistic->standardUnit->name }}</td>
                        <td>{{ $outboundLogistic->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endsection
