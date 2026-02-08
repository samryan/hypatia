<?php
/*
Template Name: /Books/

Page template for the main books overview page with stats.
*/
?>

<?php get_header(); ?>

<main id="main" role="main">
  <div class="container">
    <?php while ( have_posts() ) : the_post(); ?>
      <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    <?php endwhile; ?>
  </div>
  <div class="container">
    <?php hypatia_books_nav(); ?>
  </div>
  <?php while ( have_posts() ) : the_post(); ?>
    <div class="container">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </div>
  <?php endwhile; ?>

  <?php
    // Check for cached stats (1 hour cache)
    $cache_key = 'hypatia_book_stats';
    $stats = get_transient($cache_key);

    if ($stats === false) {
      global $wpdb;
      $book_ids = $wpdb->get_col(
        "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'books' AND post_status = 'publish'"
      );

      // Prime the meta cache for all books in one query
      update_meta_cache('post', $book_ids);

      $current_year = (int) date('Y');
      $books_by_year = array();
      $ratings_by_year = array();
      $authors_count = array();
      $books_with_highlights = 0;
      $rating_distribution = array(1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0);
      $books_by_month = array_fill(1, 12, 0);

      foreach ($book_ids as $book_id) {
        $year = get_post_meta($book_id, 'year_read', true);
        $rating = get_post_meta($book_id, 'rating', true);
        $author = get_post_meta($book_id, 'book_author', true);
        $date_read = get_post_meta($book_id, 'date_read', true);
        $highlights = get_post_meta($book_id, 'book_quotes', true);

        if ($year) {
          if (!isset($books_by_year[$year])) {
            $books_by_year[$year] = 0;
            $ratings_by_year[$year] = array();
          }
          $books_by_year[$year]++;

          if (is_numeric($rating) && $rating > 0) {
            $ratings_by_year[$year][] = intval($rating);
          }
        }

        if (is_numeric($rating) && $rating >= 1 && $rating <= 5) {
          $rating_distribution[intval($rating)]++;
        }

        if ($year == $current_year && $date_read) {
          $month = (int) date('n', strtotime($date_read));
          if ($month >= 1 && $month <= 12) {
            $books_by_month[$month]++;
          }
        }

        if ($author) {
          if (!isset($authors_count[$author])) {
            $authors_count[$author] = 0;
          }
          $authors_count[$author]++;
        }

        if (!empty($highlights)) {
          $books_with_highlights++;
        }
      }

      ksort($books_by_year);
      $first_year = !empty($books_by_year) ? min(array_keys($books_by_year)) : $current_year;

      $books_by_year_complete = array();
      for ($y = $first_year; $y <= $current_year; $y++) {
        $books_by_year_complete[$y] = isset($books_by_year[$y]) ? $books_by_year[$y] : 0;
      }
      $books_by_year = $books_by_year_complete;

      arsort($authors_count);
      $repeat_authors = array_filter($authors_count, function($count) {
        return $count > 1;
      });
      $repeat_authors_count = count($repeat_authors);
      $top_authors = array_slice($repeat_authors, 0, 15, true);

      $max_books_year = !empty($books_by_year) ? array_search(max($books_by_year), $books_by_year) : $current_year;
      $all_ratings = array();
      foreach ($ratings_by_year as $ratings) {
        $all_ratings = array_merge($all_ratings, $ratings);
      }
      $overall_avg_rating = count($all_ratings) > 0 ? round(array_sum($all_ratings) / count($all_ratings), 2) : 0;

      $stats = array(
        'total_books' => count($book_ids),
        'years_reading' => count($books_by_year),
        'first_year' => $first_year,
        'current_year' => $current_year,
        'books_by_year' => $books_by_year,
        'books_by_month' => $books_by_month,
        'rating_distribution' => $rating_distribution,
        'top_authors' => $top_authors,
        'repeat_authors_count' => $repeat_authors_count,
        'max_books_year' => $max_books_year,
        'overall_avg_rating' => $overall_avg_rating,
        'books_with_highlights' => $books_with_highlights,
      );

      set_transient($cache_key, $stats, HOUR_IN_SECONDS);
    }

    extract($stats);
  ?>

  <!-- Overview Stats -->
  <div class="container">
    <div class="stats-overview">
      <div class="stat-card">
        <div class="stat-number"><?php echo number_format($total_books); ?></div>
        <div class="stat-label">Books read</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?php echo $years_reading; ?></div>
        <div class="stat-label">Years tracking</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?php echo round($total_books / $years_reading, 1); ?></div>
        <div class="stat-label">Books per year (avg)</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?php echo $overall_avg_rating; ?> ★</div>
        <div class="stat-label">Average rating</div>
      </div>
    </div>
  </div>

  <!-- Recently Finished -->
  <div class="container">
    <div class="books" id="books-recent">
      <h2 class="section-header">Recently finished</h2>
      <div class="book-card-list book-card-list--mini">
      <?php
        $args = array( 'posts_per_page' => 4, 'post_type' => 'books' );
        $myposts = get_posts( $args );
        foreach ( $myposts as $post ) : setup_postdata( $post );
          echo hypatia_book_card($post->ID, 'mini');
        endforeach;
        wp_reset_postdata();
      ?>
      </div>
    </div>
    <div class="books-year-link">
      <a href="/books/list-<?php echo $current_year; ?>">This year's list &rarr;</a>
    </div>
  </div>

  <div class="container stats-page">
    <!-- Books per Year Chart -->
    <div class="stats-section">
      <h2 class="section-header" id="chart-year-label">Books per year</h2>
      <div class="stats-chart-bar" role="list" aria-labelledby="chart-year-label">
        <?php
          $max_count = max($books_by_year);
          foreach ($books_by_year as $year => $count) :
            $height_pct = $max_count > 0 ? ($count / $max_count) * 100 : 0;
            $is_current = ($year == $current_year);
        ?>
          <a href="/books/list-<?php echo $year; ?>" class="chart-bar-item<?php echo $is_current ? ' current' : ''; ?>" role="listitem" aria-label="<?php echo $year; ?>: <?php echo $count; ?> books">
            <span class="chart-bar-value" aria-hidden="true"><?php echo $count; ?></span>
            <span class="chart-bar" aria-hidden="true">
              <span class="chart-bar-inner" style="height: <?php echo $height_pct; ?>%;"></span>
            </span>
            <span class="chart-bar-label" aria-hidden="true"><?php echo "'" . substr($year, 2); ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Books per Month This Year -->
    <div class="stats-section">
      <h2 class="section-header"><?php echo $current_year; ?> by month</h2>
      <div class="stats-months-compact" role="list">
        <?php
          $max_month_count = max($books_by_month);
          $month_names = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
          $current_month = (int) date('n');
          foreach ($books_by_month as $month => $count) :
            $is_future = ($month > $current_month);
            $is_current = ($month == $current_month);
        ?>
          <div class="month-cell<?php echo $is_future ? ' future' : ''; ?><?php echo $is_current ? ' current' : ''; ?>" role="listitem" aria-label="<?php echo $month_names[$month]; ?>: <?php echo $count; ?> books">
            <span class="month-label" aria-hidden="true"><?php echo $month_names[$month]; ?></span>
            <span class="month-count" aria-hidden="true"><?php echo $count; ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Rating Distribution -->
    <div class="stats-section">
      <h2 class="section-header">Rating distribution (all time)</h2>
      <div class="stats-ratings" role="list">
        <?php
          $max_rating_count = max($rating_distribution);
          foreach (array(5, 4, 3, 2, 1) as $stars) :
            $count = $rating_distribution[$stars];
            $width_pct = $max_rating_count > 0 ? ($count / $max_rating_count) * 100 : 0;
        ?>
          <div class="stats-rating-row" role="listitem" aria-label="<?php echo $stars; ?> stars: <?php echo $count; ?> books">
            <span class="rating-label" aria-hidden="true"><?php echo str_repeat('★', $stars); ?></span>
            <span class="rating-bar-wrap" aria-hidden="true">
              <span class="rating-bar" style="width: <?php echo $width_pct; ?>%;"></span>
            </span>
            <span class="rating-count" aria-hidden="true"><?php echo $count; ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Most Read Authors -->
    <div class="stats-section">
      <h2 class="section-header">Most-read authors</h2>
      <div class="stats-authors-compact">
        <?php foreach ($top_authors as $author => $count) : ?>
          <span class="author-pill"><?php echo esc_html($author); ?> <span class="pill-count"><?php echo $count; ?></span></span>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Favorites -->
  <div class="container">
    <div class="books" id="books-favorites">
      <h2 class="section-header">Favorites</h2>
      <p>Books I'd recommend to most people, or that made an impact on how I think about the world:</p>
      <?php
        $args = array(
          'post_type' => 'books',
          'tag' => 'favorite',
          'posts_per_page' => -1
        );
        $the_query = new WP_Query($args);
      ?>
      <div class="book-card-list book-card-list--mini">
      <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <?php if (has_post_thumbnail()) : ?>
          <?php echo hypatia_book_card($post->ID, 'mini', ['show_rating' => false]); ?>
        <?php endif; endwhile; ?>
        <?php wp_reset_postdata(); ?>
      </div>
    </div>
  </div>

</main>

<?php get_footer(); ?>
