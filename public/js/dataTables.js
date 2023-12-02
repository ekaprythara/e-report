// Data Master
$(document).ready(function () {
    $('#tb-level').DataTable({
        pagingType: 'full_numbers',
    });
    $('#tb-pengguna').DataTable({
        pagingType: 'full_numbers',
    });
    $('#tb-unitPenerima').DataTable({
        pagingType: 'full_numbers',
    });
    $('#tb-penerima').DataTable({
        pagingType: 'full_numbers',
    });
    $('#tb-jenisPengadaan').DataTable({
        pagingType: 'full_numbers',
    });
    $('#tb-jenisLogistik').DataTable({
        pagingType: 'full_numbers',
    });
    $('#tb-satuan').DataTable({
        pagingType: 'full_numbers',
    });
    $('#tb-logistik').DataTable({
        pagingType: 'full_numbers',
    });
    $('#tb-penyuplai').DataTable({
        pagingType: 'full_numbers',
    });
});

// Transaksi
// Transaksi > Logistik Masuk
$(document).ready(function () {
    $('#tb-logistikMasuk').DataTable({
        pagingType: 'full_numbers',
    });
    let logMasuk = $('#tb-modLogMasuk').DataTable({
        pageLength: 10,
        lengthChange: false,
    });
    $("#show").on("submit", function(){
        logMasuk.page.len(-1).draw().submit();
    });
});

// Transaksi > Logistik Keluar
$(document).ready(function () {
    $('#tb-logistikKeluar').DataTable({
        pagingType: 'full_numbers',
    });
    let logKeluar = $('#tb-modLogKeluar').DataTable({
        pageLength: 10,
        lengthChange: false,
    });
    $("#show").on("submit", function(){
        logKeluar.page.len(-1).draw().submit();
    });
});

// Laporan
$(document).ready(function () {
    $('#tb-logMasuk').DataTable({
        pagingType: 'full_numbers',
    });
    $('#tb-logKeluar').DataTable({
        pagingType: 'full_numbers',
    });
    $('#tb-stokLogistik').DataTable({
        pagingType: 'full_numbers',
    });
});
