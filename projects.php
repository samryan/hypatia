<?php
/*
Template Name: Projects
Description: Template for displaying a list of projects
*/

get_header(); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@midzer/tobii@2.5.0/dist/tobii.min.css">

<main id="main" role="main">
<div>
  <div class="container">
    <?php
      while ( have_posts() ) : the_post();
    ?>
      <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
      <div class="entry-content">
        <?php
          the_content();
        ?>
      </div>
    <?php
      endwhile;
    ?>
  </div>
</div>

<div class="projects">
  <?php
    $args = array(
      'post_type' => 'projects',
      'posts_per_page' => -1,
      'post_status' => 'publish',
      'orderby' => 'menu_order',
      'order' => 'ASC'
    );

    $projects = get_posts($args);

    foreach ($projects as $post) : setup_postdata($post);
  ?>
    <div class="project-section">
      <div class="container">
        <div class="project-content">
          <?php if (has_post_thumbnail()) : ?>
            <div class="project-image">
              <a href="<?php the_post_thumbnail_url('full'); ?>" class="lightbox" data-group="projects">
                <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" />
              </a>
            </div>
          <?php endif; ?>

          <div class="project-details">
            <h2><?php the_title(); ?></h2>
            <?php the_excerpt(); ?>
            <a href="<?php the_permalink(); ?>" class="project-link">Read more about <?php the_title(); ?></a>
          </div>
        </div>
      </div>
    </div>
  <?php
    endforeach;
    wp_reset_postdata();
  ?>
</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/@midzer/tobii@2.5.0/dist/tobii.min.js"></script>
<script>
  const tobii = new Tobii({
    selector: '.lightbox',
    zoom: true,
    counter: false,
    nav: false,
    swipe: false
  });
</script>

<?php get_footer(); ?>
