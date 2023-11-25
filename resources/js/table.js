export default (() => {

  const tableSection = document.querySelector('.table');

  document.addEventListener("refreshTable", event => {
    tableSection.innerHTML = event.detail.table;
  });

  tableSection.addEventListener('click', async (event) => {

    if (event.target.closest('.edit-button')) {

      const editButton = event.target.closest('.edit-button')
      const endpoint = editButton.dataset.endpoint;

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

        const json = await error.json();

        document.dispatchEvent(new CustomEvent('notification', {
          detail: {
            message: json.message,
            type: 'error'
          }
        }))
      }
    }

    if (event.target.closest('.destroy-button')) {

      const destroyButton = event.target.closest('.destroy-button');
      const endpoint = destroyButton.dataset.endpoint;

      document.dispatchEvent(new CustomEvent('openModalDestroy', {
        detail: {
          endpoint: endpoint,
        }
      }));
    }

    if (event.target.closest('.table-filter-button')) {
      const filter = document.querySelector(".filter");
      filter.classList.toggle("active");
    }

    if (event.target.closest('.filter-cancel')) {
      const filter = document.querySelector(".filter");
      filter.classList.remove('active');
    }

    if (event.target.closest('.table-pagination-button')){

      const paginationButton = event.target.closest('.table-pagination-button');

      if(paginationButton.classList.contains('inactive')){
        return;
      }

      try{
        
        let endpoint = paginationButton.dataset.pagination;

        const response = await fetch(endpoint, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          },
          method: 'GET',
        })

        if (response.status === 500) {
          throw response
        }

        const json = await response.json();

        document.dispatchEvent(new CustomEvent('refreshTable', {
          detail: {
            table: json.table,
          }
        }));

      }catch(error){

        const json = await error.json();

        document.dispatchEvent(new CustomEvent('notification', {
          detail: {
            message: json.message,
            type: 'error'
          }
        }))
      }
    }

    tableSection.addEventListener('change', async (event) => {

      if(event.target.closest('.table-pagination-select select')){

        try{
          const paginationSelect = event.target.closest('.table-pagination-select select');
          const endpoint = paginationSelect.value;

          const response = await fetch(endpoint, {
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
            },
            method: 'GET',
          })

          if (response.status === 500) {
            throw response
          }

          const json = await response.json();

          document.dispatchEvent(new CustomEvent('refreshTable', {
            detail: {
              table: json.table,
            }
          }));
        }catch(error){

          const json = await error.json();

          document.dispatchEvent(new CustomEvent('notification', {
            detail: {
              message: json.message,
              type: 'error'
            }
          }))
        } 
      }
    });
  });

})();
