const selectElement = document.getElementById('payment-select');

const displayArea = document.getElementById('payment__display-area');

function updateDisplayArea() {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    displayArea.textContent = selectedOption.textContent;
}

selectElement.addEventListener('change', (event) => {
    updateDisplayArea();
});

updateDisplayArea();