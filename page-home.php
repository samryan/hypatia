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
          <section class="home projects">
            <h3>Projects</h3>
          </section>
          <section class="home books">
            <h3>Recently read</h3>
            <ul>
            <?php
              $args = array( 'posts_per_page' => 5, 'post_type' => 'books' );
              $myposts = get_posts( $args );
              foreach ( $myposts as $post ) : setup_postdata( $post ); ?>

              <li class="book_cover">
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail(); ?><br>
                  <span class="title"><?php the_title() ?></span>
                  <span class="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></span>
                </a>
              </li>
            <?php endforeach;
            wp_reset_postdata();?>
            </ul>
          </section>
        </main>
      </div>

<?php
get_footer();