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
 * Enqueue scripts and styles.
 */
function hypatia_scripts() {
	wp_enqueue_style( 'hypatia-style', get_stylesheet_uri(), array(), filemtime( get_stylesheet_directory() . '/style.css' ) );
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
  if ( ! is_page( 193 ) ) return;

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
      background: transparent;
      border: none;
      box-shadow: none;
      padding: 1rem;
    }
    .tobii__btn--close:focus { outline: none; box-shadow: none; }
    .tobii__btn--close:focus-visible { outline: 2px solid white; outline-offset: 2px; }
    .tobii__btn--close svg { display: none; }
    .tobii__btn--close::after {
      content: '';
      display: block;
      width: 2rem;
      height: 2rem;
      background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23ffffff' viewBox='0 0 256 256'%3E%3Cpath d='M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z'%3E%3C/path%3E%3C/svg%3E\");
      background-size: contain;
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
      window.tobiiInstance = new Tobii({ selector: '.lightbox', zoom: false, counter: false, nav: false });
      document.querySelector('.tobii').addEventListener('click', function(e) {
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
  $has_highlights = have_rows('book_quotes', $post_id);

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

  // Overview link
  $overview_class = (strpos($current_url, '/books/') !== false && strpos($current_url, '/list-') === false) ? ' class="current-menu-item"' : '';
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
    $output .= '<img src="' . esc_url($thumbnail) . '" class="book" alt="" />';
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
 * Set dynamic default for year_read ACF field to current year
 */
function hypatia_year_read_default($field) {
  $field['default_value'] = date('Y');
  return $field;
}
add_filter('acf/load_field/name=year_read', 'hypatia_year_read_default');
