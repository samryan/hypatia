document.querySelector('#toggle-menu').addEventListener('click', function (e) {
	e.preventDefault();
  document.querySelector('nav ul').classList.toggle('visible');
}, false);
