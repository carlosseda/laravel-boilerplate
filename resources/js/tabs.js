export default (() => {

  const main = document.querySelector('main');

  main?.addEventListener('click', (event) => {

    event.preventDefault();

    if (event.target.closest('.tab')) {
      const tab = event.target.closest('.tab');
      tab.parentElement.querySelector('.active').classList.remove('active');
      tab.classList.add('active');

      tab.closest('section').querySelector(".tab-content.active").classList.remove('active');
      tab.closest('section').querySelector(`.tab-content[data-tab="${tab.dataset.tab}"]`).classList.add('active')
    }
  });
  
})();