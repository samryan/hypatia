<?php
/*
Template Name: /Project/

Include a hero image for projects. If the project has an image, move the headline above it.
*/
?>

<?php get_header(); ?>
<main id="main" role="main">
<?php if ( has_post_thumbnail() ) { ?>
<div>
  <div class="container">
    <?php the_title( '<h1 class="entry-title entry-title-project">', '</h1>' ); ?>
    <img src="<?php the_post_thumbnail_url('full'); ?>" />
  </div>
</div>
<?php } ?>
<div>
  <div class="container">
  	<?php
  		while ( have_posts() ) : the_post();
    ?>
      <?php if ( has_post_thumbnail() ) { } else { ?>
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
      <?php } ?>
      <div class="entry-content">
        <?php
          the_content();
        ?>
        </div>
    <?php
  		endwhile; // End of the loop.
  	?>
  </div>
</div>
</main>
<?php
get_footer();
