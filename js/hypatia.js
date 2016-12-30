$(document).ready(function(){
  
    $('#toggle-menu').on('click', function(e) {
      e.preventDefault();
      $('nav ul').slideToggle(100);
    });

  window.addEventListener('load', function(){
    Grade(document.querySelectorAll('.bg-grade'))
  });
});
