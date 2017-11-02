<!DOCTYPE html>
<html>
  <head itemscope itemtype="http://schema.org/WebSite">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0" />
    <title itemprop='name'><?php render_site_title(); ?></title>
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(get_post_type($post)); ?>>
    <header>
      <div class="wrap">
        header
      </div>
    </header>
