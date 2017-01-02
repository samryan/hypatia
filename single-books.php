<?php get_header(); ?>
	<div id="primary" class="content-area">
		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content-books', get_post_format() );
    ?>
    <?php
		  endwhile;
		?>
	</div>
<?php
get_footer();
