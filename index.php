<?php get_header(); ?>
<main id="main" role="main">
	<div id="primary" class="content-area">
    <div>
      <div class="container">
        <h1 class="sr-only">Blog</h1>
    		<?php
    		if ( have_posts() ) :
    			while ( have_posts() ) : the_post();
    				get_template_part( 'template-parts/content', get_post_format() );
    			endwhile;
    			the_posts_navigation();
    		else :
    			get_template_part( 'template-parts/content', 'none' );
    		endif; ?>
      </div>
    </div>
	</div>
</main>
<?php
get_footer();
