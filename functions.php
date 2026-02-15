<?php
/**
 * Sample Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package hypatia
 */

if ( ! function_exists( 'hypatia_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hypatia_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'hypatia' ),
	) );

  function register_my_menus() {
    register_nav_menus(
      array(
        'primary' => esc_html__( 'Primary', 'hypatia' ),
        'books-menu' => __( 'Books Menu' )
       )
     );
   }
   add_action( 'init', 'register_my_menus' );

   // Highlight Reading nav item on individual book pages
   function hypatia_nav_menu_css_class( $classes, $item ) {
     // Check if we're on a single book page (post type is 'books')
     if ( is_singular( 'books' ) ) {
       // Check if this menu item links to /books/
       $url = $item->url;
       if ( preg_match( '#/books/?$#', $url ) ) {
         $classes[] = 'current-menu-ancestor';
       }
     }
     return $classes;
   }
   add_filter( 'nav_menu_css_class', 'hypatia_nav_menu_css_class', 10, 2 );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

}
endif;
add_action( 'after_setup_theme', 'hypatia_setup' );

/**
 * Google Fonts URL (used for async load).
 */
function hypatia_fonts_url() {
	return 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&display=swap';
}

/**
 * Enqueue scripts and styles.
 */
function hypatia_scripts() {
	// Preconnect for Google Fonts
	add_filter( 'wp_resource_hints', function( $urls, $relation_type ) {
		if ( $relation_type === 'preconnect' ) {
			$urls[] = array( 'href' => 'https://fonts.googleapis.com', 'crossorigin' => true );
			$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' => true );
		}
		return $urls;
	}, 10, 2 );

	// Main stylesheet (no font dependency; fonts load async below)
	wp_enqueue_style( 'hypatia-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );

	// Load Google Fonts asynchronously so they don't block render (saves ~550ms in Lighthouse)
	add_action( 'wp_head', function() {
		$url = esc_url( hypatia_fonts_url() );
		echo '<link rel="preload" href="' . $url . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">';
		echo '<noscript><link rel="stylesheet" href="' . $url . '"></noscript>';
	}, 1 );

	$theme_js = get_theme_file_path( 'js/theme.js' );
	if ( file_exists( $theme_js ) ) {
		wp_enqueue_script(
			'hypatia-theme',
			get_theme_file_uri( 'js/theme.js' ),
			array(),
			filemtime( $theme_js ),
			array( 'in_footer' => true, 'strategy' => 'defer' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'hypatia_scripts' );

/**
 * Stop printing non-useful wordpress stuff in the <head> tag.
 */

function remove_wp_junk() {
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wp_generator');
//  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
  remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('set_comment_cookies', 'wp_set_comment_cookies');
  remove_action('wp_head', 'wp_oembed_add_discovery_links');
  remove_action('wp_head', 'wp_oembed_add_host_js');
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_styles', 'print_emoji_styles');
  remove_action('wp_head', 'rest_output_link_wp_head', 10);
  remove_action('wp_head', 'wp_oembed_add_discovery_links', 10 );
  remove_action('rest_api_init', 'wp_oembed_register_route');
  remove_action('template_redirect', 'rest_output_link_header', 11, 0);
  remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
  add_filter( 'feed_links_show_comments_feed', '__return_false' );
  add_filter('the_generator', '__return_false');
  add_filter('emoji_svg_url', '__return_false');
  add_filter('embed_oembed_discover', '__return_false');
  add_filter('json_enabled', '__return_false');
  add_filter('json_jsonp_enabled', '__return_false');
  add_filter('rest_enabled', '__return_false');
  add_filter('rest_jsonp_enabled', '__return_false');
}
add_action('after_setup_theme', 'remove_wp_junk');

function smartwp_remove_wp_block_library_css(){
  wp_dequeue_style( 'wp-block-library' );
  wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

// add tag and category support to pages
function tags_categories_support_all() {
  register_taxonomy_for_object_type('post_tag', 'page');
  register_taxonomy_for_object_type('category', 'page');
}

// ensure all tags and categories are included in queries
function tags_categories_support_query($wp_query) {
  if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
  if ($wp_query->get('category_name')) $wp_query->set('post_type', 'any');
}

// tag and category hooks
add_action('init', 'tags_categories_support_all');
add_action('pre_get_posts', 'tags_categories_support_query');

// remove logo from login screen
function my_login_logo() { ?>
    <style type="text/css">
        #login h1, #login #backtoblog { display: none; }

    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

// Keep logged in for 1 year on local dev only
function hypatia_local_long_login( $expiration, $user_id, $remember ) {
  if ( strpos( $_SERVER['HTTP_HOST'], '.test' ) !== false ) {
    return YEAR_IN_SECONDS;
  }
  return $expiration;
}
add_filter( 'auth_cookie_expiration', 'hypatia_local_long_login', 10, 3 );

// Dashboard quick links widget
function hypatia_dashboard_widgets() {
  wp_add_dashboard_widget('hypatia_quick_links', 'Quick edits', 'hypatia_quick_links_widget');
}
add_action('wp_dashboard_setup', 'hypatia_dashboard_widgets');

function hypatia_quick_links_widget() {
  ?>
  <style>
    .hypatia-quick-links { display: flex; flex-wrap: wrap; gap: 8px; }
    .hypatia-quick-links a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 8px 14px;
      background: #f6f7f7;
      border: 1px solid #ddd;
      border-radius: 4px;
      text-decoration: none;
      font-size: 13px;
      transition: all 0.15s ease;
    }
    .hypatia-quick-links a:hover { background: #fff; border-color: #2271b1; }
    .hypatia-quick-links .dashicons { margin-right: 6px; font-size: 16px; width: 16px; height: 16px; }
    .hypatia-quick-links .add-new {
      flex-basis: 100%;
      background: #2271b1;
      border-color: #2271b1;
      color: #fff;
    }
    .hypatia-quick-links .add-new:hover { background: #135e96; }
    .hypatia-quick-links .add-new .dashicons { color: #fff; }
  </style>
  <div class="hypatia-quick-links">
    <a href="<?php echo admin_url('post.php?post=2461&action=edit'); ?>"><span class="dashicons dashicons-admin-home"></span>Home</a>
    <a href="<?php echo admin_url('post.php?post=193&action=edit'); ?>"><span class="dashicons dashicons-portfolio"></span>Projects</a>
    <a href="<?php echo admin_url('post.php?post=1037&action=edit'); ?>"><span class="dashicons dashicons-book"></span>Reading</a>
    <a class="add-new" href="<?php echo admin_url('post-new.php?post_type=books'); ?>"><span class="dashicons dashicons-plus-alt"></span>Add Book</a>
  </div>
  <?php
}

// Lightbox for Projects page
function hypatia_projects_lightbox() {
  if ( ! is_page_template( 'projects.php' ) ) return;

  wp_enqueue_style( 'tobii', 'https://cdn.jsdelivr.net/npm/@midzer/tobii@2.5.0/dist/tobii.min.css' );
  wp_enqueue_script( 'tobii', 'https://cdn.jsdelivr.net/npm/@midzer/tobii@2.5.0/dist/tobii.min.js', array(), null, true );

  wp_add_inline_style( 'tobii', "
    .tobii figcaption { display: none; }
    .tobii { background: rgba(0, 0, 0, 0.45); }
    .tobii[aria-hidden='false'] .tobii__slide figure {
      animation: tobii-zoom-in 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }
    @keyframes tobii-zoom-in {
      0% { transform: scale(0.8); opacity: 0; }
      100% { transform: scale(1); opacity: 1; }
    }
    .tobii__slide figure img {
      max-width: 80vw !important;
      cursor: pointer;
    }
    .tobii__slider { cursor: default; }
    .tobii__btn--close {
      background: rgba(0, 0, 0, 0.5);
      border: none;
      box-shadow: none;
      top: 1.5rem;
      right: 1.5rem;
      border-radius: 0.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .tobii__btn--close:hover {
      background: rgba(0, 0, 0, 0.7);
    }
    .tobii__btn--close:focus { outline: none; box-shadow: none; }
    .tobii__btn--close:focus-visible { outline: 2px solid white; outline-offset: 2px; }
    .tobii__btn--close svg,
    .tobii__btn--close span { display: none !important; }
    .tobii__btn--close::after {
      content: '';
      display: block;
      width: 1.5rem;
      height: 1.5rem;
      background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23ffffff' viewBox='0 0 256 256'%3E%3Cpath d='M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z'%3E%3C/path%3E%3C/svg%3E\");
      background-size: contain;
      background-repeat: no-repeat;
    }
  " );

  wp_add_inline_script( 'tobii', "
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.entry-content img').forEach(function(img) {
        if (img.closest('a')) return;
        var wrapper = document.createElement('a');
        wrapper.href = img.src;
        wrapper.className = 'lightbox';
        img.parentNode.insertBefore(wrapper, img);
        wrapper.appendChild(img);
      });
      window.tobiiInstance = new Tobii({ selector: '.lightbox', zoom: true, counter: false, nav: false, swipe: false });
      var tobiiEl = document.querySelector('.tobii');
      if (tobiiEl) tobiiEl.addEventListener('click', function(e) {
        if (e.target.closest('.tobii-image')) {
          window.tobiiInstance.close();
        }
      });
    });
  " );
}
add_action( 'wp_enqueue_scripts', 'hypatia_projects_lightbox' );

// Book rating with highlights indicator
function hypatia_book_rating($post_id = null) {
  if (!$post_id) {
    global $post;
    $post_id = $post->ID;
  }

  $rating = get_post_meta($post_id, 'rating', true);
  // Read cached flag when set (by save_post or backfill). Avoids have_rows() in loops.
  // When not set, fall back to have_rows() for this request only (no write on read).
  $has_highlights = get_post_meta($post_id, '_has_book_quotes', true);
  if ( $has_highlights === '' && function_exists( 'have_rows' ) ) {
    $has_highlights = have_rows( 'book_quotes', $post_id );
  } else {
    $has_highlights = ( $has_highlights === '1' );
  }

  // Convert rating to Unicode stars for display
  $stars = hypatia_rating_to_stars($rating);

  $output = '<div class="rating">';
  $output .= $stars;

  if ($has_highlights) {
    $output .= '<svg class="highlights-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" aria-label="Has highlights"><path d="M160,56H64A16,16,0,0,0,48,72V224a8,8,0,0,0,12.65,6.51L112,193.83l51.36,36.68A8,8,0,0,0,176,224V72A16,16,0,0,0,160,56Zm0,152.46-43.36-31a8,8,0,0,0-9.3,0L64,208.45V72h96ZM208,40V192a8,8,0,0,1-16,0V40H88a8,8,0,0,1,0-16H192A16,16,0,0,1,208,40Z"/></svg>';
  }

  $output .= '</div>';

  return $output;
}

/**
 * Convert rating value to Unicode stars
 * Accepts either a number (0-5) or legacy Unicode string
 */
function hypatia_rating_to_stars($rating) {
  // If it's already Unicode stars, return as-is (legacy support)
  if (mb_strpos($rating, '★') !== false || mb_strpos($rating, '☆') !== false) {
    return esc_html($rating);
  }

  // Convert number to stars
  $num = intval($rating);
  $num = max(0, min(5, $num)); // Clamp to 0-5

  $filled = str_repeat('★', $num);
  $empty = str_repeat('☆', 5 - $num);

  return $filled . $empty;
}

// Books navigation - shows Overview, Full book list, and most recent 5 years
function hypatia_books_nav() {
  $current_year = (int) date('Y');
  $years_to_show = 5;
  $current_url = $_SERVER['REQUEST_URI'];

  $output = '<div class="books-menu"><ul>';

  // Overview link - only exact match to /books/ or /books
  $overview_class = (preg_match('#^/books/?$#', $current_url)) ? ' class="current-menu-item"' : '';
  $output .= '<li' . $overview_class . '><a href="/books/">Overview</a></li>';

  // Full book list link
  $all_class = (strpos($current_url, '/all') !== false) ? ' class="current-menu-item"' : '';
  $output .= '<li' . $all_class . '><a href="/books/all">Full book list</a></li>';

  // Recent years (most recent 5)
  for ($year = $current_year; $year > $current_year - $years_to_show; $year--) {
    $year_class = (strpos($current_url, '/list-' . $year) !== false) ? ' class="current-menu-item"' : '';
    $output .= '<li' . $year_class . '><a href="/books/list-' . $year . '">' . $year . '</a></li>';
  }

  $output .= '</ul></div>';

  echo $output;
}

/**
 * Reusable book card component
 *
 * @param int|WP_Post $post_id Post ID or post object
 * @param string $style Display style: 'grid' (cover above metadata) or 'mini' (cover beside metadata)
 * @param array $options Optional settings:
 *   - show_rating: bool (default true)
 *   - show_link: bool (default true)
 *   - label: string (optional label above the card, e.g. "Previous", "Next")
 * @return string HTML output
 */
function hypatia_book_card($post_id = null, $style = 'grid', $options = []) {
  if (!$post_id) {
    global $post;
    $post_id = $post->ID;
  }

  if (is_object($post_id)) {
    $post_id = $post_id->ID;
  }

  $defaults = [
    'show_rating' => true,
    'show_link' => true,
    'label' => '',
    'loading' => 'lazy',
  ];
  $options = array_merge($defaults, $options);

  $title = get_the_title($post_id);
  $author = get_post_meta($post_id, 'book_author', true);
  $permalink = get_permalink($post_id);
  $thumbnail = get_the_post_thumbnail_url($post_id, 'full');

  $output = '';

  // Wrapper element
  $wrapper_class = 'book-card book-card--' . $style;
  if ($options['show_link']) {
    $output .= '<a href="' . esc_url($permalink) . '" class="' . $wrapper_class . '">';
  } else {
    $output .= '<div class="' . $wrapper_class . '">';
  }

  // Optional label (for mini style, e.g. "Previous", "Next")
  if ($options['label']) {
    $output .= '<span class="book-card__label">' . esc_html($options['label']) . '</span>';
  }

  // Inner wrapper for layout
  $output .= '<div class="book-card__inner">';

  // Cover
  $output .= '<div class="book-card__cover">';
  $output .= '<div class="book-spine"></div>';
  if ($thumbnail) {
    $loading_attr = $options['loading'] === 'eager' ? '' : ' loading="lazy"';
    $priority_attr = $options['loading'] === 'eager' ? ' fetchpriority="high"' : '';
    $output .= '<img src="' . esc_url($thumbnail) . '" class="book" alt="" width="140" height="210"' . $loading_attr . $priority_attr . ' />';
  }
  $output .= '</div>';

  // Metadata
  $output .= '<div class="book-card__meta">';
  $output .= '<span class="book-card__title">' . esc_html($title) . '</span>';
  $output .= '<span class="book-card__author">' . esc_html($author) . '</span>';
  if ($options['show_rating']) {
    $output .= hypatia_book_rating($post_id);
  }
  $output .= '</div>';

  $output .= '</div>'; // .book-card__inner

  // Close wrapper
  if ($options['show_link']) {
    $output .= '</a>';
  } else {
    $output .= '</div>';
  }

  return $output;
}

/**
 * Auto-add list-YYYY tag when creating a new book
 */
function hypatia_auto_tag_new_book($post_id, $post, $update) {
  // Only for new posts, not updates
  if ($update) {
    return;
  }

  $current_year = date('Y');
  $year_tag = 'list-' . $current_year;

  wp_set_post_tags($post_id, $year_tag, true);
}
add_action('save_post_books', 'hypatia_auto_tag_new_book', 10, 3);

/**
 * Keep _has_book_quotes in sync when a book is saved. Used by hypatia_book_rating()
 * so we can show the highlights icon without calling have_rows() in loops.
 * Run hypatia_backfill_has_book_quotes() once to set the meta for existing books.
 */
function hypatia_update_has_book_quotes( $post_id ) {
  if ( get_post_type( $post_id ) !== 'books' ) {
    return;
  }
  $has = ( function_exists( 'have_rows' ) && have_rows( 'book_quotes', $post_id ) ) ? '1' : '0';
  update_post_meta( $post_id, '_has_book_quotes', $has );
}
add_action( 'save_post_books', 'hypatia_update_has_book_quotes', 20 );

/**
 * One-time backfill: set _has_book_quotes for all books. Run via WP-CLI:
 *   wp eval 'hypatia_backfill_has_book_quotes();'
 * Or call from a one-off admin action / script.
 */
function hypatia_backfill_has_book_quotes() {
  $books = get_posts( array(
    'post_type'      => 'books',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
  ) );
  $updated = 0;
  foreach ( $books as $id ) {
    $has = ( function_exists( 'have_rows' ) && have_rows( 'book_quotes', $id ) ) ? '1' : '0';
    update_post_meta( $id, '_has_book_quotes', $has );
    $updated++;
  }
  return $updated;
}

/**
 * Set dynamic default for year_read ACF field to current year
 */
function hypatia_year_read_default($field) {
  $field['default_value'] = date('Y');
  return $field;
}
add_filter('acf/load_field/name=year_read', 'hypatia_year_read_default');

/**
 * Search Modal REST API endpoint
 */
function hypatia_register_search_endpoint() {
  register_rest_route('hypatia/v1', '/search', array(
    'methods' => 'GET',
    'callback' => 'hypatia_search_callback',
    'permission_callback' => '__return_true',
    'args' => array(
      'q' => array(
        'required' => true,
        'sanitize_callback' => 'sanitize_text_field',
      ),
    ),
  ));
}
add_action('rest_api_init', 'hypatia_register_search_endpoint');

function hypatia_search_callback($request) {
  $search_term = $request->get_param('q');

  // Check cache first (1 hour expiry)
  $cache_key = 'hypatia_search_' . md5($search_term);
  $cached = get_transient($cache_key);
  if ($cached !== false) {
    return $cached;
  }

  $args = array(
    's' => $search_term,
    'post_type' => array('post', 'page', 'books'),
    'post_status' => 'publish',
    'posts_per_page' => 10,
  );

  $query = new WP_Query($args);
  $results = array();

  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $post_id = get_the_ID();
      $post_type = get_post_type();

      $result = array(
        'id' => $post_id,
        'title' => html_entity_decode(get_the_title(), ENT_QUOTES, 'UTF-8'),
        'url' => get_permalink(),
        'type' => $post_type,
        'type_label' => get_post_type_object($post_type)->labels->singular_name,
      );

      // Add author for books
      if ($post_type === 'books') {
        $result['author'] = get_post_meta($post_id, 'book_author', true);
        // Use 'full' size - older images may not have generated thumbnails
        $thumbnail = get_the_post_thumbnail_url($post_id, 'full');
        if ($thumbnail) {
          $result['thumbnail'] = $thumbnail;
        }
      } else {
        // Add excerpt for posts/pages
        $excerpt = get_the_excerpt();
        if ($excerpt) {
          $result['excerpt'] = wp_trim_words($excerpt, 15, '...');
        }
      }

      $results[] = $result;
    }
    wp_reset_postdata();
  }

  // Cache results for 1 hour
  set_transient($cache_key, $results, HOUR_IN_SECONDS);

  return $results;
}

/**
 * Clear caches when content changes
 */
function hypatia_clear_caches($post_id) {
  $post_type = get_post_type($post_id);
  if (in_array($post_type, array('post', 'page', 'books'))) {
    global $wpdb;
    // Clear search cache
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_hypatia_search_%' OR option_name LIKE '_transient_timeout_hypatia_search_%'");
    // Clear book stats cache
    if ($post_type === 'books') {
      delete_transient('hypatia_book_stats');
    }
  }
}
add_action('save_post', 'hypatia_clear_caches');
add_action('delete_post', 'hypatia_clear_caches');

/**
 * Enqueue search modal scripts
 */
function hypatia_search_modal_scripts() {
  $script_path = get_theme_file_path( 'js/search-modal.js' );
  $version = file_exists( $script_path ) ? filemtime( $script_path ) : null;

  wp_enqueue_script(
    'hypatia-search-modal',
    get_theme_file_uri( '/js/search-modal.js' ),
    array(),
    $version,
    array( 'in_footer' => true, 'strategy' => 'defer' )
  );

  wp_localize_script( 'hypatia-search-modal', 'hypatiaSearch', array(
    'endpoint' => rest_url( 'hypatia/v1/search' ),
  ) );
}
add_action( 'wp_enqueue_scripts', 'hypatia_search_modal_scripts' );

/**
 * Get other books by the same author
 *
 * @param int $post_id Current book post ID
 * @param int $limit Max number of books to return (default 6)
 * @return array Array of WP_Post objects
 */
function hypatia_books_by_same_author($post_id, $limit = 6) {
  $author = get_post_meta($post_id, 'book_author', true);

  if (empty($author)) {
    return array();
  }

  $args = array(
    'post_type' => 'books',
    'post_status' => 'publish',
    'posts_per_page' => $limit + 1, // Get one extra to account for current book
    'post__not_in' => array($post_id),
    'meta_query' => array(
      array(
        'key' => 'book_author',
        'value' => $author,
        'compare' => '='
      )
    )
  );

  $books = get_posts($args);

  return array_slice($books, 0, $limit);
}

/**
 * =============================================================================
 * LLM Accessibility Features
 * =============================================================================
 *
 * Implements three features to make the site more accessible to LLMs:
 * 1. /llms.txt - A Markdown directory of key content
 * 2. .md URL suffix - View any page as Markdown (e.g., /about.md)
 * 3. Accept: text/markdown - Content negotiation via HTTP header
 */

/**
 * Register rewrite rules for LLM endpoints
 */
function hypatia_llm_rewrite_rules() {
  // llms.txt endpoint
  add_rewrite_rule('^llms\.txt$', 'index.php?hypatia_llms_txt=1', 'top');

  // .md suffix for posts/pages (captures the slug without .md)
  add_rewrite_rule('^(.+)\.md$', 'index.php?hypatia_md_request=$matches[1]', 'top');
}
add_action('init', 'hypatia_llm_rewrite_rules');

/**
 * Register query vars
 */
function hypatia_llm_query_vars($vars) {
  $vars[] = 'hypatia_llms_txt';
  $vars[] = 'hypatia_md_request';
  return $vars;
}
add_filter('query_vars', 'hypatia_llm_query_vars');

/**
 * Handle LLM requests
 */
function hypatia_llm_template_redirect() {
  // Check for Accept: text/markdown header on regular pages
  if (!get_query_var('hypatia_llms_txt') && !get_query_var('hypatia_md_request')) {
    $accept = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : '';
    if (strpos($accept, 'text/markdown') !== false && (is_singular() || is_page())) {
      global $post;
      if ($post) {
        hypatia_serve_markdown($post);
        exit;
      }
    }
    return;
  }

  // Handle /llms.txt
  if (get_query_var('hypatia_llms_txt')) {
    hypatia_serve_llms_txt();
    exit;
  }

  // Handle .md suffix requests
  $md_request = get_query_var('hypatia_md_request');
  if ($md_request) {
    // Try to find the post/page by path
    $post = hypatia_get_post_by_path($md_request);
    if ($post) {
      hypatia_serve_markdown($post);
      exit;
    }
    // If not found, return 404
    status_header(404);
    echo "# 404 Not Found\n\nThe requested page could not be found.";
    exit;
  }
}
add_action('template_redirect', 'hypatia_llm_template_redirect', 1);

/**
 * Find a post by its URL path
 */
function hypatia_get_post_by_path($path) {
  // Clean the path
  $path = trim($path, '/');

  // Try as page first (handles hierarchical paths)
  $page = get_page_by_path($path);
  if ($page && $page->post_status === 'publish') {
    return $page;
  }

  // Try as post
  $post = get_page_by_path($path, OBJECT, 'post');
  if ($post && $post->post_status === 'publish') {
    return $post;
  }

  // Try as book (custom post type)
  $book = get_page_by_path($path, OBJECT, 'books');
  if ($book && $book->post_status === 'publish') {
    return $book;
  }

  // Try extracting slug from path like "book/book-title" or "books/book-title"
  $parts = explode('/', $path);
  $slug = end($parts);

  // Check if it's a book path (handles both /book/ and /books/)
  if (count($parts) >= 2 && ($parts[0] === 'book' || $parts[0] === 'books')) {
    $args = array(
      'name' => $slug,
      'post_type' => 'books',
      'post_status' => 'publish',
      'posts_per_page' => 1
    );
    $posts = get_posts($args);
    if (!empty($posts)) {
      return $posts[0];
    }
  }

  return null;
}

/**
 * Serve the llms.txt file
 */
function hypatia_serve_llms_txt() {
  // Check cache first (1 hour)
  $cached = get_transient('hypatia_llms_txt');
  if ($cached !== false) {
    header('Content-Type: text/markdown; charset=utf-8');
    header('X-Robots-Tag: noindex');
    echo $cached;
    return;
  }

  $site_name = get_bloginfo('name');
  $site_url = home_url();

  $output = "# {$site_name}\n\n";

  // Get and convert home page content
  $home_page = get_page_by_path('home');
  if (!$home_page) {
    $home_page = get_post(get_option('page_on_front'));
  }

  if ($home_page && $home_page->post_content) {
    $home_content = hypatia_html_to_markdown($home_page->post_content);
    $output .= $home_content . "\n\n";
  }

  // Main pages
  $output .= "## Pages\n\n";
  $output .= "- [Projects]({$site_url}/projects.md): My work and portfolio\n";
  $output .= "- [Reading]({$site_url}/books.md): Book tracking since 2009\n";

  // Reading section sitemap
  $output .= "\n## Reading\n\n";
  $output .= "Since 2009, I've been keeping a list of all the books I read, with ratings, highlights, and short reviews.\n\n";
  $output .= "- [Reading Overview]({$site_url}/books.md): Stats and recent books\n";
  $output .= "- [Full Book List]({$site_url}/books/all.md): Complete list of all books\n";

  // Get all years with books
  global $wpdb;
  $years = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->postmeta} WHERE meta_key = 'year_read' AND meta_value != '' ORDER BY meta_value DESC");

  if (!empty($years)) {
    $output .= "\n### Books by Year\n\n";
    foreach ($years as $year) {
      $book_count = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->postmeta} pm
         JOIN {$wpdb->posts} p ON pm.post_id = p.ID
         WHERE pm.meta_key = 'year_read' AND pm.meta_value = %s
         AND p.post_status = 'publish' AND p.post_type = 'books'",
        $year
      ));
      $output .= "- [{$year}]({$site_url}/books/list-{$year}): {$book_count} books\n";
    }
  }

  // Recent books
  $output .= "\n### Recent Books\n\n";

  $recent_books = get_posts(array(
    'post_type' => 'books',
    'post_status' => 'publish',
    'posts_per_page' => 10,
    'orderby' => 'date',
    'order' => 'DESC'
  ));

  foreach ($recent_books as $book) {
    $url = get_permalink($book);
    $md_url = rtrim($url, '/') . '.md';
    $author = get_post_meta($book->ID, 'book_author', true);
    $rating = get_post_meta($book->ID, 'rating', true);
    $stars = hypatia_rating_to_stars($rating);
    $output .= "- [{$book->post_title}]({$md_url})";
    if ($author) {
      $output .= " by {$author}";
    }
    $output .= " ({$stars})\n";
  }

  // Optional section
  $output .= "\n## Optional\n\n";
  $output .= "- [Full site (HTML)]({$site_url}): Browse the complete website\n";

  // Cache for 1 hour
  set_transient('hypatia_llms_txt', $output, HOUR_IN_SECONDS);

  header('Content-Type: text/markdown; charset=utf-8');
  header('X-Robots-Tag: noindex');
  echo $output;
}

/**
 * Serve a post as Markdown
 */
function hypatia_serve_markdown($post) {
  $title = get_the_title($post);
  $content = apply_filters('the_content', $post->post_content);
  $url = get_permalink($post);
  $date = get_the_date('F j, Y', $post);
  $post_type = get_post_type($post);
  $slug = $post->post_name;

  $output = "# {$title}\n\n";

  // Add metadata based on post type
  if ($post_type === 'books') {
    $author = get_post_meta($post->ID, 'book_author', true);
    $rating = get_post_meta($post->ID, 'rating', true);
    $year_read = get_post_meta($post->ID, 'year_read', true);

    if ($author) {
      $output .= "**Author:** {$author}\n";
    }
    if ($rating) {
      $stars = hypatia_rating_to_stars($rating);
      $output .= "**Rating:** {$stars}\n";
    }
    if ($year_read) {
      $output .= "**Year Read:** {$year_read}\n";
    }
    $output .= "\n";
  } elseif ($post_type === 'post') {
    $output .= "*Published: {$date}*\n\n";
  }

  // Convert HTML content to Markdown
  $markdown_content = hypatia_html_to_markdown($content);
  $output .= $markdown_content;

  // Check if this is a books section page that needs a book list
  $template = get_page_template_slug($post->ID);

  // Year list pages (e.g., list-2025)
  if ($template === 'books-year.php' || preg_match('/^list-(\d{4})$/', $slug, $matches)) {
    $year = isset($matches[1]) ? $matches[1] : str_replace('list-', '', $slug);
    $output .= hypatia_books_list_markdown('list-' . $year, $year);
  }
  // Full book list page
  elseif ($template === 'books-all.php' || $slug === 'all') {
    $output .= hypatia_books_list_markdown(null, 'All');
  }
  // Main books overview page
  elseif ($template === 'books-main.php' || $slug === 'books') {
    $output .= hypatia_books_overview_markdown();
  }

  // Add source link
  $output .= "\n\n---\n\n";
  $output .= "*Source: [{$url}]({$url})*\n";

  header('Content-Type: text/markdown; charset=utf-8');
  header('X-Robots-Tag: noindex');
  echo $output;
}

/**
 * Generate Markdown list of books
 *
 * @param string|null $tag Tag to filter by (e.g., 'list-2025'), or null for all books
 * @param string $year_label Label for the year (e.g., '2025' or 'All')
 * @return string Markdown output
 */
function hypatia_books_list_markdown($tag = null, $year_label = '') {
  $args = array(
    'posts_per_page' => -1,
    'post_type' => 'books',
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
  );

  if ($tag) {
    $args['tag'] = $tag;
  }

  $books = get_posts($args);

  if (empty($books)) {
    return "\n\nNo books found.\n";
  }

  $output = "\n\n## Books" . ($year_label ? " ({$year_label})" : "") . "\n\n";
  $output .= "| Title | Author | Rating |\n";
  $output .= "|-------|--------|--------|\n";

  foreach ($books as $book) {
    $book_title = html_entity_decode(get_the_title($book), ENT_QUOTES, 'UTF-8');
    $book_url = rtrim(get_permalink($book), '/') . '.md';
    $author = get_post_meta($book->ID, 'book_author', true);
    $rating = get_post_meta($book->ID, 'rating', true);
    $stars = hypatia_rating_to_stars($rating);

    $output .= "| [{$book_title}]({$book_url}) | {$author} | {$stars} |\n";
  }

  $count = count($books);
  $output .= "\n*{$count} books total*\n";

  return $output;
}

/**
 * Generate Markdown overview for the main books page
 *
 * @return string Markdown output
 */
function hypatia_books_overview_markdown() {
  global $wpdb;
  $site_url = home_url();

  $output = "\n\n## Reading Stats\n\n";

  // Get total book count
  $total = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'books' AND post_status = 'publish'");
  $output .= "**Total books read:** {$total}\n\n";

  // Get years with book counts
  $years = $wpdb->get_results("
    SELECT pm.meta_value as year, COUNT(*) as count
    FROM {$wpdb->postmeta} pm
    JOIN {$wpdb->posts} p ON pm.post_id = p.ID
    WHERE pm.meta_key = 'year_read' AND pm.meta_value != ''
    AND p.post_status = 'publish' AND p.post_type = 'books'
    GROUP BY pm.meta_value
    ORDER BY pm.meta_value DESC
  ");

  $output .= "## Books by Year\n\n";
  foreach ($years as $year_data) {
    $output .= "- [{$year_data->year}]({$site_url}/books/list-{$year_data->year}.md): {$year_data->count} books\n";
  }

  // Recent books
  $output .= "\n## Recent Books\n\n";
  $recent = get_posts(array(
    'post_type' => 'books',
    'post_status' => 'publish',
    'posts_per_page' => 10
  ));

  foreach ($recent as $book) {
    $book_url = rtrim(get_permalink($book), '/') . '.md';
    $book_title = html_entity_decode(get_the_title($book), ENT_QUOTES, 'UTF-8');
    $author = get_post_meta($book->ID, 'book_author', true);
    $stars = hypatia_rating_to_stars(get_post_meta($book->ID, 'rating', true));
    $output .= "- [{$book_title}]({$book_url}) by {$author} ({$stars})\n";
  }

  return $output;
}

/**
 * Convert HTML to Markdown
 * A lightweight conversion for common elements
 */
function hypatia_html_to_markdown($html) {
  // Decode entities first
  $text = html_entity_decode($html, ENT_QUOTES, 'UTF-8');

  // Remove scripts and styles
  $text = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $text);
  $text = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $text);

  // Convert headings
  $text = preg_replace('/<h1[^>]*>(.*?)<\/h1>/is', "\n# $1\n", $text);
  $text = preg_replace('/<h2[^>]*>(.*?)<\/h2>/is', "\n## $1\n", $text);
  $text = preg_replace('/<h3[^>]*>(.*?)<\/h3>/is', "\n### $1\n", $text);
  $text = preg_replace('/<h4[^>]*>(.*?)<\/h4>/is', "\n#### $1\n", $text);
  $text = preg_replace('/<h5[^>]*>(.*?)<\/h5>/is', "\n##### $1\n", $text);
  $text = preg_replace('/<h6[^>]*>(.*?)<\/h6>/is', "\n###### $1\n", $text);

  // Convert emphasis
  $text = preg_replace('/<(strong|b)[^>]*>(.*?)<\/(strong|b)>/is', '**$2**', $text);
  $text = preg_replace('/<(em|i)[^>]*>(.*?)<\/(em|i)>/is', '*$2*', $text);

  // Convert links
  $text = preg_replace('/<a[^>]*href=["\']([^"\']*)["\'][^>]*>(.*?)<\/a>/is', '[$2]($1)', $text);

  // Convert images
  $text = preg_replace('/<img[^>]*src=["\']([^"\']*)["\'][^>]*alt=["\']([^"\']*)["\'][^>]*\/?>/is', '![$2]($1)', $text);
  $text = preg_replace('/<img[^>]*alt=["\']([^"\']*)["\'][^>]*src=["\']([^"\']*)["\'][^>]*\/?>/is', '![$1]($2)', $text);
  $text = preg_replace('/<img[^>]*src=["\']([^"\']*)["\'][^>]*\/?>/is', '![]($1)', $text);

  // Convert blockquotes
  $text = preg_replace_callback('/<blockquote[^>]*>(.*?)<\/blockquote>/is', function($matches) {
    $quote = strip_tags($matches[1]);
    $lines = explode("\n", trim($quote));
    return "\n" . implode("\n", array_map(function($line) {
      return '> ' . trim($line);
    }, $lines)) . "\n";
  }, $text);

  // Convert code blocks
  $text = preg_replace('/<pre[^>]*><code[^>]*>(.*?)<\/code><\/pre>/is', "\n```\n$1\n```\n", $text);
  $text = preg_replace('/<code[^>]*>(.*?)<\/code>/is', '`$1`', $text);

  // Convert lists
  $text = preg_replace_callback('/<ul[^>]*>(.*?)<\/ul>/is', function($matches) {
    return preg_replace('/<li[^>]*>(.*?)<\/li>/is', "- $1\n", $matches[1]);
  }, $text);

  $text = preg_replace_callback('/<ol[^>]*>(.*?)<\/ol>/is', function($matches) {
    $counter = 0;
    return preg_replace_callback('/<li[^>]*>(.*?)<\/li>/is', function($m) use (&$counter) {
      $counter++;
      return "{$counter}. {$m[1]}\n";
    }, $matches[1]);
  }, $text);

  // Convert paragraphs
  $text = preg_replace('/<p[^>]*>(.*?)<\/p>/is', "\n$1\n", $text);

  // Convert line breaks
  $text = preg_replace('/<br\s*\/?>/i', "\n", $text);

  // Convert horizontal rules
  $text = preg_replace('/<hr\s*\/?>/i', "\n---\n", $text);

  // Remove remaining HTML tags
  $text = strip_tags($text);

  // Clean up whitespace
  $text = preg_replace('/\n{3,}/', "\n\n", $text);
  $text = trim($text);

  return $text;
}

/**
 * Clear llms.txt cache when content changes
 */
function hypatia_clear_llms_cache($post_id) {
  delete_transient('hypatia_llms_txt');
}
add_action('save_post', 'hypatia_clear_llms_cache');
add_action('delete_post', 'hypatia_clear_llms_cache');

/**
 * Flush rewrite rules on theme activation
 */
function hypatia_llm_flush_rules() {
  hypatia_llm_rewrite_rules();
  flush_rewrite_rules();
}
add_action('after_switch_theme', 'hypatia_llm_flush_rules');
