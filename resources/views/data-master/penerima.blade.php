@extends('/layouts/main')

@section('body')
    <div class="h1 fw-bold">
        Penerima</div>
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
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Tambah Penerima</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="/data-master/penerima">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="addName" class="form-label">Nama Penerima</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="addName" name="name">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="addPhone" class="form-label">Telepon</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="addPhone" name="phone">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="addReceiverUnit" class="form-label">Unit Penerima</label>
                                    <select class="form-select @error('receiverUnit_id') is-invalid @enderror"
                                        id="addReceiverUnit" name="receiverUnit_id">
                                        <option selected disabled>Pilih Unit Penerima</option>
                                        @foreach ($receiverUnits as $receiverUnit)
                                            <option value="{{ $receiverUnit->id }}">
                                                {{ $receiverUnit->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('receiverUnit_id')
                                        <div class="invalid-feedback">
                                            {{ $message = 'The receiver unit field is required. ' }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="addDescription"
                                        class="form-label @error('description') is-invalid @enderror">Keterangan</label>
                                    <textarea class="form-control" id="addDescription" name="description"></textarea>
                                    @error('description')
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
            <table id="tb-penerima" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Penerima</th>
                        <th>Telepon</th>
                        <th>Unit Penerima</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receivers as $receiver)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $receiver->name }}</td>
                            <td>{{ $receiver->phone }}</td>
                            <td>{{ $receiver->receiverUnit->name ?? $receiver->receiverUnit }}</td>
                            <td>{{ $receiver->description }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    {{-- Edit --}}
                                    <a class="btn btn-sm btn-warning text-light me-1" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $receiver->id }}">Edit</a>
                                    <div class="modal fade" id="modalEdit{{ $receiver->id }}" tabindex="-1"
                                        aria-labelledby="detailLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold" id="detailLabel">Edit Penerima</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/data-master/penerima/{{ $receiver->id }}"
                                                        method="post">
                                                        @method('put')
                                                        @csrf
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <label for="editName{{ $receiver->id }}"
                                                                    class="form-label">Nama
                                                                    Penerima</label>
                                                                <input type="text"
                                                                    class="form-control @error('name', "edit$receiver->id") is-invalid @enderror"
                                                                    id="editName{{ $receiver->id }}" name="name"
                                                                    value="{{ $receiver->name }}">
                                                                @error('name', "edit$receiver->id")
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="col">
                                                                <label for="editPhone{{ $receiver->id }}"
                                                                    class="form-label">Telepon</label>
                                                                <input type="tel"
                                                                    class="form-control @error('phone', "edit$receiver->id") is-invalid @enderror"
                                                                    id="editPhone{{ $receiver->id }}" name="phone"
                                                                    value="{{ $receiver->phone }}">
                                                                @error('phone', "edit$receiver->id")
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="editReceiverUnit{{ $receiver->id }}"
                                                                    class="form-label">Unit
                                                                    Penerima</label>
                                                                <select class="form-select"
                                                                    id="editReceiverUnit{{ $receiver->id }}"
                                                                    name="receiverUnit_id">
                                                                    @foreach ($receiverUnits as $receiverUnit)
                                                                        @if ($receiverUnit->id == $receiver->receiverUnit->id)
                                                                            <option value='{{ $receiverUnit->id }}'
                                                                                selected>
                                                                                {{ $receiverUnit->name }}
                                                                            </option>
                                                                        @else
                                                                            <option value='{{ $receiverUnit->id }}'>
                                                                                {{ $receiverUnit->name }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col">
                                                                <label for="editDescription{{ $receiver->id }}"
                                                                    class="form-label">Keterangan</label>
                                                                <textarea class="form-control @error('description', "edit$receiver->id") is-invalid @enderror"
                                                                    id="editDescription{{ $receiver->id }}" name="description">{{ $receiver->description }}</textarea>
                                                                @error('description', "edit$receiver->id")
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
                                    {{-- <form action="/data-master/penerima/{{ $receiver->id }}" method="post"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin untuk menghapus data {{ $receiver->name }}?')">
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
