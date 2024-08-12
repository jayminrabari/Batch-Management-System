
    document.addEventListener("DOMContentLoaded", function() {
    const orgYes = document.getElementById('orgYes');
    const orgContainer = document.getElementById('orgContainer');
    const orgOptions = document.getElementById('orgOptions');
    const cancelButton = document.getElementById('orgcancelButton');

    orgYes.addEventListener('change', function() {
    if (this.checked) {
    orgContainer.style.display = 'block';
    orgOptions.style.display = 'none';
    cancelButton.style.display = 'block';
    } else {
    orgContainer.style.display = 'none';
    orgOptions.style.display = 'block';
    cancelButton.style.display = 'none';
    }
    });

    cancelButton.addEventListener('click', function() {
    orgContainer.style.display = 'none';
    orgOptions.style.display = 'block';
    cancelButton.style.display = 'none';
    orgYes.checked = false;
    });
    });
 