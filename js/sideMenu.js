document.addEventListener('DOMContentLoaded', function () {

    var kmRange = document.getElementById('km-range-bar');
    var kmLabel = document.getElementById('km-label');

    kmRange.addEventListener('input', function () {
        var kmValue = this.value;
        kmLabel.textContent = kmValue;
    });

    kmLabel.textContent = kmRange.value;

    //  Para alterar o preço: --------------------------------------------------------------------------------------

    function formatPrice(value) {
        return value.replace(/[^\d,]/g, '').replace(',', '.');
    }

    document.getElementById('max-price-search').addEventListener('focus', function () {
        if (this.value === "R$") {
            this.value = "";
        }
    });

    // Evento para quando o campo perde o foco
    document.getElementById('min-price-search').addEventListener('blur', function () {
        if (this.value === "") {
            this.value = "R$";
        } else {
            this.value = formatPrice(this.value);
        }
    });

    document.getElementById('max-price-search').addEventListener('blur', function () {
        if (this.value === "") {
            this.value = "R$";
        } else {
            this.value = formatPrice(this.value);
        }
    });

    // Durante o input, formata o valor enquanto o usuário digita, mas sem acrescentar valores
    document.getElementById('min-price-search').addEventListener('input', function () {
        let value = this.value.replace("R$", "").trim();
        this.value = "R$ " + formatPrice(value).replace("R$", "").trim();
    });

    document.getElementById('max-price-search').addEventListener('input', function () {
        let value = this.value.replace("R$", "").trim();
        this.value = "R$ " + formatPrice(value).replace("R$", "").trim();
    });
});

