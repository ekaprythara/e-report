@extends('/layouts/main')

@section('body')
    <div class="h1 fw-bold">
        Beranda
    </div>

    {{-- Modal --}}
    @can('kabid')
        <div class="container-fluid rounded bg-white p-3 mb-3">
            <div class="row col-container d-flex justify-content-center align-items-center">
                <div class="col-wrap col-md-3 mb-2">
                    <div class="card text-white bg-primary h-100">
                        <div class="card-header fw-bold">Logistik Masuk</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h1 class="card-text fw-bold">
                                    {{ Str::limit($inboundLogistics, 3, '+') }}
                                </h1>
                                <h1><i class="bi bi-clipboard2-plus"></i></h1>
                            </div>
                        </div>
                        <div class="card-footer d-grid gap-2 p-2">
                            <a href="/laporan/logistik-masuk" type="button"
                                class="btn btn-light d-flex justify-content-between align-items-center">
                                <span>Lihat Rincian</span>
                                <span><i class="bi bi-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-wrap col-md-3 mb-2">
                    <div class="card text-white bg-danger h-100">
                        <div class="card-header fw-bold">Logistik Keluar</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h1 class="card-text fw-bold">
                                    {{ Str::limit($outboundLogistics, 3, '+') }}
                                </h1>
                                <h1><i class="bi bi-clipboard2-minus"></i></h1>
                            </div>
                        </div>
                        <div class="card-footer d-grid gap-2 p-2">
                            <a href="/laporan/logistik-keluar" type="button"
                                class="btn btn-light d-flex justify-content-between align-items-center">
                                <span>Lihat Rincian</span>
                                <span><i class="bi bi-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-wrap col-md-3 mb-2">
                    <div class="card text-white bg-danger h-100">
                        <div class="card-header fw-bold">Logistik Kedaluwarsa</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h1 class="card-text fw-bold">
                                    {{ Str::limit($expiredLogisticsKabid, 3, '+') }}
                                </h1>
                                <h1><i class="bi bi-clipboard2-x"></i></h1>
                            </div>
                        </div>
                        <div class="card-footer d-grid gap-2 p-2">
                            <a href="/laporan/logistik-kedaluwarsa" type="button"
                                class="btn btn-light d-flex justify-content-between align-items-center">
                                <span>Lihat Rincian</span>
                                <span><i class="bi bi-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-wrap col-md-3 mb-2">
                    <div class="card text-white bg-primary h-100">
                        <div class="card-header fw-bold">Stok Logistik</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h1 class="card-text fw-bold">
                                    {{ Str::limit($logistics, 3, '+') }}
                                </h1>
                                <h1><i class="bi bi-clipboard2-check"></i></h1>
                            </div>
                        </div>
                        <div class="card-footer d-grid gap-2 p-2">
                            <a href="/laporan/stok-logistik" type="button"
                                class="btn btn-light d-flex justify-content-between align-items-center">
                                <span>Lihat Rincian</span>
                                <span><i class="bi bi-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    @can('pegawai')
        <div class="container-fluid rounded bg-white p-3 mb-3">
            <div class="row col-container d-flex justify-content-between align-items-center">
                <div class="col-wrap col-md-3 mb-2">
                    <div class="card text-white bg-danger h-100">
                        <div class="card-header fw-bold">Pengguna</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h1 class="card-text fw-bold">
                                    {{ Str::limit($users, 3, '+') }}
                                </h1>
                                <h1><i class="bi bi-person"></i></h1>
                            </div>
                        </div>
                        <div class="card-footer d-grid gap-2 p-2">
                            <a href="/data-master/pengguna" type="button"
                                class="btn btn-light d-flex justify-content-between align-items-center">
                                <span>Lihat Rincian</span>
                                <span><i class="bi bi-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-wrap col-md-3 mb-2">
                    <div class="card text-white bg-warning h-100">
                        <div class="card-header fw-bold">Penerima</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h1 class="card-text fw-bold">
                                    {{ Str::limit($receivers, 3, '+') }}
                                </h1>
                                <h1><i class="bi bi-people"></i></h1>
                            </div>
                        </div>
                        <div class="card-footer d-grid gap-2 p-2">
                            <a href="/data-master/penerima" type="button"
                                class="btn btn-light d-flex justify-content-between align-items-center">
                                <span>Lihat Rincian</span>
                                <span><i class="bi bi-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-wrap col-md-3 mb-2">
                    <div class="card text-white bg-success h-100">
                        <div class="card-header fw-bold">Logistik</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h1 class="card-text fw-bold">
                                    {{ Str::limit($logistics, 3, '+') }}
                                </h1>
                                <h1><i class="bi bi-box-seam"></i></h1>
                            </div>
                        </div>
                        <div class="card-footer d-grid gap-2 p-2">
                            <a href="/data-master/logistik" type="button"
                                class="btn btn-light d-flex justify-content-between align-items-center">
                                <span>Lihat Rincian</span>
                                <span><i class="bi bi-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-wrap col-md-3 mb-2">
                    <div class="card text-white bg-primary h-100">
                        <div class="card-header fw-bold">Penyuplai</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h1 class="card-text fw-bold">
                                    {{ Str::limit($suppliers, 3, '+') }}
                                </h1>
                                <h1><i class="bi bi-cart2"></i></h1>
                            </div>
                        </div>
                        <div class="card-footer d-grid gap-2 p-2">
                            <a href="/data-master/penyuplai" type="button"
                                class="btn btn-light d-flex justify-content-between align-items-center">
                                <span>Lihat Rincian</span>
                                <span><i class="bi bi-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid rounded bg-white p-3 mb-3">
            <div class="row col-container d-flex justify-content-center align-items-center">
                <div class="col-wrap col-md-3 mb-2">
                    <div class="card text-white bg-primary h-100">
                        <div class="card-header fw-bold">Logistik Masuk</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h1 class="card-text fw-bold">
                                    {{ Str::limit($inboundLogistics, 3, '+') }}
                                </h1>
                                <h1><i class="bi bi-clipboard2-plus"></i></h1>
                            </div>
                        </div>
                        <div class="card-footer d-grid gap-2 p-2">
                            <a href="/transaksi/logistik-masuk" type="button"
                                class="btn btn-light d-flex justify-content-between align-items-center">
                                <span>Lihat Rincian</span>
                                <span><i class="bi bi-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-wrap col-md-3 mb-2">
                    <div class="card text-white bg-danger h-100">
                        <div class="card-header fw-bold">Logistik Keluar</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h1 class="card-text fw-bold">
                                    {{ Str::limit($outboundLogistics, 3, '+') }}
                                </h1>
                                <h1><i class="bi bi-clipboard2-minus"></i></h1>
                            </div>
                        </div>
                        <div class="card-footer d-grid gap-2 p-2">
                            <a href="/transaksi/logistik-keluar" type="button"
                                class="btn btn-light d-flex justify-content-between align-items-center">
                                <span>Lihat Rincian</span>
                                <span><i class="bi bi-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-wrap col-md-3 mb-2">
                    <div class="card text-white bg-danger h-100">
                        <div class="card-header fw-bold">Logistik Kedaluwarsa</div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h1 class="card-text fw-bold">
                                    {{ Str::limit($expiredLogisticsPegawai, 3, '+') }}
                                </h1>
                                <h1><i class="bi bi-clipboard2-x"></i></h1>
                            </div>
                        </div>
                        <div class="card-footer d-grid gap-2 p-2">
                            <a href="/transaksi/logistik-kedaluwarsa" type="button"
                                class="btn btn-light d-flex justify-content-between align-items-center">
                                <span>Lihat Rincian</span>
                                <span><i class="bi bi-chevron-right"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
