<?php
/*
Template Name: All books

Page template for a list of all books in the DB
*/
?>

<?php get_header(); ?>

<section class="bg-default">
  <div class="container">
    <?php
      while ( have_posts() ) : the_post();
    ?>
      <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
      <div class="entry-content">
        <?php
          the_content();
        ?>
        </div>
    <?php
      endwhile; // End of the loop.
    ?>
  </div>
  <div class="container">
  <table>
    <thead>
      <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Rating</th>
        <th>Read</th>
        <th>Cover image</th>
        <th>Links</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $args = array(
        'posts_per_page' => -1,
        'post_type' => 'books',
        'post_status' => 'publish'
      );
      $myposts = get_posts( $args );
      foreach ( $myposts as $post ) : setup_postdata( $post );
    ?>
      <tr style="border-bottom: 1px solid #eee;"> 
        <td style="width: 25%"><?php the_title() ?></td>
        <td><?php echo get_post_meta($post->ID, 'book_author', true); ?></td>
        <td style="width: 100px;"><?php echo get_post_meta($post->ID, 'rating', true); ?></td>
        <td style="width: 110px;">
          <?php if ( get_post_meta($post->ID, 'date_read', true) ) : ?>
            <?php echo date('M j, Y', strtotime(get_post_meta($post->ID, 'date_read', true))); ?>
          <?php else: ?>
            <?php echo get_post_meta($post->ID, 'year_read', true); ?>
          <?php endif; ?>
        </td>
        <td style="width: 110px;"><a href="<?php the_post_thumbnail_url('full'); ?>">Cover image</a></td>
        <td style="width: 110px;">
          <?php if ( get_post_meta($post->ID, 'amazon_affiliate_link', true) ) : ?>
            <a href="<?php echo get_post_meta($post->ID, 'amazon_affiliate_link', true); ?>">Buy this book</a>
          <?php endif; ?>
          <?php if ( get_post_meta($post->ID, 'book_source', true) ) : ?>
            <br>
            <a href="<?php echo get_post_meta($post->ID, 'book_source', true); ?>">Full text</a>
          <?php endif; ?>
        </td>

      </tr>
    <?php
      endforeach;
      wp_reset_postdata();
    ?>  
    </tbody>
  </table>
</section>

<?php
get_footer();
