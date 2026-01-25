    <footer id="colophon" class="site-footer">
      <div class="site-info container">
        <?php /*
          <p><small class="smallcaps">Content by Sam Ryan, 2007&ndash;<?php echo date('Y'); ?></small></p>
        */ ?>
        <p><small class="smallcaps" title="”To read well is to conquer the ages”&#013;– Isaac Flagg&#013;UC Berkeley library motto" style="cursor: help;" lang="la">Bene legere saecla vincere</small></p>
      </div>
    </footer>
  </div>
</div>
<?php get_template_part('template-parts/search-modal'); ?>
<?php wp_footer(); ?>
<?php if (is_single()) : ?>
  <?php if (has_post_thumbnail()) :?>
    <script src="<?php echo get_theme_file_uri(); ?>/grade.min.js"></script>
    <script type="text/javascript">
      window.addEventListener('load', function(){ Grade(document.querySelectorAll('.gradient-wrap')) });
    </script>
  <?php endif; ?>
<?php endif; ?>
<script type="text/javascript">
  var a = false;
  document.querySelector('#toggle-menu').addEventListener('click', function (e) {
    e.preventDefault();
    a = !a;
    document.querySelector('#toggle-menu').setAttribute('aria-expanded', a);
    document.querySelector('#site-navigation ul').classList.toggle('visible');
  }, false);

  document.querySelector('#toggle-theme').addEventListener('click', function (e) {
    e.preventDefault();
    var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    if (isDark) {
      document.documentElement.removeAttribute('data-theme');
      localStorage.setItem('theme', 'light');
    } else {
      document.documentElement.setAttribute('data-theme', 'dark');
      localStorage.setItem('theme', 'dark');
    }
  }, false);

  // Format ordered list numbers with thousands separators
  (function() {
    var bookLists = document.querySelectorAll('ol:has(.book-list-item)');
    bookLists.forEach(function(ol) {
      var items = ol.querySelectorAll('.book-list-item');
      var isReversed = ol.hasAttribute('reversed');
      var start = parseInt(ol.getAttribute('start')) || (isReversed ? items.length : 1);
      
      items.forEach(function(item, index) {
        var number;
        if (isReversed) {
          number = start - index;
        } else {
          number = start + index;
        }
        // Format number with thousands separators
        var formatted = number.toLocaleString('en-US');
        item.setAttribute('data-number', formatted);
      });
    });
  })();
</script>
</body>
</html>
