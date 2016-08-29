<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hypatia
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title">404: Page Not Found</h1>
				</header>
				<div class="page-content">
          <img src="/images/skywalker.jpg" alt="404" class="full" />
          <p>There&rsquo;s nothing for you here anymore.</p>
					<?php get_search_form(); ?>
				</div>
			</section>
		</main>
	</div>

<?php
get_footer();
