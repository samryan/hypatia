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

  <?php
    // Featured projects for homepage
    $uploads_url = content_url('/uploads');
    $featured_projects = array(
      array(
        'image' => 'storm.png',
        'title' => 'Storm design system',
        'description' => 'Lead designer for Amazon Ads\' design system, supporting a $50B/year business across 890+ software projects. Built documentation, Figma libraries, and led adoption for a 100+ person design org.'
      ),
      array(
        'image' => 'API-site.png',
        'title' => 'Amazon Ads API',
        'description' => 'Redesigned the developer documentation site for Amazon Ads API integrators. Shipped new navigation, mobile support, and a dashboard for tracking application metrics.'
      ),
    );
  ?>

  <!-- Projects section -->
  <div class="home projects">
    <div class="container">
      <h2 class="section-header">Selected work</h2>
      <div class="home-projects-list">
        <?php foreach ($featured_projects as $project) : ?>
          <div class="home-project-row">
            <div class="home-project-image">
              <img src="<?php echo $uploads_url . '/' . $project['image']; ?>" alt="<?php echo $project['title']; ?>" loading="lazy" />
            </div>
            <div class="home-project-info">
              <h3><?php echo $project['title']; ?></h3>
              <p><?php echo $project['description']; ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="home-projects-link"><a href="/projects">View all projects &rarr;</a></p>
    </div>
  </div>

  <div class="home books">
    <div class="container">
      <h2 class="section-header">Reading list</h2>
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
