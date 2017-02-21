<?php get_header(); ?>
  <section class="home intro bg-default">
    <div class="container">
      <h1>Hello!</h1>
      <h3>I&rsquo;m a user experience designer from Seattle.</h3>
      <p> I like thinking about screens, history, and the future. I have an undergrad degree in history from UC Berkeley, and a Master&rsquo;s in Information Management from the University of Washington iSchool.</p>
    </div>
  </section>
  <section class="home projects-list bg-green">
    <div class="container">
      <h2 class="clear">Projects</h2>
      <p class="clear">I work for Amazon&rsquo;s <a href="https://www.amazon.jobs/axt">Advertising Experience &amp; Technology</a> group, making our ad business more interesting and better for customers. Some of my projects at Amazon include:</p>
      <a class="project" href="/projects/ad-landing-pages">
        <b>Ad Landing Pages</b>
        <br>
        <span>An internal tool for Amazon designers to make landing pages without writing any code.</span>
      </a>
      <a class="project" href="/projects/advertise-your-app">
        <b>Advertise Your App</b>
        <br>
        <span>Do-it-yourself ad campaigns for app developers. Featured in TechCrunch!</span>
      </a>
      <a class="project" href="/projects/amazon-mobile-ad-placements">
        <b>Amazon Mobile ad placements</b>
        <br>
        <span>Scaling a worldwide ads business as our customers migrate to mobile shopping.</span>
      </a>
      <a class="project" href="/projects/mobile-add-to-cart">
        <b>Mobile Add to Cart ad format</b>
        <br>
        <span>A new eCommerce-enabled ad format, unique to Amazon.</span>
      </a>
      <a class="project" href="/projects/mobile-interstitial-ads">
        <b>Mobile interstitial ad format</b>
        <br>
        <span>Iterative design and development of a full screen ad format for third-party apps.</span>
      </a>
      <a class="project" href="/projects/fit-ratings">
        <b>Fit ratings (internship project)</b>
        <br>
        <span>A detail page feature that helps you pick the right size for clothes.</span>
      </a>
    </div>
  </section>
  <section class="home books bg-default">
    <div class="container">
      <h2 class="clear">Reading</h2>
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
  <section class="home blog-list bg-gray">
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
<?php
get_footer();
