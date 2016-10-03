<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hypatia
 */

get_header(); ?>

      <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
          <section class="home intro">
          </section>
          <h3>Projects</h3>
          <section class="home projects">
          </section>
          <h3>Recently finished books</h3>
          <section class="home books">
            <?php
              $args = array( 'posts_per_page' => 15, 'post_type' => 'books' );
              $myposts = get_posts( $args );
              foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
              <a href="<?php the_permalink(); ?>" class="book-cover">
                <div class="img-container"><?php the_post_thumbnail(); ?></div>
                <div class="metadata">
                  <div class="title"><?php the_title() ?></div>
                  <div class="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></div>
                  <div class="rating"><?php echo get_post_meta($post->ID, 'rating', true); ?></div>
                </div>
              </a>
            <?php endforeach;
            wp_reset_postdata();?>
          </section>
        </main>
      </div>

<?php
get_footer();