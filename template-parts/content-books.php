<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Book" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if (is_single()) : ?>
      <?php if (has_post_thumbnail()) :?>
        <div class="book-cover">
          <a href="<?php echo get_post_meta($post->ID, 'amazon_affiliate_link', true); ?>">
            <?php the_post_thumbnail(); ?>
          </a>
          <div class="book-data">
    		    <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
            <h2 itemprop="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></h2>
          </div>
        </div>
      <?php else : ?>
  		    <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
          <h2 itemprop="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></h2>
      <?php endif; ?>
		<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'hypatia' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php echo get_post_meta($post->ID, 'book_author', true); ?>, <i><?php the_title(); ?></i></a>
			</h1>
		<?php endif; ?>
	</header>

  <?php if ( is_search() ) : ?>
  <?php else : ?>
  <?php if (has_post_thumbnail()) :?>
    <div class="book-cover">
  	<?php if ( is_single() ) : // hide cover down here if single page ?>
	  <?php else : // picture goes to individual post if in a list ?>
		  <a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail(); ?>
			</a>
	  <?php endif; // is_single() ?>
		</div>
	<?php else :?>
	<?php endif;?>
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
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'hypatia' ), 'after' => '</div>' ) ); ?>
		</div>
		<?php endif; ?>
		<div style="clear:both;display:block;height:1px;"></div>
		<?php if( have_rows('book_quotes') ): ?>
			<div class="book_quotes entry-content">
				<?php while ( have_rows('book_quotes') ) : the_row(); ?>
					<article class="book_quote">
						<div><?php the_sub_field('book_quote'); ?><cite><?php the_sub_field('book_quote_source'); ?></cite></div>
					</article>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
</article>
