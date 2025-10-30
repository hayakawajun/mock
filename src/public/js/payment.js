const selectElement = document.getElementById('payment-select');

const displayArea = document.getElementById('payment__display-area');

selectElement.addEventListener('change', (event) => {
    const selectedOption = event.target.options[event.target.selectedIndex];

    const selectedText = selectedOption.textContent;

    displayArea.textContent = selectedText;
});