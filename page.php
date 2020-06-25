<?php get_header(); ?>
  <section>
    <div class="container">
      <?php if ( has_post_thumbnail() ) { ?>
        <img src="<?php the_post_thumbnail_url('full'); ?>" />
      <?php } ?>
    	<?php
    		while ( have_posts() ) : the_post();
      ?>
        <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
        <div class="entry-content">
          <?php
            the_content();
          ?>
          </div>
      <?php
    		endwhile; // End of the loop.
    	?>
    </div>
  </section>
<?php
get_footer();
