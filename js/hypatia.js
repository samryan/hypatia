$(document).ready(function(){
  var w = $(window).width(),
  menuToggle = $('#toggle-menu'),
  menu = $('nav ul'),
  hasChild = $('.has-child'),
  dropdown = $('.dropdown');
  $(function() {
    $(menuToggle).on('click', function(e) {
      e.preventDefault();
      menu.toggle();
    });
  });
  
});
