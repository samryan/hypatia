<?php
/*
Template Name: /Project/

Include a hero image for projects. If the project has an image, move the headline above it.
*/
?>

<?php get_header(); ?>
<?php if ( has_post_thumbnail() ) { ?>
<section>
  <div class="container">
    <?php the_title( '<h2 class="entry-title entry-title-project">', '</h2>' ); ?>
    <img src="<?php the_post_thumbnail_url('full'); ?>" />
  </div>
</section>
<?php } ?>
<section>
  <div class="container">
  	<?php
  		while ( have_posts() ) : the_post();
    ?>
      <?php if ( has_post_thumbnail() ) { } else { ?>
        <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
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
</section>
<?php
get_footer();
