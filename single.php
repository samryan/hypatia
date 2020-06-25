<?php get_header(); ?>

<section>
  <div class="container">
    <h5>Blog post:</h5>
    <?php
    while ( have_posts() ) : the_post();
    	get_template_part( 'template-parts/content', get_post_format() );
    	the_post_navigation();
    endwhile;
    ?>
  </div>
</section>
<?php
get_footer();
