<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hypatia
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/grade.js"></script>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/responsive-nav.min.js"></script>
</head>

<body <?php body_class(); ?>>
  <div id="page">
    <header class="header">
      <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
      <nav id="site-navigation" class="main-navigation" role="navigation">
        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
	      <?php get_search_form(); ?>
      </nav>
      <a href="#nav" class="nav-toggle" aria-hidden="false">Menu</a>
    </header>
    <div class="content">
