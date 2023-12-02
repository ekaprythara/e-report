@extends('/layouts/main')

@section('body')
    <div class="h1 fw-bold">Jenis Pengadaan</div>
    <div class="container-fluid rounded p-3 bg-white mb-3">
        <div class="d-flex justify-content-end align items center mb-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah
            </button>
        </div>

        {{-- Tambah --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Tambah Jenis Pengadaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/data-master/jenis-pengadaan">
                            @csrf
                            <label for="addName" class="form-label">Jenis Pengadaan</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="addName"
                                name="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                    </form>
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

        {{-- Tabel --}}
        <div class="table-responsive p-0 pt-3 pb-3">
            <table id="tb-jenisPengadaan" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Pengadaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logisticProcurements as $logisticProcurement)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $logisticProcurement->name }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    {{-- Edit --}}
                                    <a class="btn btn-sm btn-warning text-light me-1" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $logisticProcurement->id }}">Edit</a>
                                    <div class="modal fade" id="modalEdit{{ $logisticProcurement->id }}" tabindex="-1"
                                        aria-labelledby="detailLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold" id="detailLabel">Edit Jenis Pengadaan
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        action="/data-master/jenis-pengadaan/{{ $logisticProcurement->id }}"
                                                        method="post">
                                                        @method('put')
                                                        @csrf
                                                        <label for="editName{{ $logisticProcurement->id }}"
                                                            class="form-label">Jenis
                                                            Pengadaan</label>
                                                        <input type="text"
                                                            class="form-control @error('name', "edit$logisticProcurement->id") is-invalid @enderror"
                                                            id="editName{{ $logisticProcurement->id }}"
                                                            value="{{ $logisticProcurement->name }}" name="name">
                                                        @error('name', "edit$logisticProcurement->id")
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Hapus --}}
                                    {{-- <form action="/data-master/jenis-pengadaan/{{ $logisticProcurement->id }}"
                                        method="post" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda ingin menghapus data {{ $logisticProcurement->name }}?')">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
