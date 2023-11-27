export default (() => {

  const menuButton = document.querySelector(".menu-button");
  const menu = document.querySelector(".menu");

  menuButton?.addEventListener("click", () => {
    menuButton.classList.toggle("active");
    menu.classList.toggle("active");
  });

})();
