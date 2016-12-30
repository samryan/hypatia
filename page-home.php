<?php get_header(); ?>
  <section class="home intro bg-gray">
    <div class="container">
      <h1>Hi!</h1>
      <h3>I&rsquo;m a user experience designer from Seattle.</h3>
      <p> I like thinking about screens, history, and the future. I have an undergrad degree in history from UC Berkeley, and a Master&rsquo;s in Information Management from the University of Washington iSchool.</p>
      <p>I don&rsquo;t write here very often, but when I get something stuck in my head, it&rsquo;s nice to have <a href="/blog">a blog</a>.</p>
    </div>
  </section>
  <section class="home projects-list bg-green">
    <div class="container">
      <h3 class="clear">Projects</h3>
      <p class="clear">I work on Amazon&rsquo;s display advertising UX team, trying to make web and mobile ads more interesting and better for customers. Some of my recent projects include:</p>

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
        <a class="project" href="<?php the_permalink(); ?>">
          <?php /* <img src="<?php the_post_thumbnail_url('full'); ?>" /> */ ?>
          <?php the_title(); ?>
        </a>
      <?php } ?>
      <?php
        endwhile; endif;
        wp_reset_postdata();
      ?>
    </div>
  </section>
  <section class="home books bg-gray">
    <div class="container">
      <h3 class="clear">Reading list</h3>
      <p>Since 2009, I&rsquo;ve been keeping a list of all the books I read, and occasionally posting highlights, short reviews, and summaries of them. Here&rsquo;s <a href="/books/list-<?php echo date('Y'); ?>">this year&rsquo;s list</a>. Here&rsquo;s <a href="/books">the overview page</a>.</p>
      <p>These are the last six books I finished:</p>
      <div class="list">
        <?php
          $args = array( 'posts_per_page' => 6, 'post_type' => 'books' );
          $myposts = get_posts( $args );
          foreach ( $myposts as $post ) : setup_postdata( $post );
        ?>
          <a href="<?php the_permalink(); ?>">
            <img src="<?php the_post_thumbnail_url('full'); ?>" />
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
      </div>
    </div>
  </section>
<?php
get_footer();
