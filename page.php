<?php get_header(); ?>
<main id="main" role="main">
  <div>
    <div class="container">
      <?php if ( has_post_thumbnail() ) { ?>
        <img src="<?php the_post_thumbnail_url('full'); ?>" />
      <?php } ?>
    	<?php
    		while ( have_posts() ) : the_post();
      ?>
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        <div class="entry-content">
          <?php
            the_content();
          ?>
          </div>
      <?php
    		endwhile; // End of the loop.
    	?>
    </div>
  </div>
</main>
<?php
get_footer();
