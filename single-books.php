<?php get_header(); ?>
<main id="main" role="main">
	<div id="primary" class="content-area">
		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content-books', get_post_format() );
    ?>
    <?php
		  endwhile;
		?>
	</div>
</main>
<?php
get_footer();
