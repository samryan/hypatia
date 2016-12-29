<?php get_header(); ?>
<div id="primary" class="content-area">
  <section class="home intro">
    <h1>Hi!</h1>
    <h3>I&rsquo;m a user experience designer from Seattle. I like thinking about screens, history, and the future.</h3>
    <p>I studied history at UC Berkeley, and then Information Management at the University of Washington iSchool.</p>
    <p>I write here pretty infrequently, but when I get something stuck in my head, it&rsquo;s nice to have a blog. Whenever I have time, I read books, and that list gets updated a lot more often than the rest of the site.</p>
  </section>
  <section class="home projects-list">
    <header>
      <h3>Projects</h3>
    </header>
    <p>I work on Amazon&rsquo;s display advertising UX team, trying to make web and mobile ads more interesting and better for customers. Some of my recent projects include:</p>
    <ul>
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
    <li class="project">
      <a href="<?php the_permalink(); ?>">
        <img src="<?php the_post_thumbnail_url('full'); ?>" />
        <?php the_title(); ?>
      </a>
    </li>
    <?php
      }
    ?>
    <?php
      endwhile; endif;
      wp_reset_postdata();
    ?>
  </ul>
  </section>
  <section class="home books">
    <header>
      <h3>Recently finished books</h3>
    </header>
    <?php
      $args = array( 'posts_per_page' => 12, 'post_type' => 'books' );
      $myposts = get_posts( $args );
      foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
      <a href="<?php the_permalink(); ?>">
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
