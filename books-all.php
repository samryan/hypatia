<?php
/*
Template Name: All books

Page template for a list of all books in the DB
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
  
  <div class="container">
    <?php
      // Single list with high cap so numbering is correct (newest = total count) and no pagination.
      $args = array(
        'posts_per_page' => 3000,
        'post_type' => 'books',
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
      );
      $myposts = get_posts( $args );
      if ( ! empty( $myposts ) ) {
        update_meta_cache( 'post', wp_list_pluck( $myposts, 'ID' ) );
      }
    ?>
    <ol reversed class="book-list">
      <?php foreach ( $myposts as $post ) : setup_postdata( $post );
        $book_author = get_post_meta( $post->ID, 'book_author', true );
        $rating = get_post_meta( $post->ID, 'rating', true );
        $date_read = get_post_meta( $post->ID, 'date_read', true );
        $year_read = get_post_meta( $post->ID, 'year_read', true );
        $has_highlights = get_post_meta( $post->ID, '_has_book_quotes', true );
        if ( $has_highlights === '' && function_exists( 'have_rows' ) ) {
          $has_highlights = have_rows( 'book_quotes', $post->ID );
        } else {
          $has_highlights = ( $has_highlights === '1' );
        }
      ?>
        <li class="book-list-item">
          <div>
            <div class="book-title">
              <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
              </a>
            </div>
            <div class="book-author">
              <?php echo esc_html( $book_author ); ?>
            </div>
            <div class="book-meta">
              <?php echo hypatia_rating_to_stars( $rating ); ?>
              <?php if ( $has_highlights ) : ?>
                <svg class="highlights-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" aria-label="Has highlights"><path d="M160,56H64A16,16,0,0,0,48,72V224a8,8,0,0,0,12.65,6.51L112,193.83l51.36,36.68A8,8,0,0,0,176,224V72A16,16,0,0,0,160,56Zm0,152.46-43.36-31a8,8,0,0,0-9.3,0L64,208.45V72h96ZM208,40V192a8,8,0,0,1-16,0V40H88a8,8,0,0,1,0-16H192A16,16,0,0,1,208,40Z"/></svg>
              <?php endif; ?>
              <span class="date">
                <?php if ( $date_read ) : ?>
                  <?php echo esc_html( date( 'M j, Y', strtotime( $date_read ) ) ); ?>
                <?php else : ?>
                  <?php echo esc_html( $year_read ); ?>
                <?php endif; ?>
              </span>
            </div>
          </div>
        </li>
      <?php endforeach; wp_reset_postdata(); ?>
    </ol>
  </div>
</main>

<?php
get_footer();
