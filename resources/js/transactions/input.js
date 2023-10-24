$(() => {
    // Function to fetch and display product details
    function showProductDetails(uuid) {
        var url = urlShowDetail.replace(":uuid", uuid);

        $.getJSON(url, function (response) {
            if (response) {
                $("#product-detail").show();

                const product = response.product;
                $("#product-code").text(product.code);
                $("#product-name").text(product.name);
                $("#product-price").text(product.unit_price);
                $("#product-quantity").text(product.quantity + " Pcs");
            }
        });
    }

    // Check if a product is pre-selected on page load
    var selectedOption = $("#product_id").find("option:selected");
    if (selectedOption.length > 0) {
        var uuid = selectedOption.attr("data-uuid");
        showProductDetails(uuid);
    }

    // Add change event handler to #product_id
    $("#product_id").change(function () {
        var selectedOption = $(this).find("option:selected");
        var uuid = selectedOption.attr("data-uuid");

        showProductDetails(uuid);
    });
});

document.getElementById("quantity").addEventListener("input", function () {
    var max = parseFloat(this.getAttribute("max"));
    if (this.value > max) {
        this.value = max;
    }
});
