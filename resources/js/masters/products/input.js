$(() => {
    var dateInput = $("#produced_at");

    dateInput.flatpickr({
        maxDate: "today",
        dateFormat: "Y-m-d",
    });
});

document.getElementById("quantity").addEventListener("input", function () {
    var max = parseFloat(this.getAttribute("max"));
    if (this.value > max) {
        this.value = max;
    }
});

// Convert Format
var rupiahInput = document.getElementById("price");

// Mengatur event listener untuk mengupdate format saat pengguna mengetik
rupiahInput.addEventListener("keyup", function (e) {
    // Mengambil nilai input
    var nominal = this.value;

    // Menghapus karakter non-digit
    nominal = nominal.replace(/\D/g, "");

    // Memformat nilai Rupiah
    var formattedNominal = formatRupiah(nominal);

    // Mengupdate nilai input dengan format Rupiah
    this.value = formattedNominal;
});

// Fungsi untuk memformat nilai Rupiah
function formatRupiah(nominal) {
    var reverse = nominal.toString().split("").reverse().join("");
    var ribuan = reverse.match(/\d{1,3}/g);
    var formattedNominal = ribuan.join(",").split("").reverse().join("");

    return formattedNominal;
}

document.addEventListener("DOMContentLoaded", function () {
    // Mengambil nilai input harga
    var rupiahInput = document.getElementById("price");
    var nominal = rupiahInput.value;

    // Menghapus karakter non-digit
    nominal = nominal.replace(/\D/g, "");

    // Memformat nilai Rupiah
    var formattedNominal = formatRupiah(nominal);

    // Memasukkan nilai yang diformat kembali ke input
    rupiahInput.value = formattedNominal;
});
