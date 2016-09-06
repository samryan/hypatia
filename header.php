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
  <script type="text/javascript">
    window.addEventListener('load', function(){ Grade(document.querySelectorAll('.grade')); });
  </script>
</head>

<body <?php body_class(); ?>>
  <div id="page">
    <header class="header">
      <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
      <nav id="site-navigation" class="main-navigation" role="navigation">
        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
      </nav>
      <?php get_search_form(); ?>
    </header>
    <div class="content">
