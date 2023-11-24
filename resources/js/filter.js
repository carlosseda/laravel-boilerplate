export default (() => {

  const filterButton = document.querySelector(".filter-button");
  const filter = document.querySelector(".filter");

  filterButton.addEventListener("click", () => {
    filterButton.classList.toggle("active");
    filter.classList.toggle("active");
  });

})();
