<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Book" <?php post_class(); ?>>
	<?php if (is_single()) : ?>
    <?php if (has_post_thumbnail()) :?>
      <section class="book-cover bg-default">
        <div class="container">
          <a href="<?php echo get_post_meta($post->ID, 'amazon_affiliate_link', true); ?>">
            <?php the_post_thumbnail(); ?>
          </a>
          <div class="book-data">
    		    <h1 class="entry-title" itemprop="name"><i><?php the_title(); ?></i></h1>
            <h2 itemprop="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></h2>
            <h3 class="stars">
              <?php echo get_post_meta($post->ID, 'rating', true); ?>
            </h3>
          </div>
        </div>
        <div class="adjust"></div>
      </section>
    <?php else : ?>
      <section class="bg-default">
        <div class="container">
  		    <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
          <h2 itemprop="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></h2>
        </div>
      </section>
    <?php endif; ?>
	<?php endif; ?>
  <?php if ($post->post_content != '') : ?>
    <section class="review bg-green">
      <div class="container">
        <h3><b>Review</b></h3>
        <div class="entry-content" itemprop="review" itemscope itemtype="http://schema.org/Review">
          <span itemprop="reviewBody">
            <?php the_content(); ?>
          </span>
        </div>
      </div>
    </section>
  <?php endif; ?>
  <section class="bg-gray">
    <div class="container">
      <table class="books-meta-table">
        <thead>
          <tr>
            <th>Links</th>
            <th>Finished</th>
            <th>More from this year</th>
            <!--<th>Tags</th>-->
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <?php if ( get_post_meta($post->ID, 'amazon_affiliate_link', true) ) : ?>
                <a href="<?php echo get_post_meta($post->ID, 'amazon_affiliate_link', true); ?>">Buy this book</a>
              <?php endif; ?>
              <?php if ( get_post_meta($post->ID, 'book_source', true) ) : ?>
               <br>
               <a href="<?php echo get_post_meta($post->ID, 'book_source', true); ?>">Full text</a>
              <?php endif; ?>
            </td>
            <td>
              <?php if ( get_post_meta($post->ID, 'date_read', true) ) : ?>
                ~<?php echo date('M j, Y', strtotime(get_post_meta($post->ID, 'date_read', true))); ?>
              <?php else: ?>
                <?php echo get_post_meta($post->ID, 'year_read', true); ?>
              <?php endif; ?>
            </td>
            <td>
              <a href="/books/list-<?php echo get_post_meta($post->ID, 'year_read', true); ?>">Books read in <?php echo get_post_meta($post->ID, 'year_read', true); ?></a>
            </td>
            <!--
            <td class="tags">
              <?php echo get_the_tag_list('<ul class="book-tags"><li>',', </li><li>','</li></ul>'); ?>
            </td>
            -->
          </tr>
        </tbody>
      </table>
    </div>
  </section>
	<?php if( have_rows('book_quotes') ): ?>
    <section class="clear bg-default">
      <div class="container">
  			<div class="book_quotes">
          <h3><b>Highlights</b></h3>
  				<?php while ( have_rows('book_quotes') ) : the_row(); ?>
  					<article class="book_quote">
  						<div><?php the_sub_field('book_quote'); ?><cite><?php the_sub_field('book_quote_source'); ?></cite></div>
  					</article>
  				<?php endwhile; ?>
  			</div>
      </div>
    </section>
	<?php endif; ?>
  <?php ?>
  <section class="clear bg-gray">
    <div class="container">
      <?php previous_post_link( 'Previous: <i>%link</i> by ' ); echo get_previous_post()->book_author; ?>
    </div>
  </section>
  <section class="clear bg-gray">
    <div class="container">
      <?php next_post_link( 'Next: <i>%link</i> by ' ); echo get_next_post()->book_author; ?>
    </div>
  </section>
</article>
