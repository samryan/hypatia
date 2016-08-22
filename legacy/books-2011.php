<?php
/*
Template Name: List 2011

Page template for the 2011 books. Includes custom DB query to get books read in 2011.
*/
?>

<?php get_header(); ?>

<section id="primary" class="site-content">
    <div id="content" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

			<div class="entry-content">
				<?php
				   $args = array(
				      'post_type' => 'books',
				      'post_status' => 'publish',
				      'tag' => 'list-2011',
				      'posts_per_page' => -1
				   );
				   $the_query = new WP_Query($args);
				?>

              <div id="books_grid">
<?php while ( $the_query->have_posts() ) :
              $the_query->the_post(); ?>

              <?php
              if (has_post_thumbnail()) :?>
        		<div class="book">
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
        		</div>

              <?php endif; endwhile; ?>
              </div>
<?php wp_reset_postdata(); ?>
			</div>
    </div>
</section>

<?php get_footer(); ?>
