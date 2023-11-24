export default (() => {

  const sectionForm = document.querySelector('.form');
  const storeButton = document.querySelector(".form-store-button");
  const cleanButton = document.querySelector(".form-clean-button");

  storeButton.addEventListener("click", async () => {

    const form = document.querySelector('.admin-form');
    const endpoint = form.action;
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

      if (response.status === 500) {
        throw response
      }

      if (response.status === 200) {  
        const json = await response.json();
        sectionForm.innerHTML = json.form;

        document.dispatchEvent(new CustomEvent('refreshTable', {
          detail: {
              table: json.table,
          }
        }));
      }
    }catch(error){
      console.log(error);
    }
  });

  cleanButton.addEventListener("click", async () => {
    const form = document.querySelector('.admin-form');
    form.reset();
  });
})();
