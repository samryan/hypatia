$(document).ready(function(){
  $('#toggle-menu').on('click', function(e) {
    e.preventDefault();
    $('nav ul').slideToggle(100);
  });
});
