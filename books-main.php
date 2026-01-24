<?php
/*
Template Name: /Books/

Page template for the main books page. Includes custom DB query to get favorites.
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
    <div class="books" id="books-recent">
      <h2>Recently finished:</h2>
      <div class="list">
      <?php
        $args = array( 'posts_per_page' => 3, 'post_type' => 'books' );
        $myposts = get_posts( $args );
        foreach ( $myposts as $post ) : setup_postdata( $post );
          echo hypatia_book_card($post->ID, 'grid');
        endforeach;
        wp_reset_postdata();
      ?>
      </div>
    </div>
    <?php
      // Add a link to the list for the current year: "This year's list"
      $current_year = date('Y');
    ?>
    <div class="books-year-link">
      <a href="/books/list-<?php echo $current_year; ?>">This year's list &rarr;</a>
    </div>
  </div>
  <div class="container" style="margin-top: 6rem;">
    <div class="books" id="books-favorites">
      <h2>Favorites:</h2>
      <p>These are some books that I&rsquo;d recommend to most people, or that made an impact on how I think about the world:</p>
      <?php
        $args = array(
          'post_type' => 'books',
          'tag' => 'favorite',
          'posts_per_page' => -1
        );
        $the_query = new WP_Query($args);
      ?>
      <div class="book-card-list book-card-list--mini">
      <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <?php if (has_post_thumbnail()) : ?>
          <?php echo hypatia_book_card($post->ID, 'mini', ['show_rating' => false]); ?>
        <?php endif; endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </div>
    </div>
  </div>
</main>
<?php
get_footer();
