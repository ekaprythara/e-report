@extends('/layouts/main')

@section('body')
    <div class="h1 fw-bold">Logistik Masuk</div>
    <div class="container-fluid rounded p-3 bg-white mb-3">
        <form action="/transaksi/logistik-masuk/sort">
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
        <form action="/transaksi/logistik-masuk/reset" method="post">
            @csrf
            <button type="submit" class="btn btn-primary bi bi-arrow-clockwise"></button>
        </form>

    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Tambah
    </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Tambah Logistik Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/transaksi/logistik-masuk" method="post" id="show">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="inboundDate" class="form-label">Tanggal Masuk</label>
                                <input type="text"
                                    class="form-control date-picker @error('inboundDate') is-invalid @enderror"
                                    id="inboundDate" name="inboundDate" value="{{ now()->toDateString() }}">
                                @error('inboundDate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="logMasukPenyuplai" class="form-label">Penyuplai</label>
                                <select class="form-select @error('supplier_id') is-invalid @enderror"
                                    id="logMasukPenyuplai" name="supplier_id">
                                    <option selected disabled>Pilih Penyuplai</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <div class="invalid-feedback">
                                        {{ $message = 'The supplier field is required. ' }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="logMasukJenisPengadaan" class="form-label">Jenis Pengadaan</label>
                                <select class="form-select @error('logisticProcurement_id') is-invalid @enderror"
                                    id="logMasukJenisPengadaan" name="logisticProcurement_id">
                                    <option selected disabled>Pilih Jenis Pengadaan</option>
                                    @foreach ($logisticProcurements as $logisticProcurement)
                                        <option value="{{ $logisticProcurement->id }}">
                                            {{ $logisticProcurement->name }}</option>
                                    @endforeach
                                </select>
                                @error('logisticProcurement_id')
                                    <div class="invalid-feedback">
                                        {{ $message = ' The logistic procurement field is required. ' }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <label for="tb_logistikMasukModal" class="form-label">Logistik</label>
                        <div class="container-fluid border p-3 mb-3">
                            <div class="table-responsive p-0 pt-3 pb-3">
                                <table id="tb-modLogMasuk" class="table table-bordered table-striped table-sm"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Logistik</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Kedaluwarsa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logistics as $logistic)
                                            <tr>
                                                <td>
                                                    <input class="form-check-input" type="checkbox" name="logistic_id[]"
                                                        value="{{ $logistic->id }}">
                                                </td>
                                                <td>{{ $logistic->name }}</td>
                                                <td>
                                                    <input type="text" class="form-control" name="amount[]" disabled>
                                                </td>
                                                <td>{{ $logistic->standardUnit->name }}</td>
                                                <td>
                                                    @if ($logistic->logisticType->expiredDate == 0)
                                                        <input type="hidden" name="expiredDate[]" value="" disabled>
                                                    @elseif ($logistic->logisticType->expiredDate == 1)
                                                        <input type="text" class="form-control date-picker"
                                                            name="expiredDate[]" disabled>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('create'))
        <div class="alert alert-success" id="success-alert" role="alert">
            {{ session('create') }}
        </div>
    @elseif (session()->has('update'))
        <div class="alert alert-warning" id="warning-alert" role="alert">
            {{ session('update') }}
        </div>
    @elseif (session()->has('delete'))
        <div class="alert alert-danger" id="danger-alert" role="alert">
            {{ session('delete') }}
        </div>
    @endif

    <!-- Table -->
    <div class="table-responsive p-0 pt-3 pb-3">
        <table id="tb-logistikMasuk" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Masuk</th>
                    <th>Logistik</th>
                    <th>Penyuplai</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Kedaluwarsa</th>
                    <th>Jenis Pengadaan</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
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
                        <td class="text-right">{{ $inboundLogistic->amount }}</td>
                        <td>{{ $inboundLogistic->logistic->standardUnit->name }}</td>
                        <td>{{ $inboundLogistic->expiredDate }}</td>
                        <td>
                            {{ $inboundLogistic->logisticProcurement->name ?? $inboundLogistic->logisticProcurement }}
                        </td>
                        <td>{{ $inboundLogistic->description }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <form action="/transaksi/logistik-masuk/{{ $inboundLogistic->id }}" method="post"
                                    class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin untuk menghapus data ini?')">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tb-modLogMasuk').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: "{{ route('logistik-masuk') }}",
                columns: [{
                        data: 'id',
                        name: 'id',
                    }, {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'standardUnit_id',
                        name: 'standardUnit_id'
                    },
                    {
                        data: 'expiredDate',
                        name: 'expiredDate'
                    },
                ],
            });
        });
    </script> --}}
@endsection
