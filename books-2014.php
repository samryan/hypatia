<?php
/*
Template Name: List 2014

Page template for the 2014 books. Includes custom DB query to get books read in 2014.
*/
?>

<?php get_header(); ?>

<main id="main" role="main">
  <div class="container">
    <?php while ( have_posts() ) : the_post(); ?>
      <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    <?php endwhile; ?>
  </div>
  <div class="container">
    <?php hypatia_books_nav(); ?>
  </div>
  <?php while ( have_posts() ) : the_post(); ?>
    <div class="container">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </div>
  <?php endwhile; ?>
  <div class="container books">
    <div class="list">
    <?php
      $args = array(
        'posts_per_page' => -1,
        'post_type' => 'books',
        'post_status' => 'publish',
        'tag' => 'list-2014'
      );
      $myposts = get_posts( $args );
      foreach ( $myposts as $post ) : setup_postdata( $post );
    ?>
      <a href="<?php the_permalink(); ?>">
        <div class="cover">
          <div class="book-spine"></div>
          <img src="<?php the_post_thumbnail_url('full'); ?>" class="book" alt="" loading="lazy" />
        </div>
        <div class="metadata">
          <div class="title"><?php the_title() ?></div>
          <div class="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></div>
          <?php echo hypatia_book_rating(); ?>
        </div>
      </a>
    <?php
      endforeach;
      wp_reset_postdata();
    ?>
    </div>
  </div>
</div>
</main>

<?php
get_footer();
