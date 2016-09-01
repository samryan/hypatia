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
        </main>
      </div>

<script src="js/grade.js"></script>
<script type="text/javascript">
    window.addEventListener('load', function(){
        /*
            A NodeList of all your image containers (Or a single Node).
            The library will locate an <img /> within each
            container to create the gradient from.
         */
        Grade(document.querySelectorAll('.gradient-wrap'))
    })
</script>

  <?php
  get_sidebar();
  get_footer();
