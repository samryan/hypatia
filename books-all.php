<?php
/*
Template Name: All books

Page template for a list of all books in the DB
*/
?>

<?php get_header(); ?>

<main id="main" role="main">
<div>
  <div class="container">
    <?php hypatia_books_nav(); ?>
  </div>
</div>

<div class="bg-default">
  <div class="container">
    <?php
      while ( have_posts() ) : the_post();
    ?>
      <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
      <div class="entry-content">
        <?php
          the_content();
        ?>
        </div>
    <?php
      endwhile; // End of the loop.
    ?>
  </div>
  <div class="container">
    <ol reversed style="padding: 0; margin-left: 3rem;">
      <?php
        $args = array(
          'posts_per_page' => -1,
          'post_type' => 'books',
          'post_status' => 'publish'
        );
        $myposts = get_posts( $args );
        foreach ( $myposts as $post ) : setup_postdata( $post );
      ?>
        <li class="book-list-item">
          <div>
            <div class="book-title">
              <a href="<?php the_permalink() ?>">
              <?php the_title() ?>
              </a>
            </div>
            <div class="book-author">
            <?php echo get_post_meta($post->ID, 'book_author', true); ?>
            </div>
            <div class="book-meta">
            <?php echo hypatia_rating_to_stars(get_post_meta($post->ID, 'rating', true)); ?>
            <?php if (have_rows('book_quotes', $post->ID)) : ?>
              <svg class="highlights-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" aria-label="Has highlights"><path d="M160,56H64A16,16,0,0,0,48,72V224a8,8,0,0,0,12.65,6.51L112,193.83l51.36,36.68A8,8,0,0,0,176,224V72A16,16,0,0,0,160,56Zm0,152.46-43.36-31a8,8,0,0,0-9.3,0L64,208.45V72h96ZM208,40V192a8,8,0,0,1-16,0V40H88a8,8,0,0,1,0-16H192A16,16,0,0,1,208,40Z"/></svg>
            <?php endif; ?>
            -
            <?php if ( get_post_meta($post->ID, 'date_read', true) ) : ?>
              <?php echo date('M j, Y', strtotime(get_post_meta($post->ID, 'date_read', true))); ?>
            <?php else: ?>
              <?php echo get_post_meta($post->ID, 'year_read', true); ?>
            <?php endif; ?>
            </div>
          </div>
        </li>
      <?php
        endforeach;
        wp_reset_postdata();
      ?>  
    </ol>
  </div>
</div>
</main>

<?php
get_footer();
