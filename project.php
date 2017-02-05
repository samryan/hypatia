<?php
/*
Template Name: /Project/

Include a hero image for projects.
*/
?>

<?php get_header(); ?>
<?php if ( has_post_thumbnail() ) { ?>
<section class="bg-grade">
  <div class="container">
    <img src="<?php the_post_thumbnail_url('full'); ?>" />
  </div>
</section>
<?php } ?>
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
</section>
<?php
get_footer();
