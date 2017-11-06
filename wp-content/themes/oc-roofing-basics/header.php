<!DOCTYPE html>
<html>
  <head itemscope itemtype="http://schema.org/WebSite">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0" />
    <title itemprop='name'><?php render_site_title(); ?></title>
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(get_post_type($post)); ?>>
    <?php get_template_part('shared/svg-sprite'); ?>
    <header>
      <div class="wrap">
        <a class="logo" href="/">
          <svg><use xlink:href="#logo" /></svg>
        </a>
        <nav>
          <a href="#">Roofing Basics</a>
          <a href="#">Pick Your Shingles</a>
          <a href="#">Warrantly</a>
          <a href="#">Find a Contractor</a>
          <a href="#">Professional Roofers</a>
        </nav>
        <form class="search">
          <input name="search" placeholder="Search" type="text" />
        </form>
      </div>
    </header>
