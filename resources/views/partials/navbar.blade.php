{{-- Navbar --}}
<nav class="navbar fixed-top navbar-expand navbar-dark bg-dark">
    <div class="container-fluid">
        <button class="btn btn-dark btn-lg" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
            aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="/dashboard/beranda" class="navbar-brand fw-bold me-auto ms-2">E-REPORT LOGISTIK</a>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                {{-- Navbar Item --}}
            </li>
        </ul>
    </div>
</nav>

{{-- Modal Profil --}}
<div class="modal fade" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="false" id="modalProfil">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="exampleModalLabel">Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col d-flex flex-column justify-content-center align-items-center">
                    @if (Auth::user()->image == null)
                        <img src="{{ asset('/img/default.png') }}" width="180" height="180"
                            class="rounded-circle me-2 mb-3 profile-bg-light">
                    @else
                        <img src="{{ asset('storage/' . Auth::user()->image) }}" width="180" height="180"
                            class="rounded-circle me-2 mb-3 profile-bg-light">
                    @endif
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="infoUsername" class="form-label">Nama
                            Pengguna</label>
                        <input type="text" class="form-control" id="infoUsername" name="username"
                            value="{{ Auth::user()->username }}" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="infoName" class="form-label">Nama
                            Lengkap</label>
                        <input type="text" class="form-control" id="infoName" name="name"
                            value="{{ Auth::user()->name }}" disabled>
                    </div>
                    <div class="col">
                        <label for="infoAddress" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="infoAddress" name="address"
                            value="{{ Auth::user()->address }}" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="infoEmail" class="form-label">Surel</label>
                        <input type="email" class="form-control" id="infoEmail" name="email"
                            value="{{ Auth::user()->email }}" disabled>
                    </div>
                    <div class="col">
                        <label for="infoPhone" class="form-label">Telepon</label>
                        <input type="tel" class="form-control" id="infoPhone" name="phone"
                            value="{{ Auth::user()->phone }}" disabled>
                    </div>
                </div>
                <label for="infoLevel" class="form-label">Level</label>
                <select class="form-select" id="infoLevel" name="level_id" disabled>
                    <option selected>{{ Auth::user()->level->name }}</option>
                </select>
            </div>
            <div class="modal-footer d-flex flex-row-reverse justify-content-between">
                <div>
                    <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Offcanvas --}}
<div class="offcanvas offcanvas-start" style="width: 290px" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-body bg-light p-0" id="collapse">
        <div class="flex-shrink-0 px-4 bg-light" style="height: 100%">
            <div class="d-flex justify-content-center align-items-center">
                @if (Auth::user()->image == null)
                    <img src="{{ asset('/img/default.png') }}" width="130" height="130"
                        class="rounded-circle mt-1 mb-1 profile-bg-white">
                @else
                    <img src="{{ asset('storage/' . Auth::user()->image) }}" width="130" height="130"
                        class="rounded-circle mt-1 mb-1 profile-bg-white">
                @endif
            </div>
            <div class="mt-2">
                <div class="d-flex justify-content-center align-items-center">
                    <a href="/data-master/pengguna"
                        class="fw-bold text-decoration-none text-black mb-1">{{ Auth::user()->username }}</a>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <h5><span class="badge bg-primary inactive">{{ Auth::user()->level->name }}</span></h5>
                </div>
            </div>
            <hr style="color: gray;">
            <ul class="list-unstyled ps-0">
                <li class="my-2">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#dashboard" aria-expanded="false">
                        Dashboard
                    </button>
                    <div class="collapse" id="dashboard">
                        <ul class="btn-toggle-nav list-unstyled fw-normal my-1">
                            <li>
                                <a href="/dashboard/beranda"
                                    class="link-dark d-inline-flex text-decoration-none rounded">Beranda</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="my-2">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#data-master" aria-expanded="false">
                        Data Master
                    </button>
                    <div class="collapse" id="data-master">
                        <ul class="btn-toggle-nav list-unstyled fw-normal my-1">
                            <li>
                                <a href="/data-master/level"
                                    class="link-dark d-inline-flex text-decoration-none rounded">Level</a>
                            </li>
                            <li>
                                <a href="/data-master/pengguna"
                                    class="link-dark d-inline-flex text-decoration-none rounded">Pengguna</a>
                            </li>
                            @can('pegawai')
                                <li>
                                    <a href="/data-master/unit-penerima"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Unit Penerima</a>
                                </li>
                                <li>
                                    <a href="/data-master/penerima"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Penerima</a>
                                </li>
                                <li>
                                    <a href="/data-master/jenis-pengadaan"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Jenis Pengadaan</a>
                                </li>
                                <li>
                                    <a href="/data-master/jenis-logistik"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Jenis Logistik</a>
                                </li>
                                <li>
                                    <a href="/data-master/satuan"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Satuan</a>
                                </li>
                                <li>
                                    <a href="/data-master/logistik"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Logistik</a>
                                </li>
                                <li>
                                    <a href="/data-master/penyuplai"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Penyuplai</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @can('pegawai')
                    <li class="my-2">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                            data-bs-toggle="collapse" data-bs-target="#transaksi" aria-expanded="false">
                            Transaksi
                        </button>
                        <div class="collapse" id="transaksi">
                            <ul class="btn-toggle-nav list-unstyled fw-normal my-1">
                                <li>
                                    <a href="/transaksi/logistik-masuk"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Logistik Masuk</a>
                                </li>
                                <li>
                                    <a href="/transaksi/logistik-keluar"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Logistik Keluar</a>
                                </li>
                                <li>
                                    <a href="/transaksi/logistik-kedaluwarsa"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Logistik
                                        Kedaluwarsa</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('kabid')
                    <li class="my-2">
                        <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                            data-bs-toggle="collapse" data-bs-target="#laporan" aria-expanded="false">
                            Laporan
                        </button>
                        <div class="collapse" id="laporan">
                            <ul class="btn-toggle-nav list-unstyled fw-normal my-1">
                                <li>
                                    <a href="/laporan/logistik-masuk"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Logistik Masuk</a>
                                </li>
                                <li>
                                    <a href="/laporan/logistik-keluar"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Logistik
                                        Keluar</a>
                                </li>
                                <li>
                                    <a href="/laporan/logistik-kedaluwarsa"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Logistik
                                        Kedaluwarsa</a>
                                </li>
                                <li>
                                    <a href="/laporan/stok-logistik"
                                        class="link-dark d-inline-flex text-decoration-none rounded">Stok Logistik</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan
                <li class="border-top my-3"></li>
                <li class="my-2">
                    <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                        Akun
                    </button>
                    <div class="collapse" id="account-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal my-1">
                            <li>
                                <a class="link-dark d-inline-flex text-decoration-none rounded pointer"
                                    data-bs-dismiss="offcanvas" id="profil">Profil</a>
                            </li>
                            <li>
                                <form action="/dashboard/sign-out" method="post" id="logout-form">
                                    @csrf
                                    <a class="link-dark d-inline-flex text-decoration-none rounded pointer"
                                        id="logout">Keluar</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
            <div class="pb-2">
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script>
    $(document).ready(function() {
        $("#profil").click(function() {
            $("#offcanvasExample").offcanvas('hide');
            $("#modalProfil").modal('show');
        });
    });

    document.getElementById("logout").onclick = function() {
        document.getElementById("logout-form").submit();
    }
</script>
