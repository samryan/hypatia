<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
  <link rel="manifest" href="/manifest.json">
</head>
<body <?php body_class(); ?>>
  <div id="page">
    <header class="site-header clear">
      <div class="container">
        <nav id="site-navigation" class="container main-navigation" role="navigation">
          <span id="toggle-menu">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="#FFF" d="M16.4 9H3.6c-.552 0-.6.447-.6 1 0 .553.048 1 .6 1h12.8c.552 0 .6-.447.6-1s-.048-1-.6-1zm0 4H3.6c-.552 0-.6.447-.6 1 0 .553.048 1 .6 1h12.8c.552 0 .6-.447.6-1s-.048-1-.6-1zM3.6 7h12.8c.552 0 .6-.447.6-1s-.048-1-.6-1H3.6c-.552 0-.6.447-.6 1s.048 1 .6 1z"/></svg>
          </span>
          <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
          <ul>
            <li><a href="/books">Reading</a></li>
            <li><a href="/projects">Projects</a></li>
            <li><?php get_search_form(); ?></li>
          </ul>
        </nav>
      </div>
    </header>
    <div class="content">
