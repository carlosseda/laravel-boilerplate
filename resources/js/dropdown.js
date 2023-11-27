export default (() => {

  const dropdown = document.querySelector('.dropdown');

  dropdown?.addEventListener('click', (event) => {
    dropdown.classList.toggle('active');
  });
})();