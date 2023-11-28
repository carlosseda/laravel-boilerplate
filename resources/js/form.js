export default (() => {

  const formSection = document.querySelector('.form');

  document.addEventListener("refreshForm", event => {
    console.log(event.detail.form)
    formSection.innerHTML = event.detail.form;
  });

  formSection?.addEventListener('click', async (event) => {

    if (event.target.closest('.store-button')) {

      const storeButton = event.target.closest('.store-button')
      const endpoint = storeButton.dataset.endpoint;
      const form = document.querySelector('.admin-form');
      const formData = new FormData(form);
    
      try{
        const response = await fetch(endpoint, {
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
          },
          method: 'POST',
          body: formData
        })
  
        if (response.status === 500 || response.status === 422) {
          throw response
        }
  
        if (response.status === 200) {  
  
          const json = await response.json();

          formSection.innerHTML = json.form;

          document.dispatchEvent(new CustomEvent('refreshTable', {
            detail: {
              table: json.table,
            }
          }));

          document.dispatchEvent(new CustomEvent('notification', {
            detail: {
              message: json.message,
              type: 'success'
            }
          }))
        }

      }catch(error){

        if (error.status === 422) {

          const json = await error.json();

          document.dispatchEvent(new CustomEvent('showformValidations', {
            detail: {
              formValidation: form.previousElementSibling,
              errors: json.errors
            }
          }))
        }

        if (error.status === 500) {

          const json = await error.json();

          document.dispatchEvent(new CustomEvent('notification', {
            detail: {
              message: json.message,
              type: 'error'
            }
          }))
        }
      }
    }

    if (event.target.closest('.create-button')) {

      const cleanButton = event.target.closest('.create-button')
      const endpoint = cleanButton.dataset.endpoint;

      try{
        const response = await fetch(endpoint, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          },
          method: 'GET',
        })
  
        if (response.status === 500) {
          throw response
        }
  
        if (response.status === 200) {  

          const json = await response.json();
  
          document.dispatchEvent(new CustomEvent('refreshForm', {
            detail: {
              form: json.form,
            }
          }));
        }
      }catch(error){
        document.dispatchEvent(new CustomEvent('notification', {
          detail: {
            message: 'La acción no se pudo completar por un fallo en el servidor.',
            type: 'error'
          }
        }))
      }
    }
  });
})();
