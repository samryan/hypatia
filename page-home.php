<?php get_header(); ?>
  <section class="home intro">
    <div class="container">
      <?php while(have_posts()) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
    </div>
  </section>
  <section class="home books">
    <div class="container">
      <h2>Reading list</h2>
      <p>Since 2009, I&rsquo;ve been keeping a list of all the books I read, and occasionally posting highlights, short reviews, and summaries of them. Here&rsquo;s <a href="/books/list-<?php echo date('Y'); ?>">this year&rsquo;s list</a>. Here&rsquo;s <a href="/books">the overview page</a>.</p>
      <p>These are the last six books I finished:</p>
      <div class="list">
        <?php
          $args = array( 'posts_per_page' => 6, 'post_type' => 'books' );
          $myposts = get_posts( $args );
          foreach ( $myposts as $post ) : setup_postdata( $post );
        ?>
          <a href="<?php the_permalink(); ?>">
            <div class="cover">
              <div class="book-spine"></div>
              <img src="<?php the_post_thumbnail_url('full'); ?>" class="book" alt="" />
            </div>
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
  <?php /*
  <section class="home blog-list">
    <div class="container">
      <h2 class="clear">Blog posts</h2>
      <p>I don&rsquo;t write here very often, but when I get something stuck in my head, it&rsquo;s nice to have <a href="/blog">a blog</a>!</p>
      <table>
      <?php
        $blogPosts = new WP_Query();
        $blogPosts->query('showposts=-1&cat=CAT_ID_GOES_HERE');
        while($blogPosts->have_posts()): $blogPosts->the_post();
      ?>
        <tr>
          <td valign="top">
            <span><?php the_date('m/Y'); ?></span>
          </td>
          <td>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          </td>
        </tr>
      <?php endwhile; ?>
      </table>
    </div>
  </section>
  */ ?>
<?php
get_footer();
