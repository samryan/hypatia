<?php
/*
Template Name: Projects
Description: Template for displaying a list of projects
*/

get_header(); ?>

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
      'posts_per_page' => 50,
      'post_status' => 'publish',
      'orderby' => 'menu_order',
      'order' => 'ASC'
    );

    $projects = get_posts($args);
    $project_index = 0;

    foreach ($projects as $post) : setup_postdata($post);
      $project_index++;
      $thumb_url = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : '';
      $thumb_alt = has_post_thumbnail() ? get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) : '';
  ?>
    <div class="project-section">
      <div class="container">
        <div class="project-content">
          <?php if ( $thumb_url ) : ?>
            <div class="project-image">
              <a href="<?php echo esc_url( $thumb_url ); ?>" class="lightbox" data-group="projects">
                <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $thumb_alt ); ?>"<?php echo $project_index === 1 ? ' fetchpriority="high"' : ' loading="lazy"'; ?> />
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

<?php get_footer(); ?>
