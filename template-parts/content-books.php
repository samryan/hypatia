<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Book" <?php post_class(); ?>>
	<?php if (is_single()) : ?>
    <?php if (has_post_thumbnail()) :?>
      <section class="book-header gradient-wrap">
        <div class="book-wrapper">
          <div class="book-cover">
            <img src="<?php the_post_thumbnail_url('full'); ?>" class="book" alt="" />
            <div class="book-spine"></div>
          </div>
          <div class="pages-container">
            <ul class="pages">
              <li></li>
              <li></li>
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
          <img src="<?php the_post_thumbnail_url('full'); ?>" class="book" alt="" style="visibility:hidden;" />
        </div>
      </section>
    <?php endif; ?>
    <section>
      <div class="container book-metadata">
        <?php
          $title = the_title('','',false);
          if (strpos($title, ':') !== false) {
            // echo 'true';
            $arr=explode(':', the_title('','',false) );
            echo '<h2 class="entry-title" itemprop="name">';
            echo implode( '<span class="sr-only">:</span> <span class="subtitle">', $arr);
            echo '</h2>';
          } else {
            echo '<h2 class="entry-title" itemprop="name">';
            the_title();
            echo '</h2>';
          }
        ?>
        <h3 itemprop="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></h2>
        <h3 class="stars">
          <?php echo get_post_meta($post->ID, 'rating', true); ?>
        </h3>
      </div>
    </section>
  <?php endif; ?>
  <?php if ($post->post_content != '') : ?>
    <section class="review">
      <div class="container">
        <h3><b>Review:</b></h3>
        <div class="entry-content" itemprop="review" itemscope itemtype="http://schema.org/Review">
          <span itemprop="reviewBody">
            <?php the_content(); ?>
          </span>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <?php if( have_rows('book_quotes') ): ?>
    <section>
      <div class="container book_quotes">
        <h3><b>Highlights</b></h3>
        <?php while ( have_rows('book_quotes') ) : the_row(); ?>
          <article class="book_quote">
            <div><?php the_sub_field('book_quote'); ?><cite><?php the_sub_field('book_quote_source'); ?></cite></div>
          </article>
        <?php endwhile; ?>
      </div>
    </section>
	<?php endif; ?>
  <section class="links">
    <div class="container">
      <ul>
        <li>
          <span>Links:</span>
          <?php if ( get_post_meta($post->ID, 'amazon_affiliate_link', true) ) : ?>
            <a href="<?php echo get_post_meta($post->ID, 'amazon_affiliate_link', true); ?>">Buy this book</a>
          <?php endif; ?>
          <?php if ( get_post_meta($post->ID, 'book_source', true) ) : ?>
            <br>
            <a href="<?php echo get_post_meta($post->ID, 'book_source', true); ?>">Full text</a>
          <?php endif; ?>
        </li>
        <li>
          <span>Finished:</span>
          <?php if ( get_post_meta($post->ID, 'date_read', true) ) : ?>
            ~<?php echo date('M j, Y', strtotime(get_post_meta($post->ID, 'date_read', true))); ?>
          <?php else: ?>
          <?php echo get_post_meta($post->ID, 'year_read', true); ?>
          <?php endif; ?>
        </li>
        <li>
          <span>More from this year:</span>
          <a href="/books/list-<?php echo get_post_meta($post->ID, 'year_read', true); ?>" aria-label="Books read in <?php echo get_post_meta($post->ID, 'year_read', true); ?>"><?php echo get_post_meta($post->ID, 'year_read', true); ?></a>
        </li>
        <?php /*
        <li><b>Tags:</b>
          <?php echo get_the_tag_list('<ul class="book-tags"><li>',', </li><li>','</li></ul>'); ?>
        </li>
        */ ?>
      </ul>
    </div>
  </section>
  <?php if( get_next_post() ): ?>
  <section class="navigation">
    <div class="container">
      <span>Next:</span>
      <?php
        $next_post_url = get_permalink(get_adjacent_post(false,'',false)->ID);
        echo '<a href="';
        echo $next_post_url;
        echo '" rel="next"><span class="author">';
        echo get_next_post()->book_author;
        echo '</span> – <span class="title">';
        echo get_next_post()->post_title;
        echo '</span></a>';
      ?>
    </div>
  </section>
  <?php endif; ?>
  <?php if( get_previous_post() ): ?>
  <section>
    <div class="container">
      <span>Previous:</span>
      <?php
        $previous_post_url = get_permalink( get_adjacent_post(false,'',true)->ID );
        echo '<a href="';
        echo $previous_post_url;
        echo '" rel="next"><span class="author">';
        echo get_previous_post()->book_author;
        echo '</span> – <span class="title">';
        echo get_previous_post()->post_title;
        echo '</span></a>';
      ?>
    </div>
    </section>
  <?php endif; ?>
</article>
