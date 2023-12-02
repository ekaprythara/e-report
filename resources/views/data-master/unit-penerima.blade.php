@extends('/layouts/main')

@section('body')
    <div class="h1 fw-bold">Unit Penerima</div>
    <div class="container-fluid rounded p-3 bg-white mb-3">
        <div class="d-flex justify-content-end align items center mb-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah
            </button>
        </div>

        {{-- Tambah --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Tambah Unit Penerima</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/data-master/unit-penerima">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="addReceiverUnit" class="form-label">Unit Penerima</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="addReceiverUnit" name="name">
                                    @error('name')
                                        <div class=" invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="addAddress" class="form-label">Alamat</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="addAddress" name="address">
                                    @error('address')
                                        <div class=" invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="addEmail" class="form-label">Surel</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="addEmail" name="email">
                                    @error('email')
                                        <div class=" invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="addTelephone" class="form-label">Telepon</label>
                                    <input type="text" class="form-control @error('telephone') is-invalid @enderror"
                                        id="addTelephone" name="telephone">
                                    @error('telephone')
                                        <div class=" invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
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

        {{-- Peringatan --}}
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
            <table id="tb-unitPenerima" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Unit Penerima</th>
                        <th>Alamat</th>
                        <th>Surel</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receiverUnits as $receiverUnit)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $receiverUnit->name }}</td>
                            <td>{{ $receiverUnit->address }}</td>
                            <td>{{ $receiverUnit->email }}</td>
                            <td>{{ $receiverUnit->telephone }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    {{-- Edit --}}
                                    <a class="btn btn-sm btn-warning text-light me-1" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $receiverUnit->id }}">Edit</a>
                                    <div class="modal fade" id="modalEdit{{ $receiverUnit->id }}" tabindex="-1"
                                        aria-labelledby="detailLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold" id="detailLabel">Edit Unit Penerima</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post"
                                                        action="/data-master/unit-penerima/{{ $receiverUnit->id }}">
                                                        @method('put')
                                                        @csrf
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <label for="editName{{ $receiverUnit->id }}"
                                                                    class="form-label">Unit
                                                                    Penerima</label>
                                                                <input type="text"
                                                                    class="form-control @error('name', "edit$receiverUnit->id") is-invalid @enderror"
                                                                    id="editName{{ $receiverUnit->id }}" name="name"
                                                                    value="{{ $receiverUnit->name }}">
                                                                @error('name', "edit$receiverUnit->id")
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="col">
                                                                <label for="editAddress{{ $receiverUnit->id }}"
                                                                    class="form-label">Alamat</label>
                                                                <input type="text"
                                                                    class="form-control @error('address', "edit$receiverUnit->id") is-invalid @enderror"
                                                                    id="editAddress{{ $receiverUnit->id }}"
                                                                    name="address" value="{{ $receiverUnit->address }}">
                                                                @error('address', "edit$receiverUnit->id")
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="editEmail{{ $receiverUnit->id }}"
                                                                    class="form-label">Surel</label>
                                                                <input type="email"
                                                                    class="form-control @error('email', "edit$receiverUnit->id") is-invalid @enderror"
                                                                    id="editEmail{{ $receiverUnit->id }}" name="email"
                                                                    value="{{ $receiverUnit->email }}">
                                                                @error('email', "edit$receiverUnit->id")
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="col">
                                                                <label for="editTelephone{{ $receiverUnit->id }}"
                                                                    class="form-label">Telepon</label>
                                                                <input type="text"
                                                                    class="form-control @error('telephone', "edit$receiverUnit->id") is-invalid @enderror"
                                                                    id="editTelephone{{ $receiverUnit->id }}"
                                                                    name="telephone"
                                                                    value="{{ $receiverUnit->telephone }}">
                                                                @error('telephone', "edit$receiverUnit->id")
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
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
                                    {{-- <form action="/data-master/unit-penerima/{{ $receiverUnit->id }}" method="post"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin untuk menghapus data {{ $receiverUnit->name }}?')">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                    </form> --}}
                                    <div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
