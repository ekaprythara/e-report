@extends('/layouts/main')

@section('body')
    <div class="h1 fw-bold">Logistik</div>
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
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Tambah Logistik</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/data-master/logistik" method="post">
                            @csrf
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="addName" class="form-label">Logistik</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="addName" name="name">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="addLogisticType" class="form-label">Jenis Logistik</label>
                                    <select class="form-select @error('logisticType_id') is-invalid @enderror"
                                        id="addLogisticType" name="logisticType_id">
                                        <option selected disabled>Pilih Jenis Logistik</option>
                                        @foreach ($logisticTypes as $logisticType)
                                            <option value="{{ $logisticType->id }}">
                                                {{ $logisticType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('logisticType_id')
                                        <div class="invalid-feedback">
                                            {{ $message = 'The logistic type field is required.' }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="addStandardUnit" class="form-label">Satuan</label>
                                    <select class="form-select @error('standardUnit_id') is-invalid @enderror"
                                        id="addStandardUnit" name="standardUnit_id">
                                        <option selected disabled>Pilih Satuan</option>
                                        @foreach ($standardUnits as $standardUnit)
                                            <option value="{{ $standardUnit->id }}">
                                                {{ $standardUnit->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('standardUnit_id')
                                        <div class="invalid-feedback">
                                            {{ $message = 'The standard unit field is required. ' }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Hidden Input --}}
                            <input type="hidden" class="form-control" name="stock" value="0">
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
            <table id="tb-logistik" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Logistik</th>
                        <th>Jenis Logistik</th>
                        <th>Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logistics as $logistic)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $logistic->name }}</td>
                            <td>{{ $logistic->logisticType->name }}</td>
                            <td>{{ $logistic->standardUnit->name }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    {{-- Edit --}}
                                    <a class="btn btn-sm btn-warning text-light me-1" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $logistic->id }}">Edit</a>
                                    <div class="modal fade" id="modalEdit{{ $logistic->id }}" tabindex="-1"
                                        aria-labelledby="detailLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold" id="detailLabel">Edit Logistik</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/data-master/logistik/{{ $logistic->id }}"
                                                        method="post">
                                                        @method('put')
                                                        @csrf
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <label for="editName{{ $logistic->id }}"
                                                                    class="form-label">Logistik</label>
                                                                <input type="text"
                                                                    class="form-control @error('name', "edit$logistic->id") is-invalid @enderror"
                                                                    id="editName{{ $logistic->id }}"
                                                                    value="{{ $logistic->name }}" name="name">
                                                                @error('name', "edit$logistic->id")
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col">
                                                                <label for="editLogisticType{{ $logistic->id }}"
                                                                    class="form-label">Jenis
                                                                    Logistik</label>
                                                                <select
                                                                    class="form-select @error('logisticType_id', "edit$logistic->id") is-invalid @enderror"
                                                                    id="editLogisticType{{ $logistic->id }}"
                                                                    name="logisticType_id">
                                                                    @foreach ($logisticTypes as $logisticType)
                                                                        @if ($logisticType->id == $logistic->logisticType->id)
                                                                            <option value='{{ $logisticType->id }}'
                                                                                selected>
                                                                                {{ $logisticType->name }}
                                                                            </option>
                                                                        @else
                                                                            <option value='{{ $logisticType->id }}'>
                                                                                {{ $logisticType->name }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                @error('logisticType_id', "edit$logistic->id")
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="col">
                                                                <label for="editStandardUnit{{ $logistic->id }}"
                                                                    class="form-label">Satuan</label>
                                                                <select
                                                                    class="form-select @error('standardUnit_id', "edit$logistic->id") is-invalid @enderror"
                                                                    id="editStandardUnit{{ $logistic->id }}"
                                                                    name="standardUnit_id">
                                                                    @foreach ($standardUnits as $standardUnit)
                                                                        @if ($standardUnit->id == $logistic->standardUnit->id)
                                                                            <option value='{{ $standardUnit->id }}'
                                                                                selected>
                                                                                {{ $standardUnit->name }}
                                                                            </option>
                                                                        @else
                                                                            <option value='{{ $standardUnit->id }}'>
                                                                                {{ $standardUnit->name }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                                @error('standardUnit_id', "edit$logistic->id")
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
                                    {{-- <form action="/data-master/logistik/{{ $logistic->id }}" method="post"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin untuk menghapus data {{ $logistic->name }}?')">
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
