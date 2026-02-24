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

  // ==========================================================================
  // Lazy view-transition-name on click (avoids promoting every cover to its
  // own compositing layer on list pages)
  // ==========================================================================
  (function() {
    if (!document.startViewTransition && !CSS.supports('view-transition-name', 'test')) return;

    // On pointerdown: set view-transition-name early so the browser has time
    // to commit the style before capturing the old-page snapshot on navigation.
    // Using click is too late — the snapshot can race ahead of the style change.
    var lastTaggedImg = null;
    document.addEventListener('pointerdown', function(e) {
      // Clear any previously tagged cover (e.g. pointer moved away without navigating)
      if (lastTaggedImg) {
        lastTaggedImg.style.viewTransitionName = '';
        lastTaggedImg = null;
      }
      var link = e.target.closest('a[href]');
      if (!link) return;
      var img = link.querySelector('img[data-book-id]');
      if (img) {
        var id = img.getAttribute('data-book-id');
        img.style.viewTransitionName = 'book-' + id;
        sessionStorage.setItem('vt-book', id);
        lastTaggedImg = img;
        return;
      }
      // Navigating away from a detail page (e.g. breadcrumb): stash its book ID
      var hero = document.querySelector('.book-3d[style*="view-transition-name"]');
      if (hero) {
        var match = hero.style.viewTransitionName.match(/book-(\d+)/);
        if (match) sessionStorage.setItem('vt-book', match[1]);
      }
    });

    // On incoming page: set view-transition-name on the matching cover
    // so the morph works in reverse (detail→list).
    window.addEventListener('pagereveal', function(e) {
      if (!e.viewTransition) return;
      var id = sessionStorage.getItem('vt-book');
      if (!id) return;
      sessionStorage.removeItem('vt-book');
      var img = document.querySelector('img[data-book-id="' + id + '"]');
      if (img) img.style.viewTransitionName = 'book-' + id;
    });
  })();

  // ==========================================================================
  // Lazy view-transition-name for project images (home ↔ projects page).
  // Home page images are marked with [data-vt-project]; on the projects page
  // matching images are found in .entry-content by comparing filenames.
  // ==========================================================================
  (function() {
    if (!document.startViewTransition && !CSS.supports('view-transition-name', 'test')) return;

    function vtName(src) {
      var base = src.split('/').pop().split('?')[0].replace(/\.[^.]+$/, '');
      return 'project--' + base.replace(/[^a-zA-Z0-9-]/g, '-');
    }

    // Gather home page project images (marked in template)
    var homeImgs = document.querySelectorAll('img[data-vt-project]');

    // Persist the matchable VT keys when on the home page so the projects
    // page knows which entry-content images are worth tagging.
    if (homeImgs.length) {
      var keys = [];
      homeImgs.forEach(function(img) { keys.push(vtName(img.src)); });
      sessionStorage.setItem('vt-project-keys', JSON.stringify(keys));
    }

    var knownKeys = null;
    try { knownKeys = JSON.parse(sessionStorage.getItem('vt-project-keys')); } catch(e) {}
    if (!knownKeys || !knownKeys.length) return;

    var tagged = [];

    document.addEventListener('pointerdown', function(e) {
      tagged.forEach(function(el) { el.style.viewTransitionName = ''; });
      tagged = [];

      var link = e.target.closest('a[href]');
      if (!link) return;

      // Home page: tag the marked project images
      if (homeImgs.length) {
        homeImgs.forEach(function(img) {
          img.style.viewTransitionName = vtName(img.src);
          tagged.push(img);
        });
        sessionStorage.setItem('vt-project', '1');
        return;
      }

      // Projects page: only tag entry-content images that match known keys
      var used = {};
      document.querySelectorAll('.entry-content img').forEach(function(img) {
        var name = vtName(img.src);
        if (!used[name] && knownKeys.indexOf(name) !== -1) {
          img.style.viewTransitionName = name;
          tagged.push(img);
          used[name] = true;
        }
      });
      if (tagged.length) sessionStorage.setItem('vt-project', '1');
    });

    window.addEventListener('pagereveal', function(e) {
      if (!e.viewTransition) return;
      if (!sessionStorage.getItem('vt-project')) return;
      sessionStorage.removeItem('vt-project');

      // Home page: tag marked images
      var revealHomeImgs = document.querySelectorAll('img[data-vt-project]');
      if (revealHomeImgs.length) {
        revealHomeImgs.forEach(function(img) {
          img.style.viewTransitionName = vtName(img.src);
        });
        return;
      }

      // Projects page: tag matching entry-content images
      var used = {};
      document.querySelectorAll('.entry-content img').forEach(function(img) {
        var name = vtName(img.src);
        if (!used[name] && knownKeys.indexOf(name) !== -1) {
          img.style.viewTransitionName = name;
          used[name] = true;
        }
      });
    });
  })();

  // ==========================================================================
  // Scroll-triggered animations
  // ==========================================================================
  (function() {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var animObserver = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate-in');
          animObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });

    // Bar chart bars — set stagger index and observe
    var chartBar = document.querySelector('.stats-chart-bar');
    if (chartBar) {
      var items = chartBar.querySelectorAll('.chart-bar-item');
      items.forEach(function(item, i) {
        var inner = item.querySelector('.chart-bar-inner');
        if (inner) inner.style.setProperty('--i', i);
      });
      animObserver.observe(chartBar);
    }

    // Rating distribution bars — set stagger index and observe
    var ratingsSection = document.querySelector('.stats-ratings');
    if (ratingsSection) {
      var rows = ratingsSection.querySelectorAll('.stats-rating-row');
      rows.forEach(function(row, i) {
        var bar = row.querySelector('.rating-bar');
        if (bar) bar.style.setProperty('--i', i);
      });
      animObserver.observe(ratingsSection);
    }

    // Staggered book grid fade-in
    document.querySelectorAll('.books .list, .book-card-list').forEach(function(list) {
      var children = list.children;
      var max = Math.min(children.length, 18); // cap stagger
      for (var i = 0; i < children.length; i++) {
        children[i].style.setProperty('--i', Math.min(i, max));
      }
      list.classList.add('will-animate');

      var rect = list.getBoundingClientRect();
      if (rect.top < window.innerHeight) {
        // Above the fold: animate on load. Double-rAF ensures the
        // browser paints the invisible state before starting the animation.
        requestAnimationFrame(function() {
          requestAnimationFrame(function() {
            list.classList.add('animate-in');
          });
        });
      } else {
        // Below the fold: animate on scroll into view
        animObserver.observe(list);
      }
    });
  })();

  // ==========================================================================
  // Stat card count-up animation (books overview page only)
  // ==========================================================================
  (function() {
    var statsOverview = document.querySelector('.stats-overview');
    if (!statsOverview) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var duration = 800;
    var startPct = 0.7;
    function easeOutQuart(t) { return 1 - Math.pow(1 - t, 4); }

    var statNumbers = statsOverview.querySelectorAll('.stat-number');
    var originalValues = [];
    statNumbers.forEach(function(el) {
      originalValues.push(el.textContent.trim());
    });

    function parseValue(text) {
      var match = text.match(/([\d,]+\.?\d*)/);
      if (!match) return null;
      var raw = match[1];
      var num = parseFloat(raw.replace(/,/g, ''));
      var hasComma = raw.indexOf(',') !== -1;
      var decimals = raw.indexOf('.') !== -1 ? raw.split('.')[1].length : 0;
      var suffix = text.slice(text.indexOf(raw) + raw.length);
      return { num: num, hasComma: hasComma, decimals: decimals, suffix: suffix };
    }

    function formatValue(num, parsed) {
      if (parsed.hasComma) {
        return num.toLocaleString('en-US', {
          minimumFractionDigits: parsed.decimals,
          maximumFractionDigits: parsed.decimals
        }) + parsed.suffix;
      }
      return (parsed.decimals > 0 ? num.toFixed(parsed.decimals) : Math.round(num).toString()) + parsed.suffix;
    }

    var animFrameId = null;

    function runCountUp() {
      if (animFrameId) cancelAnimationFrame(animFrameId);

      var startTime = null;
      var parsed = originalValues.map(parseValue);

      function tick(time) {
        if (!startTime) startTime = time;
        var progress = Math.min((time - startTime) / duration, 1);
        var eased = easeOutQuart(progress);

        statNumbers.forEach(function(el, i) {
          if (!parsed[i]) return;
          var from = parsed[i].num * startPct;
          var current = from + (parsed[i].num - from) * eased;
          el.textContent = formatValue(current, parsed[i]);
        });

        if (progress < 1) {
          animFrameId = requestAnimationFrame(tick);
        }
      }

      animFrameId = requestAnimationFrame(tick);
    }

    // Auto-run on first scroll into view
    var countObserver = new IntersectionObserver(function(entries) {
      if (entries[0].isIntersecting) {
        runCountUp();
        countObserver.disconnect();
      }
    }, { threshold: 0.3 });
    countObserver.observe(statsOverview);
  })();
})();
