@extends('/layouts/main')

@section('body')
    <div class="h1 fw-bold">Penyuplai</div>
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
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Tambah Penyuplai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/data-master/penyuplai" method="post">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="addName" class="form-label">Penyuplai</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="addName" name="name">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="addAddress" class="form-label">Alamat</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="addAddress" name="address">
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="addContactPerson" class="form-label">Narahubung</label>
                                    <input type="text" class="form-control @error('contactPerson') is-invalid @enderror"
                                        id="addContactPerson" name="contactPerson">
                                    @error('contactPerson')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="addTelephone" class="form-label">Telepon</label>
                                    <input type="tel" class="form-control @error('telephone') is-invalid @enderror"
                                        id="addTelephone" name="telephone">
                                    @error('telephone')
                                        <div class="invalid-feedback">
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
            <table id="tb-penyuplai" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Penyuplai</th>
                        <th>Alamat</th>
                        <th>Narahubung</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $supplier)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->address }}</td>
                            <td>{{ $supplier->contactPerson }}</td>
                            <td>{{ $supplier->telephone }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    {{-- Edit --}}
                                    <a class="btn btn-sm btn-warning text-light me-1" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $supplier->id }}">Edit</a>
                                    <div class="modal fade" id="modalEdit{{ $supplier->id }}" tabindex="-1"
                                        aria-labelledby="detailLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold" id="detailLabel">Edit Penyuplai</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/data-master/penyuplai/{{ $supplier->id }}"
                                                        method="post">
                                                        @method('put')
                                                        @csrf
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <label for="editName{{ $supplier->id }}"
                                                                    class="form-label">Penyuplai</label>
                                                                <input type="text"
                                                                    class="form-control @error('name', "edit$supplier->id") is-invalid @enderror"
                                                                    id="editName{{ $supplier->id }}"
                                                                    value="{{ $supplier->name }}" name="name">
                                                                @error('name', "edit$supplier->id")
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="col">
                                                                <label for="editAddress{{ $supplier->address }}"
                                                                    class="form-label">Alamat</label>
                                                                <input type="text"
                                                                    class="form-control @error('address', "edit$supplier->id") is-invalid @enderror"
                                                                    id="editAddress{{ $supplier->address }}"
                                                                    value="{{ $supplier->address }}" name="address">
                                                                @error('address', "edit$supplier->id")
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <label
                                                                    for="editContactPerson{{ $supplier->contactPerson }}"
                                                                    class="form-label">Narahubung</label>
                                                                <input type="text"
                                                                    class="form-control @error('contactPerson', "edit$supplier->id") is-invalid @enderror"
                                                                    id="editContactPerson{{ $supplier->contactPerson }}"
                                                                    value="{{ $supplier->contactPerson }}"
                                                                    name="contactPerson">
                                                                @error('contactPerson', "edit$supplier->id")
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="col">
                                                                <label for="editTelephone{{ $supplier->id }}"
                                                                    class="form-label">Telepon</label>
                                                                <input type="tel"
                                                                    class="form-control @error('telephone', "edit$supplier->id") is-invalid @enderror"
                                                                    id="editTelephone{{ $supplier->id }}"
                                                                    value="{{ $supplier->telephone }}" name="telephone">
                                                                @error('telephone', "edit$supplier->id")
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
                                    {{-- <form action="/data-master/penyuplai/{{ $supplier->id }}" method="post"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin untuk menghapus data {{ $supplier->name }}?')">
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
