
document.addEventListener("DOMContentLoaded", function() {
    const sponsorYes = document.getElementById('sponsorYes');
    const sponsorContainer = document.getElementById('sponsorContainer');
    const sponsorOptions = document.getElementById('sponsorOptions');
    const cancelButton = document.getElementById('cancelButton');
    
    sponsorYes.addEventListener('change', function() {
        if (this.checked) {
            sponsorContainer.style.display = 'block';
            sponsorOptions.style.display = 'none';
            cancelButton.style.display = 'block';
        } else {
            sponsorContainer.style.display = 'none';
            sponsorOptions.style.display = 'block';
            cancelButton.style.display = 'none';
        }
    });

    cancelButton.addEventListener('click', function() {
        sponsorContainer.style.display = 'none';
        sponsorOptions.style.display = 'block';
        cancelButton.style.display = 'none';
        sponsorYes.checked = false;
    });
});



