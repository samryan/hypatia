<?php get_header(); ?>
	<div id="primary" class="content-area">
		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content', get_post_format() );
			the_post_navigation();
		endwhile; 
		?>
	</div>
<?php
get_footer();