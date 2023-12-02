// Modal Logistik Masuk
$("input:checkbox[name^='logistic_id']").on("change", function () {
    $(this).closest("tr").find("input:text[name^='amount[]'], input:text[name^='expiredDate[]'], input:hidden[name^='expiredDate[]']").prop("disabled", !this.checked);
});

// Modal Logistik Keluar
$("input:checkbox[name^='inboundLogistic_id']").on("change", function () {
    $(this).closest("tr").find("input:text[name^='quantity[]']").prop("disabled", !this.checked);
});
