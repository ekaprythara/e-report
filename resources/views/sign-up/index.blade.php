@extends('/layouts/sign-in')

@section('body')
    <div class="d-flex justify-content-center align-content-center">
        <div class="p-3 rounded bg-white">
            <h1 class="h3 mb-3 fw-normal">Registrasi</h1>
            <hr>
            @if (session()->has('create'))
                <div class="alert alert-success" id="success-alert" role="alert">
                    {{ session('create') }}
                </div>
            @endif
            <form action="/sign-up" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <label for="username" class="form-label">Nama Pengguna</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                            name="username" value="{{ old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="address" class="form-label">Alamat</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" value="{{ old('address') }}">
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="email" class="form-label">Surel</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="phone" class="form-label">Telepon</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation">
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <label for="image" class="form-label">Unggah Foto Profil</label>
                        <img class="img-preview mb-2 col-sm-3">
                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                            name="image" onchange="previewImage()">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <label for="level" class="form-label">Level</label>
                <select class="form-select @error('level_id') is-invalid @enderror" id="level" name="level_id">
                    <option selected disabled>Pilih Level</option>
                    @foreach ($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
                @error('level_id')
                    <div class="invalid-feedback">
                        {{ $message = 'The level field is required. ' }}
                    </div>
                @enderror
                <hr>
                <button class="w-100 btn btn-primary mb-3" type="submit">Registrasi</button>
                <small class="text-center d-block">Sudah terdaftar? <a href="/">Masuk</a></small>
            </form>
        </div>
    </div>
@endsection
