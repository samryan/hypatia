<?php get_header(); ?>
<div id="primary" class="content-area">
  <h3>Recent projects</h3>
  <section class="home projects">
    <?php
      global $post;
      $projects_query_args = array(
        'post_type'   => 'page',
        'post_parent' => '193',
        'orderby'     => 'post_name',
        'order'        => 'ASC'
      );
      $projects = new WP_Query( $projects_query_args );
      if ( $projects->have_posts() ) : while ( $projects->have_posts() ) : $projects->the_post();
      if ( has_post_thumbnail () ) {
    ?>
    <a href="<?php the_permalink(); ?>" class="project">
      <img src="<?php the_post_thumbnail_url('full'); ?>" />
      <span class="metadata">
        <?php the_title(); ?>
      </span>
    </a>
    <?php
      }
    ?>
    <?php
      endwhile; endif;
      wp_reset_postdata();
    ?>
  </section>
  <h3>Recently finished books</h3>
  <section class="home books">
    <?php
      $args = array( 'posts_per_page' => 15, 'post_type' => 'books' );
      $myposts = get_posts( $args );
      foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
      <a href="<?php the_permalink(); ?>" class="book-cover">
        <div class="metadata">
          <div class="title"><?php the_title() ?></div>
          <div class="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></div>
          <div class="rating"><?php echo get_post_meta($post->ID, 'rating', true); ?></div>
        </div>
      </a>
    <?php
      endforeach;
      wp_reset_postdata();
    ?>
  </section>
</div>
<?php
get_footer();
