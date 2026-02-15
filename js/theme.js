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

    document.addEventListener('click', function(e) {
      var link = e.target.closest('a[href]');
      if (!link) return;
      var img = link.querySelector('img[data-book-id]');
      if (!img) return;
      img.style.viewTransitionName = 'book-' + img.getAttribute('data-book-id');
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

    // Staggered book grid fade-in (only for grids below the fold)
    document.querySelectorAll('.books .list, .book-card-list').forEach(function(list) {
      var rect = list.getBoundingClientRect();
      if (rect.top < window.innerHeight) return; // already visible, skip

      var children = list.children;
      var max = Math.min(children.length, 18); // cap stagger
      for (var i = 0; i < children.length; i++) {
        children[i].style.setProperty('--i', Math.min(i, max));
      }
      list.classList.add('will-animate');
      animObserver.observe(list);
    });
  })();

  // ==========================================================================
  // Stat card count-up prototype (books overview page only)
  // ==========================================================================
  (function() {
    var statsOverview = document.querySelector('.stats-overview');
    if (!statsOverview) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var panel = document.createElement('div');
    panel.className = 'countup-panel';
    panel.innerHTML =
      '<h3>Count-up prototype</h3>' +
      '<label><span>Duration <output id="cp-dur-val">800ms</output></span>' +
      '<input type="range" id="cp-duration" min="200" max="1500" value="800" step="50"></label>' +
      '<label><span>Start from <output id="cp-start-val">70%</output></span>' +
      '<input type="range" id="cp-start" min="0" max="90" value="70" step="5"></label>' +
      '<label>Easing' +
      '<select id="cp-easing">' +
      '<option value="ease-out">ease-out (gentle)</option>' +
      '<option value="ease-out-quart" selected>ease-out-quart (recommended)</option>' +
      '<option value="ease-out-expo">ease-out-expo (snappy)</option>' +
      '<option value="linear">linear</option>' +
      '</select></label>' +
      '<button id="cp-replay" type="button" class="btn" style="width:100%;margin-top:0.5rem;">Replay</button>' +
      '<button id="cp-close" type="button" style="width:100%;background:transparent;border:none;box-shadow:none;text-decoration:underline;color:inherit;margin-top:0.25rem;padding:0.4rem;font-size:0.8rem;cursor:pointer;">Dismiss</button>';
    document.body.appendChild(panel);

    var durSlider = document.getElementById('cp-duration');
    var durVal = document.getElementById('cp-dur-val');
    var startSlider = document.getElementById('cp-start');
    var startVal = document.getElementById('cp-start-val');
    var easingSelect = document.getElementById('cp-easing');

    durSlider.addEventListener('input', function() {
      durVal.textContent = this.value + 'ms';
    });
    startSlider.addEventListener('input', function() {
      startVal.textContent = this.value + '%';
    });

    document.getElementById('cp-replay').addEventListener('click', runCountUp);
    document.getElementById('cp-close').addEventListener('click', function() {
      panel.remove();
    });

    var easings = {
      'ease-out': function(t) { return 1 - Math.pow(1 - t, 2); },
      'ease-out-quart': function(t) { return 1 - Math.pow(1 - t, 4); },
      'ease-out-expo': function(t) { return t === 1 ? 1 : 1 - Math.pow(2, -10 * t); },
      'linear': function(t) { return t; }
    };

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

      var duration = parseInt(durSlider.value);
      var startPct = parseInt(startSlider.value) / 100;
      var easingFn = easings[easingSelect.value];
      var startTime = null;
      var parsed = originalValues.map(parseValue);

      function tick(time) {
        if (!startTime) startTime = time;
        var progress = Math.min((time - startTime) / duration, 1);
        var eased = easingFn(progress);

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
