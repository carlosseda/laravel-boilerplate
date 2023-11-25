export default (() => {

  document.addEventListener("notification", event => {

    const notification = document.querySelector('.notification');
    const message = notification.querySelector('p');

    notification.classList.add('active');
    notification.classList.add(event.detail.type);
    message.textContent = event.detail.message;

    setTimeout(function () {
      notification.classList.remove('active')
    }, 5000)
    
  });
  
})();