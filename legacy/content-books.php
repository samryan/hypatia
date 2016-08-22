<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Book" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><span itemprop="author"><?php echo get_post_meta($post->ID, 'book_author', true); ?></span>, <i itemprop="name"><?php the_title(); ?></i></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php echo get_post_meta($post->ID, 'book_author', true); ?>, <i><?php the_title(); ?></i></a>
			</h1>
			<?php endif; // is_single() ?>
		</header>

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div>
		<?php else : ?>
        <?php if (has_post_thumbnail()) :?>
			<div class="book_cover">
	    		<?php if ( is_single() ) : // picture goes to AMZN if single page ?>
		    		<a href="<?php echo get_post_meta($post->ID, 'amazon_affiliate_link', true); ?>">
						<?php the_post_thumbnail(); ?>
					</a>
	    		<?php else : // picture goes to individual post if in a list ?>
		            <a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail(); ?>
					</a>
	            <?php endif; // is_single() ?>
			</div>
		<?php else :?>
		<?php endif;?>
		<div class="entry-content" itemprop="review" itemscope itemtype="http://schema.org/Review"><span itemprop="reviewBody">
			<?php the_content(); ?>
			</span>
			<div class="stars">
				<span itemprop="reviewRating">
					<?php echo get_post_meta($post->ID, 'rating', true); ?></span><?php if ( is_single() ) : // show year lists if single page ?>, <a href="http://samryan.net/books/list-<?php echo get_post_meta($post->ID, 'year_read', true); ?>"><?php echo get_post_meta($post->ID, 'year_read', true); ?></a><?php endif; ?>
			</div>

			<ul class="book_links">
                <?php if ( get_post_meta($post->ID, 'amazon_affiliate_link', true) ) : ?>
    			 <li><a href="<?php echo get_post_meta($post->ID, 'amazon_affiliate_link', true); ?>">Purchase</a></li>
                <?php endif; ?>
                <?php if ( get_post_meta($post->ID, 'book_source', true) ) : ?>
    			 <li><a href="<?php echo get_post_meta($post->ID, 'book_source', true); ?>">Full text</a></li>
                <?php endif; ?>
                <?php if ( get_post_meta($post->ID, 'ebook_highlights', true) ) : ?>
    			 <li><a href="<?php echo get_post_meta($post->ID, 'ebook_highlights', true); ?>">My ebook highlights</a></li>
                <?php endif; ?>
			</ul>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
		</div>

		<?php endif; ?>
		<div style="clear:both;display:block;height:1px;"></div>
	</article>

		<?php if( have_rows('book_quotes') ): ?>
			<div class="book_quotes entry-content">
				<?php while ( have_rows('book_quotes') ) : the_row(); ?>
					<article class="book_quote">
						<div><?php the_sub_field('book_quote'); ?><cite><?php the_sub_field('book_quote_source'); ?></cite></div>
					</article>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>

		<?php if ( is_single() ) : // show year lists if single page ?>

		<p id="books-subnav"><a title="Books" href="http://www.samryan.net/books/">Books</a>&nbsp;|&nbsp;<a title="Books read, 2009" href="http://www.samryan.net/books/list-2009/">2009</a>&nbsp;|&nbsp;<a title="Books read, 2010" href="http://www.samryan.net/books/list-2010/">2010</a>&nbsp;|&nbsp;<a title="Books read, 2011" href="http://www.samryan.net/books/list-2011/">2011</a>&nbsp;|&nbsp;<a href="http://www.samryan.net/books/list-2012/">2012</a>&nbsp;|&nbsp;<a title="Books read, 2013" href="http://www.samryan.net/books/list-2013/">2013</a>&nbsp;|&nbsp;<a title="Books read, 2014" href="http://www.samryan.net/books/list-2014/">2014</a>&nbsp;|&nbsp;<a title="Books read, 2015" href="http://www.samryan.net/books/list-2015/">2015</a></p>
		<?php endif; // is_single() ?>
