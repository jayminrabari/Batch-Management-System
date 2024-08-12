
    document.getElementById("submit").addEventListener("click", function() {
        // Collect data from the form fields
        var formData = new FormData(document.querySelector("form"));

        // Send an AJAX request to the server
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "create_event.php");
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Parse the response JSON
                var response = JSON.parse(xhr.responseText);

                // Display QR code and unique ID in the popup
                document.getElementById("qr-code").innerHTML = '<img src="' + response.qrCodeUrl + '">';
                document.getElementById("unique-id").textContent = 'Unique ID: ' + response.uniqueId;

                // Show the popup
                document.getElementById("popup").style.display = "block";
            } else {
                console.error('Request failed: ' + xhr.status);
            }
        };
        xhr.send(formData);
    });

