<?php get_header(); ?>
	<section id="primary" class="content-area">
    <div class="container">
  		<?php
  		if ( have_posts() ) : ?>
  			<h3><?php printf( esc_html__( 'Search Results for &ldquo;%s&rdquo;' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
  			<?php while ( have_posts() ) : the_post();
  				get_template_part( 'template-parts/content', 'search' );
  			endwhile;
  			the_posts_navigation();
  		else :
  			get_template_part( 'template-parts/content', 'none' );
  		endif; ?>
    </div>
	</section>
<?php
get_footer();
