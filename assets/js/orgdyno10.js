document.addEventListener('DOMContentLoaded', function() {
    const addMoreButton = document.getElementById('addMoreFields');
    const container1 = document.getElementById('dynamicFieldsContainer');
    const container2 = document.getElementById('dynamicFieldsContainer2');
    let fieldCountContainer1 = 0;
    let fieldCountContainer2 = 0;

    addMoreButton.addEventListener('click', function(event) {
        event.preventDefault();

        if (fieldCountContainer1 < 5) {
            // Add to dynamicFieldsContainer (1 to 5)
            fieldCountContainer1++;
            addField(container1, fieldCountContainer1);
        } else if (fieldCountContainer2 < 5) {
            // Add to dynamicFieldsContainer2 (6 to 10)
            fieldCountContainer2++;
            addField(container2, fieldCountContainer1 + fieldCountContainer2); // Calculate field number
        } else {
            alert("No more fields allowed.");
        }
    });

    function addField(container, fieldCount) {
        const newField = document.createElement('div');
        newField.classList.add('input-group', 'mb-3');
        newField.innerHTML = `
            <input type="text" class="form-control" placeholder="Enter label for Field ${fieldCount}" name="label${fieldCount}">
            <input type="text" class="form-control" placeholder="Enter value for Field ${fieldCount}" name="field${fieldCount}">
            <button class="btn btn-danger ms-2 removeBtn">Remove</button>
        `;
        container.appendChild(newField);

        // Add event listener to the remove button
        const removeBtn = newField.querySelector('.removeBtn');
        removeBtn.addEventListener('click', function() {
            container.removeChild(newField);
            if (container === container1) {
                fieldCountContainer1--;
            } else if (container === container2) {
                fieldCountContainer2--;
            }
        });
    }
});
