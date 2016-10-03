<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hypatia
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title">No results</h1>
	</header>
  <div class="page-content">
    <img src="/images/skywalker.jpg" alt="404" class="full" />
    <p>There&rsquo;s nothing for you here anymore.</p>
		<p>Try searching for something else.</p>
		<?php get_search_form(); ?>
  </div>
</section>