document.getElementById("total").addEventListener("input", function () {
    var max = parseFloat(this.getAttribute("max"));
    if (this.value > max) {
        this.value = max;
    }
});
