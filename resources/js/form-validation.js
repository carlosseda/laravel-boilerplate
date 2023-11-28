export default (() => {

  const formSection = document.querySelector('.form');

  document.addEventListener("showformValidations", event => {

    const errors = event.detail.errors;
    const formValidation = event.detail.formValidation;
    const errorMessage = document.createElement('ul');
    
    Object.keys(errors).forEach(function(key) {
      let input = document.querySelector(`[name="${key}"]`);
      input.classList.add('error');

      let error = document.createElement('li');
      error.textContent = `* ${errors[key]}`;
      errorMessage.appendChild(error);
    })

    formValidation.innerHTML = errorMessage.outerHTML;   

  });

  formSection?.addEventListener("input", event => {
    if (event.target.classList.contains('error')) {
      event.target.classList.remove('error');
    }
  });

})();

