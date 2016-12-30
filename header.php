<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <?php /*<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/grade.js"></script>*/ ?>
  <?php /*<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/responsive-nav.min.js"></script>*/ ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/grade.js"></script>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/hypatia.js"></script>
</head>
<body <?php body_class(); ?>>
  <div id="page">
    <header class="site-header clear bg-default">
      <div class="container">
        <nav id="site-navigation" class="container main-navigation" role="navigation">
          <span class="entypo-menu" id="toggle-menu"></span>
          <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
          <?php /* wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) );  */ ?>
          <ul>
            <li><a href="/blog">Blog</a></li>
            <li><a href="/books">Reading</a></li>
            <li><a href="/projects">Projects</a></li>
            <li><?php get_search_form(); ?></li>
          </ul>
        </nav>
      </div>
    </header>
    <div class="content">
