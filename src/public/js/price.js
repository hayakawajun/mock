function formatPrice(input) {

    let value = input.value;

    value = value.replace(/[^0-9]/g, '');

    let numberValue = parseInt(value, 10);

    if (!isNaN(numberValue)) {
        input.value = new Intl.NumberFormat('ja-JP').format(numberValue);
    }
}

document.addEventListener('DOMContentLoaded', (event) => {

    const priceDisplay = document.getElementById('price_display');

    if (priceDisplay && priceDisplay.value !== '') {
        formatPrice(priceDisplay);
    }
});

const form = document.getElementById('item_exhibition');

const priceDisplay = document.getElementById('price_display');

const priceActual = document.getElementById('price_actual');

form.addEventListener('submit', function () {

    let displayValue = priceDisplay.value;

    let actualValue = displayValue.replace(/,/g, '');

    priceActual.value = actualValue;
});