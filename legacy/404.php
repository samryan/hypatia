<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Toolbox
 * @since Toolbox 0.1
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">
			<article id="post-0" class="post error404 not-found">
				<header class="entry-header">
					<h1 class="entry-title">Error 404: Page Not Found</h1>
				</header>
				<div class="entry-content">
          <img src="/images/skywalker.jpg" alt="404" class="full" />
          <p>There&rsquo;s nothing for you here anymore.</p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>
