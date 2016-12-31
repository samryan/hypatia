	<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
	<div class="entry-content">
		<?php
			the_content();
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'sample-theme' ),
				'after'  => '</div>',
			) );
		?>
	</div>
