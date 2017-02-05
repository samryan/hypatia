<?php
/*
Template Name: /Books/

Page template for the main books page. Includes custom DB query to get favorites.
*/
?>

<?php get_header(); ?>

  <section class="bg-default">
    <div class="container">
      <h2 class="entry-title">Reading</h2>
      <p>Since 2009, I’ve been keeping a list of all the books I read, and occasionally posting highlights, short reviews, and summaries of them.</p>
      <hr>
      <div id="books-years">
        <h3><b>Yearly lists</b></h3>
        <ul>
          <li><a href="/books/list-2017">Books Read in 2017</a> (work in progress)</li>
          <li><a href="/books/list-2016">Books Read in 2016</a> (47)</li>
          <li><a href="/books/list-2015">Books Read in 2015</a> (86)</li>
          <li><a href="/books/list-2014">Books Read in 2014</a> (52)</li>
          <li><a href="/books/list-2013">Books Read in 2013</a> (67)</li>
          <li><a href="/books/list-2012">Books Read in 2012</a> (66)</li>
          <li><a href="/books/list-2011">Books Read in 2011</a> (79)</li>
          <li><a href="/books/list-2010">Books Read in 2010</a> (131)</li>
          <li><a href="/books/list-2009">Books Read in 2009</a> (101)</li>
        </ul>
      </div>
      <hr>
      <div class="books" id="books-recent">
        <h3><b>Recently finished</b></h3>
        <div class="list">
        <?php
          $args = array( 'posts_per_page' => 6, 'post_type' => 'books' );
          $myposts = get_posts( $args );
          foreach ( $myposts as $post ) : setup_postdata( $post );
        ?>
          <a href="<?php the_permalink(); ?>">
            <!--<img src="<?php the_post_thumbnail_url('full'); ?>" />-->
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
      <hr>
      <div class="books" id="books-favorites">
        <h3><b>Favorites</b></h3>
        <p>Some books that I would recommend to most people, or that made an impact on how I think about the world:</p>
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
            <img src="<?php the_post_thumbnail_url('full'); ?>" width="100" />
            <div class="title"><?php the_title() ?></div>
            <div class="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></div>
          </a>
        <?php endif; endwhile; ?>
        <?php wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
  </section>
<?php
get_footer();
