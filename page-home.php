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
          <?php
            while ( have_posts() ) : the_post();
              get_template_part( 'template-parts/content', 'page' );
            endwhile; // End of the loop.
          ?>
  
<div class="gradient-wrap break-padding" style="width: auto; padding: 1rem; text-align: center;">
  <img src="http://vagrantpress.dev/wp-content/uploads/The-Rider.jpg" style="width:200px; display: block; margin: 0 auto;" />
</div>

<ul>
<?php
	$args = array( 'posts_per_page' => 2, 'post_type' => 'books' );
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>

  <li class="book_cover">
    <a href="<?php the_permalink(); ?>">
      <?php the_post_thumbnail(); ?><br>
      <span><?php echo get_post_meta($post->ID, 'book_author', true); ?></span>
    </a>
  </li>

<?php endforeach;
wp_reset_postdata();?>
</ul>



        </main>
      </div>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/grade.js"></script>
<script type="text/javascript">
  window.addEventListener('load', function(){
      Grade(document.querySelectorAll('.gradient-wrap'));
  });
</script>

  <?php
  get_sidebar();
  get_footer();
