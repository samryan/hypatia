<?php get_header(); ?>
	<div id="primary" class="content-area">
    <section class="bg-default">
      <div class="container">
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
    </section>
	</div>
<?php
get_footer();
