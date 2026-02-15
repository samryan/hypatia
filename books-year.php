<?php
/*
Template Name: Books Year

Page template for yearly book lists. Extracts year from page slug (e.g., "books-2025" -> 2025).
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
      $slug = get_post_field('post_name', get_the_ID());
      $year = str_replace('list-', '', $slug);

      $args = array(
        'posts_per_page' => 500,
        'post_type' => 'books',
        'post_status' => 'publish',
        'tag' => 'list-' . $year
      );
      $myposts = get_posts( $args );
      if ( ! empty( $myposts ) ) {
        update_meta_cache( 'post', wp_list_pluck( $myposts, 'ID' ) );
      }
      $book_index = 0;
      foreach ( $myposts as $post ) : setup_postdata( $post );
        $is_above_fold = $book_index < 3;
        $book_index++;
    ?>
      <a href="<?php the_permalink(); ?>">
        <div class="cover">
          <div class="book-spine"></div>
          <img src="<?php the_post_thumbnail_url('full'); ?>" class="book" alt="" width="140" height="210"<?php echo $is_above_fold ? ' fetchpriority="high"' : ' loading="lazy"'; ?> data-book-id="<?php echo $post->ID; ?>" />
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
