<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Book" <?php post_class(); ?>>
	<?php if (is_single()) : ?>
    <?php if (has_post_thumbnail()) :?>
      <section class="book-cover bg-grade">
        <div class="container">
          <a href="<?php echo get_post_meta($post->ID, 'amazon_affiliate_link', true); ?>">
            <?php the_post_thumbnail(); ?>
          </a>
          <div class="book-data">
    		    <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
            <h2 itemprop="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></h2>
          </div>
        </div>
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
  <section class="review bg-default">
    <div class="container">
  	  <div class="entry-content" itemprop="review" itemscope itemtype="http://schema.org/Review">
        <span itemprop="reviewBody">
  			  <?php the_content(); ?>
  			</span>
  			<div class="stars">
  				<span itemprop="reviewRating"><?php echo get_post_meta($post->ID, 'rating', true); ?></span><?php if ( is_single() ) : // show year lists if single page ?>, <a href="/books/list-<?php echo get_post_meta($post->ID, 'year_read', true); ?>"><?php echo get_post_meta($post->ID, 'year_read', true); ?></a><?php endif; ?>
  			</div>
  			<ul class="book_links">
          <?php if ( get_post_meta($post->ID, 'amazon_affiliate_link', true) ) : ?>
      		<li><a href="<?php echo get_post_meta($post->ID, 'amazon_affiliate_link', true); ?>" class="button">Purchase</a></li>
          <?php endif; ?>
          <?php if ( get_post_meta($post->ID, 'book_source', true) ) : ?>
           <li><a href="<?php echo get_post_meta($post->ID, 'book_source', true); ?>" class="button">Full text</a></li>
          <?php endif; ?>
  			</ul>
  		</div>
    </div>
  </section>
	<?php if( have_rows('book_quotes') ): ?>
    <section class="clear bg-default">
      <div class="container">
  			<div class="book_quotes">
  				<?php while ( have_rows('book_quotes') ) : the_row(); ?>
  					<article class="book_quote">
  						<div><?php the_sub_field('book_quote'); ?><cite><?php the_sub_field('book_quote_source'); ?></cite></div>
  					</article>
  				<?php endwhile; ?>
  			</div>
      </div>
    </section>
	<?php endif; ?>
</article>
