@extends('/layouts/main')

@section('body')
    <div class="h1 fw-bold">Pengguna</div>
    <div class="container-fluid rounded p-3 bg-white mb-3">
        <div class="d-flex justify-content-end align items center mb-2 px-3">
            @can('kasubid')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Tambah
                </button>
            </div>

            {{-- Tambah --}}
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="exampleModalLabel">Tambah Pengguna</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/data-master/pengguna" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="addUsername" class="form-label">Nama Pengguna</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            id="addUsername" name="username">
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="addName" class="form-label">Nama Lengkap</label>
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
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="addEmail" class="form-label">Surel</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="addEmail" name="email">
                                        @error('email')
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
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="addPassword" class="form-label">Kata Sandi</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="addPassword" name="password">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <label for="addPasswordConfirmation" class="form-label">Konfirmasi Kata
                                            Sandi</label>
                                        <input type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            id="addPasswordConfirmation" name="password_confirmation">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="addImage" class="form-label">Unggah Foto Profil</label>
                                        <img class="img-preview-add mb-2 col-sm-3">
                                        <input class="form-control @error('image') is-invalid @enderror" type="file"
                                            id="addImage" name="image" onchange="previewImageAddUser()">
                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <label for="addLevel" class="form-label">Level</label>
                                <select class="form-select" id="addLevel" name="level_id" disabled>
                                    <option selected>Pegawai</option>
                                </select>
                                <input type="hidden" name="level_id" value="3">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                        </form>
                    </div>
                </div>
            @endcan
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

        <div class="table-responsive p-0 pt-3 pb-3">
            <table id="tb-pengguna" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Pengguna</th>
                        <th>Nama Lengkap</th>
                        <th>Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($user->image == null)
                                    <img src="{{ asset('/img/default.png') }}"
                                        style="height: 100px; width: 100px; border-radius: 5px;">
                                @else
                                    <img src="{{ asset('storage/' . $user->image) }}"
                                        style="height: 100px; width: 100px; border-radius: 5px;">
                                @endif
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->level->name }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    {{-- Info --}}
                                    <a class="btn btn-sm btn-primary text-light me-1 mb-2" data-bs-toggle="modal"
                                        data-bs-target="#modalInfo{{ $user->id }}">Info</a>
                                    <div class="modal fade" id="modalInfo{{ $user->id }}" tabindex="-1"
                                        aria-labelledby="detailLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Info Pengguna
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div
                                                        class="col d-flex flex-column justify-content-center align-items-center">
                                                        @if ($user->image == null)
                                                            <img src="{{ asset('/img/default.png') }}" width="180"
                                                                height="180"
                                                                class="rounded-circle me-2 mb-3 profile-bg-light">
                                                        @else
                                                            <img src="{{ asset('storage/' . $user->image) }}"
                                                                width="180" height="180"
                                                                class="rounded-circle me-2 mb-3 profile-bg-light">
                                                        @endif
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <label for="infoUsername" class="form-label">Nama
                                                                Pengguna</label>
                                                            <input type="text" class="form-control" id="infoUsername"
                                                                name="username" value="{{ $user->username }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <label for="infoName" class="form-label">Nama
                                                                Lengkap</label>
                                                            <input type="text" class="form-control" id="infoName"
                                                                name="name" value="{{ $user->name }}" disabled>
                                                        </div>
                                                        <div class="col">
                                                            <label for="infoAddress" class="form-label">Alamat</label>
                                                            <input type="text" class="form-control" id="infoAddress"
                                                                name="address" value="{{ $user->address }}" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <label for="infoEmail" class="form-label">Surel</label>
                                                            <input type="email" class="form-control" id="infoEmail"
                                                                name="email" value="{{ $user->email }}" disabled>
                                                        </div>
                                                        <div class="col">
                                                            <label for="infoPhone" class="form-label">Telepon</label>
                                                            <input type="tel" class="form-control" id="infoPhone"
                                                                name="phone" value="{{ $user->phone }}" disabled>
                                                        </div>
                                                    </div>
                                                    <label for="infoLevel" class="form-label">Level</label>
                                                    <select class="form-select" id="infoLevel" name="level_id" disabled>
                                                        <option selected>{{ $user->level->name }}</option>
                                                    </select>
                                                </div>
                                                <div class="modal-footer d-flex flex-row-reverse justify-content-between">
                                                    <div>
                                                        <button type="button" class="btn btn-secondary me-1"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Edit --}}
                                    @if (Auth::user()->id == $user->id)
                                        <a class="btn btn-sm btn-warning text-light me-1 mb-2" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $user->id }}">Edit</a>
                                        <div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1"
                                            aria-labelledby="detailLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Edit
                                                            Pengguna</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="/data-master/pengguna/{{ $user->id }}"
                                                            method="post" enctype="multipart/form-data">
                                                            @method('put')
                                                            @csrf
                                                            <div class="row mb-3">
                                                                <div class="col">
                                                                    <label for="editUsername" class="form-label">Nama
                                                                        Pengguna</label>
                                                                    <input type="text"
                                                                        class="form-control @error('username', "edit$user->id") is-invalid @enderror"
                                                                        id="editUsername" name="username"
                                                                        value="{{ $user->username }}">
                                                                    @error('username', "edit$user->id")
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col">
                                                                    <label for="editName"
                                                                        class="form-label @error('name', "edit$user->id") is-invalid @enderror">Nama
                                                                        Lengkap</label>
                                                                    <input type="text" class="form-control"
                                                                        id="editName" name="name"
                                                                        value="{{ $user->name }}">
                                                                    @error('name', "edit$user->id")
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col">
                                                                    <label for="editAddress"
                                                                        class="form-label">Alamat</label>
                                                                    <input type="text"
                                                                        class="form-control @error('address', "edit$user->id") is-invalid @enderror"
                                                                        id="editAddress" name="address"
                                                                        value="{{ $user->address }}">
                                                                    @error('address', "edit$user->id")
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col">
                                                                    <label for="editEmail"
                                                                        class="form-label">Surel</label>
                                                                    <input type="email"
                                                                        class="form-control @error('email', "edit$user->id") is-invalid @enderror"
                                                                        id="editEmail" name="email"
                                                                        value="{{ $user->email }}">
                                                                    @error('email', "edit$user->id")
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                                <div class="col">
                                                                    <label for="editPhone"
                                                                        class="form-label">Telepon</label>
                                                                    <input type="tel"
                                                                        class="form-control @error('phone', "edit$user->id") is-invalid @enderror"
                                                                        id="editPhone" name="phone"
                                                                        value="{{ $user->phone }}">
                                                                    @error('phone', "edit$user->id")
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3">
                                                                    <label for="editImage" class="form-label">Unggah Foto
                                                                        Profil</label>
                                                                    <input type="hidden" name="oldImage"
                                                                        value="{{ $user->image }}">
                                                                    @if ($user->image)
                                                                        <img src="{{ asset('storage/' . $user->image) }}"
                                                                            class="img-preview-edit mb-2 col-sm-3 d-block">
                                                                    @else
                                                                        <img class="img-preview-edit mb-2 col-sm-3">
                                                                    @endif
                                                                    <input
                                                                        class="form-control
                                                                    @error('image', "edit$user->id") is-invalid @enderror"
                                                                        type="file" id="editImage" name="image"
                                                                        onchange="previewImageEditUser()">
                                                                    @error('image', "edit$user->id")
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <label for="editLevel" class="form-label">Level</label>
                                                            <select class="form-select" id="editLevel" name="level_id"
                                                                disabled>
                                                                <option selected>{{ $user->level->name }}</option>
                                                            </select>
                                                    </div>
                                                    <div
                                                        class="modal-footer d-flex flex-row-reverse justify-content-between">
                                                        <div>
                                                            <button type="button" class="btn btn-secondary me-1"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                            </form>
                                                        </div>
                                                        <div>
                                                            @if ($user->image)
                                                                <form method="post"
                                                                    action="/data-master/pengguna/edit-foto/{{ $user->id }}"
                                                                    class="d-inline"
                                                                    onsubmit="return confirm('Apakah Anda yakin untuk menghapus foto?')">
                                                                    @method('put')
                                                                    @csrf
                                                                    <input type="hidden" name="image" value="">
                                                                    <input type="hidden" name="oldImage"
                                                                        value="{{ $user->image }}">
                                                                    <button type="submit" class="btn btn-danger">
                                                                        Hapus Foto
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="btn btn-sm btn-success text-light me-1 mb-2" data-bs-toggle="modal"
                                            data-bs-target="#modalChangePassword{{ $user->id }}"><i
                                                class="bi bi-lock-fill"></i></a>
                                        <div class="modal fade" id="modalChangePassword{{ $user->id }}"
                                            tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Edit Kata
                                                            Sandi
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="/data-master/pengguna/edit-password/{{ $user->id }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="row mb-3">
                                                                <div class="col">
                                                                    <label for="editCurrentPassword"
                                                                        class="form-label">Current Password</label>
                                                                    <input type="password"
                                                                        class="form-control @error('current_password') is-invalid @enderror"
                                                                        id="editCurrentPassword" name="current_password">
                                                                    @error('current_password')
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col">
                                                                    <label for="editNewPassword" class="form-label">New
                                                                        Password</label>
                                                                    <input type="password"
                                                                        class="form-control @error('new_password') is-invalid @enderror"
                                                                        id="editNewPassword" name="new_password">
                                                                    @error('new_password')
                                                                        <div class="invalid-feedback">
                                                                            {{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <label for="editNewPasswordConfirmation"
                                                                        class="form-label">Confirm New Password</label>
                                                                    <input type="password"
                                                                        class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                                                        id="editNewPasswordConfirmation"
                                                                        name="new_password_confirmation">
                                                                    @error('new_password_confirmation')
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
                                    @endif
                                    {{-- Hapus --}}
                                    @if (Auth::user()->level_id == '2')
                                        @if ($user->level_id == '3')
                                            <form action="/data-master/pengguna/{{ $user->id }}" method="post"
                                                class="d-inline"
                                                onsubmit="return confirm('Apakah Anda yakin untuk menghapus data {{ $user->name }}?')">
                                                @method('delete')
                                                @csrf
                                                <input type="hidden" name="oldImage" value="{{ $user->image }}">
                                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
