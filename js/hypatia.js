var menu = document.querySelector('nav ul');
var toggle = document.querySelector('#toggle-menu');

toggle.addEventListener('click', function (event) {
	event.preventDefault();
  menu.classList.toggle('visible');
  console.log(menu.classList);
}, false);
