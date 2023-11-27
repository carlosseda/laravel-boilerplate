export default (() => {

  const tableSection = document.querySelector('.table');

  tableSection?.addEventListener('click', async (event) => {

    if (event.target.closest('.table-filter-button')) {
      const filter = document.querySelector(".filter");
      filter.classList.add("active");
    }

    if (event.target.closest('.filter-cancel')) {
      const filter = document.querySelector(".filter");
      filter.classList.remove('active');
    }
  
  });

})();
