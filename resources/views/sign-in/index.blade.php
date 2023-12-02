@extends('/layouts/sign-in')

@section('body')
    <div class="d-flex justify-content-center align-content-center">
        <div class="col-lg-4 p-3 rounded bg-light">
            <div class="text-center">
                <img class="mb-4" src="/img/logo-bpbd-provinsi-bali.png" alt="" width="170" height="170">
            </div>
            <h1 class="h3 mb-3 fw-normal text-center">
                Sistem Informasi
                <br>
                E-Report Logistik
            </h1>
            <hr>
            @if (session()->has('invalid'))
                <div class="alert alert-danger" id="danger-alert" role="alert">
                    {{ session('invalid') }}
                </div>
            @endif
            <form action="/" method="post">
                @csrf
                <div class="col mb-3">
                    <label for="username" class="form-label">Nama Pengguna</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" value="{{ old('username') }}">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
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
                <hr>
                <button class="w-100 btn btn-primary mb-3" type="submit">Masuk</button>
            </form>
        </div>
    </div>
@endsection
