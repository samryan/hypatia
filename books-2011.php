<?php
/*
Template Name: List 2011

Page template for the 2011 books. Includes custom DB query to get books read in 2011.
*/
?>

<?php get_header(); ?>

<section>
  <div class="container">
    <?php
      while ( have_posts() ) : the_post();
    ?>
      <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
      <div class="entry-content">
        <?php
          the_content();
        ?>
        </div>
    <?php
      endwhile; // End of the loop.
    ?>
  </div>
  <div class="container books">
    <div class="list">
    <?php
      $args = array(
        'posts_per_page' => -1,
        'post_type' => 'books',
        'post_status' => 'publish',
        'tag' => 'list-2011'
      );
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
</section>

<?php
get_footer();
