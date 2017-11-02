<?php get_header(); ?>
<section class="main-content">
  <div class="wrap">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </div>
</section>
<?php get_footer(); ?>
