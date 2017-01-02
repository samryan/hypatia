<?php
/*
Template Name: /Books/

Page template for the main books page. Includes custom DB query to get favorites.
*/
?>

<?php get_header(); ?>

  <section class="bg-default">
    <div class="container">
      <h2><b>Reading</b></h2>
      <p>Since 2009, I’ve been keeping a list of all the books I read, and occasionally posting highlights, short reviews, and summaries of them.</p>
      <div id="books-favorites">
        <h3><b>Favorites</b></h3>
        <p>Books that I would recommend to most people, or that made an impact on how I think about the world.</p>
        <?php
          $args = array(
            'post_type' => 'books',
            'tag' => 'favorite',
            'orderby' => 'rand',
            'posts_per_page' => -1
          );
          $the_query = new WP_Query($args);
        ?>
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <?php if (has_post_thumbnail()) :?>
          <img src="<?php the_post_thumbnail_url('full'); ?>" width="100" />
          <div class="title"><?php the_title() ?></div>
          <div class="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></div>

        <?php endif; endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </div>
      <div id="books-years">
        <h3><b>Yearly lists</b></h3>
      </div>
      <div id="books-recent">
        <h3><b>Recently finished</b></h3>
        <ul>
        <?php
          $args = array( 'posts_per_page' => 6, 'post_type' => 'books' );
          $myposts = get_posts( $args );
          foreach ( $myposts as $post ) : setup_postdata( $post );
        ?>
        <li>
          <a href="<?php the_permalink(); ?>">
            <!--<img src="<?php the_post_thumbnail_url('full'); ?>" />-->
            <div class="metadata">
              <div class="title"><?php the_title() ?></div>
              <div class="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></div>
              <div class="rating"><?php echo get_post_meta($post->ID, 'rating', true); ?></div>
            </div>
          </a>
        </li>
        <?php
          endforeach;
          wp_reset_postdata();
        ?>
        </ul>
      </div>
    </div>
  </section>
<?php
get_footer();
