@extends('/layouts/main')

@section('body')
    <div class="h1 fw-bold">Logistik Keluar</div>
    <div class="container-fluid rounded p-3 bg-white mb-3">
        <form action="/transaksi/logistik-keluar/sort">
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
        <form action="/transaksi/logistik-keluar/reset" method="post">
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
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Tambah Logistik Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/transaksi/logistik-keluar" method="post" id="show">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="outboundDate" class="form-label">Tanggal Keluar</label>
                                <input type="text"
                                    class="form-control date-picker @error('outboundDate') is-invalid @enderror"
                                    id="outboundDate" name="outboundDate" value="{{ now()->toDateString() }}">
                                @error('outboundDate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @livewire('dropdown')
                        </div>
                        <label for="tb_logistikMasukModal" class="form-label">Logistik</label>
                        <div class="container-fluid border p-3 mb-3">
                            <div class="table-responsive p-0 pt-3 pb-3">
                                <table id="tb-modLogMasuk" class="table table-bordered table-sm" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Logistik</th>
                                            <th>Penyuplai</th>
                                            <th>Stok</th>
                                            <th>Satuan</th>
                                            <th>Kedaluwarsa</th>
                                            <th>Jenis Pengadaan</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inboundLogistics as $inboundLogistic)
                                            @if ($inboundLogistic->expiredDate >= now() || $inboundLogistic->expiredDate == null)
                                                @if ($inboundLogistic->expiredDate == null)
                                                    <tr class="table-success">
                                                        <td>
                                                            <input class="form-check-input" type="checkbox"
                                                                id="flexCheckDefault" name="inboundLogistic_id[]"
                                                                value="{{ $inboundLogistic->id }}">
                                                        </td>
                                                        <td>{{ $inboundLogistic->logistic->name }}</td>
                                                        <td>
                                                            {{ $inboundLogistic->supplier->name ?? $inboundLogistic->supplier }}
                                                        </td>
                                                        <td class="text-right">{{ $inboundLogistic->stock }}</td>
                                                        <td>{{ $inboundLogistic->logistic->standardUnit->name }}</td>
                                                        <td>
                                                            {{ $inboundLogistic->expiredDate }}
                                                            <span class="badge bg-danger ms-auto invisible">hijau</span>
                                                        </td>
                                                        <td>
                                                            {{ $inboundLogistic->logisticProcurement->name ?? $inboundLogistic->logisticProcurement }}
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="quantity[]"
                                                                disabled>
                                                        </td>
                                                    </tr>
                                                @elseif ($inboundLogistic->expiredDate >= now()->day(30))
                                                    <tr class="table-success">
                                                        <td>
                                                            <input class="form-check-input" type="checkbox"
                                                                id="flexCheckDefault" name="inboundLogistic_id[]"
                                                                value="{{ $inboundLogistic->id }}">
                                                        </td>
                                                        <td>{{ $inboundLogistic->logistic->name }}</td>
                                                        <td>
                                                            {{ $inboundLogistic->supplier->name ?? $inboundLogistic->supplier }}
                                                        </td>
                                                        <td class="text-right">{{ $inboundLogistic->stock }}</td>
                                                        <td>{{ $inboundLogistic->logistic->standardUnit->name }}</td>
                                                        <td>
                                                            {{ $inboundLogistic->expiredDate }}
                                                            <span class="badge bg-danger ms-auto invisible">hijau</span>
                                                        </td>
                                                        <td>
                                                            {{ $inboundLogistic->logisticProcurement->name ?? $inboundLogistic->logisticProcurement }}
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="quantity[]"
                                                                disabled>
                                                        </td>
                                                    </tr>
                                                @elseif ($inboundLogistic->expiredDate < now()->day(30))
                                                    <tr class="table-warning">
                                                        <td>
                                                            <input class="form-check-input" type="checkbox"
                                                                id="flexCheckDefault" name="inboundLogistic_id[]"
                                                                value="{{ $inboundLogistic->id }}">
                                                        </td>
                                                        <td>{{ $inboundLogistic->logistic->name }}</td>
                                                        <td>
                                                            {{ $inboundLogistic->supplier->name ?? $inboundLogistic->supplier }}
                                                        </td>
                                                        <td class="text-right">{{ $inboundLogistic->stock }}</td>
                                                        <td>{{ $inboundLogistic->logistic->standardUnit->name }}</td>
                                                        <td>
                                                            {{ $inboundLogistic->expiredDate }}
                                                            <span class="badge bg-danger ms-auto invisible">kuning</span>
                                                        </td>
                                                        <td>
                                                            {{ $inboundLogistic->logisticProcurement->name ?? $inboundLogistic->logisticProcurement }}
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="quantity[]"
                                                                disabled>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
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
        <table id="tb-logistikKeluar" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Keluar</th>
                    <th>Logistik</th>
                    <th>Penyuplai</th>
                    <th>Unit Penerima</th>
                    <th>Penerima</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($outboundLogistics as $outboundLogistic)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $outboundLogistic->outboundDate }}</td>
                        <td>{{ $outboundLogistic->inboundLogistic->logistic->name }}</td>
                        <td>
                            {{ $outboundLogistic->inboundLogistic->supplier->name ?? $outboundLogistic->inboundLogistic->supplier }}
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
                        <td>
                            <div class="d-flex justify-content-center">
                                <form action="/transaksi/logistik-keluar/{{ $outboundLogistic->id }}" method="post"
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
@endsection
