export default (() => {

  const tableSection = document.querySelector('.table');

  tableSection?.addEventListener('click', async (event) => {

    if (event.target.closest('.table-pagination-page')){

      const paginationButton = event.target.closest('.table-pagination-page');

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
  });
})();
