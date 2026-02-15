(function() {
  'use strict';

  var a = false;
  var toggleMenu = document.querySelector('#toggle-menu');
  if (toggleMenu) {
    toggleMenu.addEventListener('click', function(e) {
      e.preventDefault();
      a = !a;
      toggleMenu.setAttribute('aria-expanded', a);
      var nav = document.querySelector('#site-navigation ul');
      if (nav) nav.classList.toggle('visible');
    }, false);
  }

  var toggleTheme = document.querySelector('#toggle-theme');
  if (toggleTheme) {
    toggleTheme.addEventListener('click', function(e) {
      e.preventDefault();
      var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
      var themeColor = document.getElementById('theme-color');
      if (themeColor) {
        if (isDark) {
          document.documentElement.removeAttribute('data-theme');
          localStorage.setItem('theme', 'light');
          themeColor.setAttribute('content', '#ffffff');
        } else {
          document.documentElement.setAttribute('data-theme', 'dark');
          localStorage.setItem('theme', 'dark');
          themeColor.setAttribute('content', '#000000');
        }
      }
    }, false);
  }

  // Format ordered list numbers with thousands separators
  (function() {
    var bookLists = document.querySelectorAll('ol.book-list');
    if (!bookLists.length) {
      var allOls = document.querySelectorAll('ol[reversed]');
      bookLists = Array.prototype.filter.call(allOls, function(ol) {
        return ol.querySelector('.book-list-item');
      });
    }
    bookLists.forEach(function(ol) {
      var items = ol.querySelectorAll('.book-list-item');
      var isReversed = ol.hasAttribute('reversed');
      var start = parseInt(ol.getAttribute('start'), 10) || (isReversed ? items.length : 1);

      items.forEach(function(item, index) {
        var number = isReversed ? start - index : start + index;
        item.setAttribute('data-number', number.toLocaleString('en-US'));
      });
    });
  })();

  // Add shadow to header when scrolled
  (function() {
    var header = document.querySelector('header.site-header');
    if (header) {
      window.addEventListener('scroll', function() {
        if (window.scrollY > 10) {
          header.classList.add('scrolled');
        } else {
          header.classList.remove('scrolled');
        }
      }, { passive: true });
    }
  })();

  // Favorites "Show all" button (only on books overview page)
  var favoritesShowAll = document.getElementById('favorites-show-all');
  if (favoritesShowAll) {
    favoritesShowAll.addEventListener('click', function() {
      var extra = document.getElementById('favorites-extra');
      if (extra) {
        extra.classList.remove('favorites-hidden');
        var firstLink = extra.querySelector('a');
        if (firstLink) firstLink.focus();
      }
      this.remove();
    });
  }
})();
