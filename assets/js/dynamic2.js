document.addEventListener('DOMContentLoaded', function() {
  const addMoreButton = document.getElementById('addMoreButton');
  const extraDetailsContainer = document.getElementById('extraDetails');
  let fieldCount = 0;
  const maxExtraFields = 10;

  addMoreButton.addEventListener('click', function(event) {
      event.preventDefault();

      if (fieldCount < maxExtraFields) {
          fieldCount++;
          const newField = document.createElement('div');
          newField.classList.add('input-group', 'mb-3');
          newField.innerHTML = `
                  <input type="text" class="form-control" placeholder="Enter label for Field ${fieldCount}" name="label${fieldCount}">
                  <input type="text" class="form-control" placeholder="Enter value for Field ${fieldCount}" name="field${fieldCount}">
                  <button class="btn btn-danger ms-2 removeBtn">Remove</button>
          `;
          extraDetailsContainer.appendChild(newField);

          // Add event listener to the remove button
          const removeBtn = newField.querySelector('.removeBtn');
          removeBtn.addEventListener('click', function() {
              extraDetailsContainer.removeChild(newField);
              fieldCount--;
          });
      } else {
          alert("Only two fields are allowed.");
      }
  });
});
