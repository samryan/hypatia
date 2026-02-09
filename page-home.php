<?php get_header(); ?>
<main id="main" role="main">
  <h1 class="sr-only">Sam Ryan - Home</h1>

  <div class="home intro">
    <div class="container">
      <figure class="home-photo">
        <img src="<?php echo get_template_directory_uri(); ?>/sam.jpg" width="" height="" alt="Sam Ryan" />
      </figure>
      <div>
        <?php while(have_posts()) : the_post(); ?>
          <?php the_content(); ?>
        <?php endwhile; ?>
      </div>
    </div>
  </div>

  <?php $uploads_url = content_url('/uploads'); ?>

  <!-- Projects section -->
  <div class="home projects">
    <div class="container">
      <h2 class="section-header">Recent work</h2>
      <div class="home-projects-list">
        <div class="home-project-row">
          <div class="home-project-image">
            <img src="<?php echo $uploads_url . '/kindle-scribes-2.jpg'; ?>" alt="" loading="lazy" />
          </div>
          <div class="home-project-info">
            <h3>Kindle design tools</h3>
            <p>Building the next generation of design tools for prototyping, visual design, and design reviews on e-ink devices.</p>
            <br />
            <p>2025&ndash;present</p>
          </div>
        </div>
        <div class="home-project-row">
          <div class="home-project-image storm">
            <img src="<?php echo $uploads_url . '/storm.png'; ?>" alt="" loading="lazy" />
          </div>
          <div class="home-project-info">
            <h3>Storm design system</h3>
            <p>Lead designer for Amazon Ads&rsquo; design system, supporting a $50B/year business across 900+ software projects. Built documentation, Figma libraries, and led adoption for the design org.</p>
            <br />
            <p>2019&ndash;2025</p>
          </div>
        </div>
      </div>
      <p class="home-projects-link"><a href="/projects" class="btn">More projects</a></p>
    </div>
  </div>

  <div class="home books">
    <div class="container">
      <h2 class="section-header">Reading list</h2>
      <p>I&rsquo;ve been keeping a list of all the books I read since 2009, with occasional highlights or short reviews.</p>
      <p><a href="/books" class="btn" style="margin-right: 1rem;">Books overview</a><a href="/books/list-<?php echo date('Y'); ?>" class="btn">This year&rsquo;s list</a></p>
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
              <img src="<?php the_post_thumbnail_url('full'); ?>" class="book" alt="" loading="lazy" />
            </div>
            <div class="metadata">
              <div class="title"><?php the_title() ?></div>
              <div class="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></div>
              <div class="rating"><?php echo hypatia_rating_to_stars(get_post_meta($post->ID, 'rating', true)); ?></div>
            </div>
          </a>
        <?php
          endforeach;
          wp_reset_postdata();
        ?>
      </div>
    </div>
  </div>
</main>
<?php
get_footer();
