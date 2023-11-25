export default (() => {

  document.addEventListener("showValidationErrors", event => {

    const errors = event.detail.errors;
    const form = event.detail.form;
    const validationError = form.querySelector('.validation-error');
    const errorMessage = document.createElement('ul');

    Object.keys(errors).forEach(function(key) {
      let input = document.querySelector(`[name="${key}"]`);
      input.classList.add('error');

      let error = document.createElement('li');
      error.textContent = `* ${errors[key]}`;
      errorMessage.appendChild(error);
    })

    if (validationError.firstChild) {
      validationError.removeChild(validationError.firstChild);
    }

    validationError.appendChild(errorMessage);   

  });

  document.addEventListener("input", event => {
    if (event.target.classList.contains('error')) {
      event.target.classList.remove('error');
    }
  });

})();

