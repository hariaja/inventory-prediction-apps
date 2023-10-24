$(() => {
    // Function to fetch and display transaction_id details
    function showTransactionDetails(uuid) {
        var url = urlShowDetail.replace(":uuid", uuid);

        $.getJSON(url, function (response) {
            if (response) {
                $("#transaction-detail").show();

                const transaction = response.transaction;
                const product = transaction.product;
                const user = transaction.user;

                console.log(transaction);

                $("#transaction-code").text(transaction.code);
                $("#product-name").text(product.name);
                $("#product-quantity-one-day").text(product.quantity_one_day);
                $("#transaction-success").text(transaction.quantity);
            }
        });
    }

    // Add change event handler to #transaction_id
    $("#transaction_id").change(function () {
        var selectedOption = $(this).find("option:selected");
        var uuid = selectedOption.attr("data-uuid");

        showTransactionDetails(uuid);
    });
});
