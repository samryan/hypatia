<?php
/*
Template Name: All books

Page template for a list of all books in the DB
*/
?>

<?php get_header(); ?>

<section>
  <div class="container">
    <?php
      wp_nav_menu(
        array(
          'theme_location' => 'books-menu',
          'container_class' => 'books-menu'
        )
      );
    ?>
  </div>
</section>

<section class="bg-default">
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
        <li style="border-bottom: 1px dotted #999; margin-bottom: 0.5rem; padding-bottom: 0.5rem;">
          <div>
            <div>
              <a href="<?php the_permalink() ?>">
              <?php the_title() ?>
              </a>
            </div>
            <div>
            <?php echo get_post_meta($post->ID, 'book_author', true); ?>
            </div>
            <div style="opacity: 0.7;">
            <span style="font-size: 90%;"><?php echo get_post_meta($post->ID, 'rating', true); ?>
            - 
            <?php if ( get_post_meta($post->ID, 'date_read', true) ) : ?>
              <?php echo date('M j, Y', strtotime(get_post_meta($post->ID, 'date_read', true))); ?>
            <?php else: ?>
              <?php echo get_post_meta($post->ID, 'year_read', true); ?>
            <?php endif; ?>
            </span>
            </div>
          </div>
        </li>
      <?php
        endforeach;
        wp_reset_postdata();
      ?>  
    </ol>
  </div>
</section>

<?php
get_footer();
