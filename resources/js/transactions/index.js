import { showConfirmationModal } from "@/utils/helper.js";

let table;

$(() => {
    table = $(".table").DataTable();
});

function deleteProduct(url) {
    showConfirmationModal(
        "Dengan menekan tombol hapus, Maka semua data <b>Transaksi</b> akan hilang!",
        "Hapus Data",
        url,
        "DELETE",
        handleSuccess
    );
}

function handleSuccess() {
    table.ajax.reload();
}

$(document).on("click", ".delete-transactions", function (e) {
    e.preventDefault();
    let url = urlDestroy;
    url = url.replace(":uuid", $(this).data("uuid"));
    deleteProduct(url);
});

// Show Detail product
// $(document).on("click", ".show-products", function (e) {
//     e.preventDefault();
//     var url = urlShowDetail.replace(":uuid", $(this).data("uuid"));
//     function showProduct(url) {
//         const modal = $("#modal-show-product");
//         const modalContent = modal.find(".modal-content");

//         modal.modal("show");
//         modal.find(".block-title").text("Detail Data Product");

//         $.get(url).done((response) => {
//             const product = response.product;
//             // const kelas = product.room;

//             console.log(product);

//             const elements = {
//                 "#product-name": product.name,
//                 "#product-code": product.code,
//                 "#product-quantity": product.quantity + " Pcs",
//                 "#product-unit-price": product.unit_price,
//                 "#product-produced-at": product.produced_date,
//                 "#product-expired-at": product.expired_date,
//                 "#product-description": product.description,
//             };

//             Object.entries(elements).forEach(([selector, value]) => {
//                 modalContent.find(selector).text(value);
//             });
//         });
//     }

//     return showProduct(url);
// });
