export default (() => {

  const modalSection = document.querySelector('.modal-destroy');
  const destroyConfirm = document.querySelector('.destroy-confirm');

  document.addEventListener("openModalDestroy", event => {
    modalSection.classList.add('active');
    destroyConfirm.dataset.endpoint = event.detail.endpoint;
  });

  modalSection.addEventListener('click', async (event) => {

    if (event.target.closest('.destroy-cancel')) {
      modalSection.classList.remove('active');
    }

    if (event.target.closest('.destroy-confirm')) {

      const destroyConfirm = event.target.closest('.destroy-confirm');
      const endpoint = destroyConfirm.dataset.endpoint;

      try{
        const response = await fetch(endpoint, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
          },
          method: 'DELETE',
        })
  
        if (response.status === 500) {
          throw response
        }
  
        if (response.status === 200) {  

          const json = await response.json();

          modalSection.classList.remove('active');

          document.dispatchEvent(new CustomEvent('notification', {
            detail: {
              message: json.message,
              type: 'success'
            }
          }))
  
          document.dispatchEvent(new CustomEvent('refreshTable', {
            detail: {
              table: json.table,
            }
          }));

          document.dispatchEvent(new CustomEvent('refreshForm', {
            detail: {
              form: json.form,
            }
          }));
        }
      }catch(error){

        modalSection.classList.remove('active');

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
