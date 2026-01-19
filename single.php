<?php get_header(); ?>

<main id="main" role="main">
<div>
  <div class="container">
    <?php
    while ( have_posts() ) : the_post();
    	get_template_part( 'template-parts/content', get_post_format() );
    	the_post_navigation();
    endwhile;
    ?>
  </div>
</div>
</main>
<?php
get_footer();
