function formatPrice(input) {

    let value = input.value;

    value = value.replace(/[^0-9]/g, '');

    let numberValue = parseInt(value, 10);

    if (!isNaN(numberValue)) {
        input.value = new Intl.NumberFormat('ja-JP').format(numberValue);
    }
}