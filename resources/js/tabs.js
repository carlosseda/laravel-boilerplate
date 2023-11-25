export default (() => {

  const main = document.querySelector('main');

  main.addEventListener('click', (event) => {

    if (event.target.closest('.tab')) {
      
      const tab = event.target.closest('.tab');
      const tabsContent = document.querySelector('.tabs-content');
      const tabContent = tabsContent.querySelector(`[data-tab="${tab.dataset.tab}"]`);

      tab.parentElement.querySelector('.active').classList.remove('active');
      tabContent.parentElement.querySelector('.active').classList.remove('active')

      tab.classList.add('active');
      tabContent.classList.add('active');

    }
  });
  
})();