    <footer id="colophon" class="site-footer">
      <div class="site-info container">
        <p><small class="smallcaps">Content by Sam Ryan, 2007&ndash;<?php echo date('Y'); ?></small></p>
        <p><small class="smallcaps" title="”To read well is to conquer the ages”&#013;– Isaac Flagg&#013;UC Berkeley library motto" style="cursor: help;" lang="la">Bene legere saecla vincere</small></p>
      </div>
    </footer>
  </div>
</div>
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
    }, false
  );
</script>
</body>
</html>
