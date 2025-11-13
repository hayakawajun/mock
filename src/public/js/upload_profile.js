const fileInput = document.getElementById('file-upload');
const fileNameDisplay = document.getElementById('file-name__display');
const previewImage = document.getElementById('preview-image');

fileInput.addEventListener('change', function () {
    const files = this.files;

    if (files && files.length > 0) {
        const file = files[0];
        fileNameDisplay.style.display = 'block';
        fileNameDisplay.textContent = file.name;

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = function (e) {
                previewImage.src = e.target.result;
            };

            reader.readAsDataURL(file);

        } else {
            fileNameDisplay.textContent = '選択されたファイルは画像ではありません'
        }
    }
});