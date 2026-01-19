<?php get_header(); ?>
<main id="main" role="main">
	<div id="primary" class="content-area">
    <div class="container">
  		<?php
  		if ( have_posts() ) : ?>
  			<h1><?php printf( esc_html__( 'Search Results for &ldquo;%s&rdquo;' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
  			<?php while ( have_posts() ) : the_post();
  				get_template_part( 'template-parts/content', 'search' );
  			endwhile;
  			the_posts_navigation();
  		else :
  			get_template_part( 'template-parts/content', 'none' );
  		endif; ?>
    </div>
	</div>
</main>
<?php
get_footer();
