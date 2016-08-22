<?php
/*
Template Name: Front page
*/
?>

<?php get_header(); ?>

<p>I'm a UX designer at Amazon.com, and a graduate of UC Berkeley and the University of Washington iSchool. <a href="http://samryan.net/about">More about me &rarr;</a></p>

<?php
	$querystr = "
	SELECT $wpdb->posts.*
	FROM $wpdb->posts, $wpdb->postmeta
	WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id
	AND $wpdb->posts.post_status = 'publish'
	AND $wpdb->posts.post_type = 'post'
	AND $wpdb->posts.post_date < NOW()
	ORDER BY $wpdb->posts.post_date DESC
	";
	$pageposts = $wpdb->get_results($querystr, OBJECT_K);
?>

<h2>Recently read</h2>
<style>
.carousel li a img {
  max-height: 200px;
  width: auto;
  max-width: 190px;

}
ul.carousel {
  list-style-type: none;
}
ul.carousel li {
  margin-right: 0;
  margin-left: 0;
}
</style>

<script type="text/javascript">
$(document).ready(function () {
  var carousel = $(".carousel");
  carousel.owlCarousel({
    navigation: true,
    pagination: false,
    lazyLoad: true,
    navigationText: [
      "<i class='icon-chevron-left'><</i>",
      "<i class='icon-chevron-right'>></i>"
      ],
  });
});
</script>

<ul class="carousel owl-carousel">
<?php
	$args = array( 'posts_per_page' => 25, 'post_type' => 'books' );
	$myposts = get_posts( $args );
	foreach ( $myposts as $post ) : setup_postdata( $post ); ?>

		<li class="book_cover">
			<a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail(); ?><br>
        <span><?php echo get_post_meta($post->ID, 'book_author', true); ?></span>
      </a>
		</li>

<?php endforeach;
wp_reset_postdata();?>
</ul>

<?php if ($pageposts): ?>
	<?php global $post; ?>
		<h2>Blog posts</h2>
		<ul>
			<?php foreach ($pageposts as $post): ?>
			<li><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></li>
			<?php endforeach; ?>
		</ul>
	<?php else : ?>
<?php endif; ?>

<h2>PDFs</h2>
<ul>
	<li><a href="http://samryan.net/papers/DAC.pdf">A Victorian Cyberspace: The Daily Alta California in 1868</a> (2010)</li>
	<li><a href="http://samryan.net/papers/StampAct.pdf">“Wound Up by Any Hand”: Samuel Adams, Peter Oliver, &amp; the Problem of Stamp Act Violence</a> (2009)</li>
	<li><a href="http://samryan.net/papers/Dylan.pdf">Essays on Bob Dylan</a> (2008)</li>
</ul>

<?php get_footer(); ?>
