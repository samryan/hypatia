<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Book" <?php post_class(); ?>>
  <?php if (is_single()) : ?>
    <?php $year_read = get_post_meta($post->ID, 'year_read', true); ?>

    <!-- Breadcrumb -->
    <div class="book-breadcrumb">
      <div class="container">
        <a href="/books/all">Books</a> / <a href="/books/list-<?php echo $year_read; ?>"><?php echo $year_read; ?></a>
      </div>
    </div>

    <!-- Header: Cover + Metadata -->
    <div class="book-detail-header">
      <div class="container">
        <?php if (has_post_thumbnail()) : ?>
          <div class="book-cover-wrapper">
            <?php $book_vt = hypatia_book_vt_name($post->ID); ?>
            <div class="book-3d"<?php if ($book_vt) echo ' style="view-transition-name: ' . $book_vt . '"'; ?>>
              <div class="book-cover">
                <img src="<?php the_post_thumbnail_url('full'); ?>" class="book" alt="" itemprop="image" />
                <div class="book-spine"></div>
              </div>
              <div class="pages-container">
                <ul class="pages">
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                  <li></li>
                </ul>
              </div>
              <div class="bottom-cover">
                <img src="<?php the_post_thumbnail_url('full'); ?>" class="book" alt="" />
              </div>
              <img src="<?php the_post_thumbnail_url('full'); ?>" class="book book-sizer" alt="" />
            </div>
          </div>
        <?php endif; ?>
        <div class="book-metadata">
          <?php
            $title = the_title('','',false);
            if (strpos($title, ':') !== false) {
              $arr = explode(':', the_title('','',false));
              echo '<h1 class="entry-title" itemprop="name">';
              echo implode('<span class="sr-only">:</span> <span class="subtitle">', $arr);
              echo '</h1>';
            } else {
              echo '<h1 class="entry-title" itemprop="name">';
              the_title();
              echo '</h1>';
            }
          ?>
          <p class="author" itemprop="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></p>
          <p class="stars"><?php echo hypatia_rating_to_stars(get_post_meta($post->ID, 'rating', true)); ?></p>
          <p class="finished">
            Read
            <?php if ( get_post_meta($post->ID, 'date_read', true) ) : ?>
              <?php echo date('M j, Y', strtotime(get_post_meta($post->ID, 'date_read', true))); ?>
            <?php else: ?>
              in <?php echo $year_read; ?>
            <?php endif; ?>
          </p>
          <?php if ( get_post_meta($post->ID, 'amazon_affiliate_link', true) || get_post_meta($post->ID, 'book_source', true) ) : ?>
            <p class="book-links">
              <?php if ( get_post_meta($post->ID, 'amazon_affiliate_link', true) ) : ?>
                <a href="<?php echo get_post_meta($post->ID, 'amazon_affiliate_link', true); ?>" class="btn">Buy this book</a>
              <?php endif; ?>
              <?php if ( get_post_meta($post->ID, 'amazon_affiliate_link', true) && get_post_meta($post->ID, 'book_source', true) ) : ?>
                <span class="separator">&middot;</span>
              <?php endif; ?>
              <?php if ( get_post_meta($post->ID, 'book_source', true) ) : ?>
                <a href="<?php echo get_post_meta($post->ID, 'book_source', true); ?>">Full text</a>
              <?php endif; ?>
            </p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <?php /*
    <?php if ($post->post_content != '') : ?>
      <div class="book-review">
        <div class="container">
          <h2>Review</h2>
          <div class="entry-content" itemprop="review" itemscope itemtype="http://schema.org/Review">
            <span itemprop="reviewBody">
              <?php the_content(); ?>
            </span>
          </div>
        </div>
      </div>
    <?php endif; ?>
    */ ?>

    <?php if( have_rows('book_quotes') ): ?>
      <div class="book-highlights">
        <div class="container book_quotes">
          <h2>Highlights</h2>
          <?php $highlight_index = 0; while ( have_rows('book_quotes') ) : the_row(); $highlight_index++; ?>
            <article class="book_quote" id="highlight-<?php echo $highlight_index; ?>">
              <a href="#highlight-<?php echo $highlight_index; ?>" class="quote-mark" aria-label="Link to this highlight">&ldquo;</a>
              <div><?php the_sub_field('book_quote'); ?><cite><?php the_sub_field('book_quote_source'); ?></cite></div>
            </article>
          <?php endwhile; ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- Prev/Next Navigation -->
    <?php
      $prev_post = get_previous_post();
      $next_post = get_next_post();
      if ($prev_post || $next_post) :
    ?>
      <div class="book-navigation">
        <div class="container">
          <div class="book-nav-links">
            <?php if ($prev_post) : ?>
              <a href="<?php echo get_permalink($prev_post->ID); ?>" class="book-nav-link book-nav-prev" rel="prev">
                <span class="nav-label">Previous</span>
                <div class="nav-book">
                  <div class="cover">
                    <?php echo get_the_post_thumbnail($prev_post->ID, 'full', array('class' => 'book', 'data-book-id' => $prev_post->ID)); ?>
                  </div>
                  <div class="nav-metadata">
                    <span class="title"><?php echo get_the_title($prev_post->ID); ?></span>
                    <span class="author"><?php echo get_post_meta($prev_post->ID, 'book_author', true); ?></span>
                  </div>
                </div>
              </a>
            <?php endif; ?>
            <?php if ($next_post) : ?>
              <a href="<?php echo get_permalink($next_post->ID); ?>" class="book-nav-link book-nav-next" rel="next">
                <span class="nav-label">Next</span>
                <div class="nav-book">
                  <div class="cover">
                    <div class="book-spine"></div>
                    <?php echo get_the_post_thumbnail($next_post->ID, 'full', array('class' => 'book', 'data-book-id' => $next_post->ID)); ?>
                  </div>
                  <div class="nav-metadata">
                    <span class="title"><?php echo get_the_title($next_post->ID); ?></span>
                    <span class="author"><?php echo get_post_meta($next_post->ID, 'book_author', true); ?></span>
                  </div>
                </div>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- More by this author -->
    <?php
      $same_author_books = hypatia_books_by_same_author($post->ID, 6);
      if (!empty($same_author_books)) :
        $author_name = get_post_meta($post->ID, 'book_author', true);
    ?>
      <div class="book-more-by-author">
        <div class="container">
          <h2>More by <?php echo esc_html($author_name); ?></h2>
          <div class="book-card-list book-card-list--mini">
            <?php foreach ($same_author_books as $author_book) : ?>
              <?php echo hypatia_book_card($author_book->ID, 'mini', ['show_rating' => true]); ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

  <?php endif; ?>
</article>
