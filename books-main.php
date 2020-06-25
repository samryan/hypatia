<?php
/*
Template Name: /Books/

Page template for the main books page. Includes custom DB query to get favorites.
*/
?>

<?php get_header(); ?>

  <section>
    <div class="container"><?php
  		while ( have_posts() ) : the_post();
    ?>
      <?php if ( has_post_thumbnail() ) { } else { ?>
        <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
      <?php } ?>
      <div class="entry-content">
        <?php
          the_content();
        ?>
        </div>
    <?php
  		endwhile; // End of the loop.
  	?>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="books" id="books-recent">
        <h3><b>Recently finished</b></h3>
        <div class="list">
        <?php
          $args = array( 'posts_per_page' => 6, 'post_type' => 'books' );
          $myposts = get_posts( $args );
          foreach ( $myposts as $post ) : setup_postdata( $post );
        ?>
          <a href="<?php the_permalink(); ?>">
            <div class="cover">
              <div class="book-spine"></div>
              <img src="<?php the_post_thumbnail_url('full'); ?>" class="book" alt="" />
            </div>
            <div class="metadata">
              <div class="title"><?php the_title() ?></div>
              <div class="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></div>
              <div class="rating"><?php echo get_post_meta($post->ID, 'rating', true); ?></div>
            </div>
          </a>
        <?php
          endforeach;
          wp_reset_postdata();
        ?>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="books" id="books-favorites">
        <h3><b>Favorites</b></h3>
        <p>These are some books that I would recommend to most people, or that made an impact on how I think about the world:</p>
        <?php
          $args = array(
            'post_type' => 'books',
            'tag' => 'favorite',
            'posts_per_page' => -1
          );
          $the_query = new WP_Query($args);
        ?>
        <div class="list">
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <?php if (has_post_thumbnail()) :?>
          <a href="<?php the_permalink(); ?>">
            <div class="cover">
              <div class="book-spine"></div>
              <img src="<?php the_post_thumbnail_url('full'); ?>" class="book" alt="" />
            </div>
            <div class="metadata">
              <div class="title"><?php the_title() ?></div>
              <div class="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></div>
            </div>
          </a>
        <?php endif; endwhile; ?>
        <?php wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
  </section>
<?php
get_footer();
