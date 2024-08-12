    document.addEventListener("DOMContentLoaded", function() {
    const extraYes = document.getElementById('extraYes');
    const extraContainer = document.getElementById('extraContainer');
    const extraOptions = document.getElementById('extraOptions');
    const cancelButton = document.getElementById('extracancelButton');

    extraYes.addEventListener('change', function() {
    if (this.checked) {
    extraContainer.style.display = 'block';
    extraOptions.style.display = 'none';
    cancelButton.style.display = 'block';
    } else {
    extraContainer.style.display = 'none';
    extraOptions.style.display = 'block';
    cancelButton.style.display = 'none';
    }
    });

    cancelButton.addEventListener('click', function() {
    extraContainer.style.display = 'none';
    extraOptions.style.display = 'block';
    cancelButton.style.display = 'none';
    extraYes.checked = false;
    });
    });
