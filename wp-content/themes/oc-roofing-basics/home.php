<?php get_header(); ?>
<section class="content">
  <div class="wrap">
    <p>Roofing total protection roofing system. Warranty Surenail shingle contractor guarantee, shingles design duration ventilation warranty. Oakridge hip and ridge starter shingle recycling algae resistance. TruDefinition weather roof underlayment protection Berkshire, WeatherGuard intake vents defend VentSure.</p>
    <?php
    if ( have_posts() ) while ( have_posts() ) : the_post();
      $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 5600,1000 ), false, '' );
      $index = $wp_query->current_post; ?>
      <a class="post-card <?php echo ($index < 2) ? "half" : "" ?>" href="<?php echo get_the_permalink(); ?>">
        <div class="post-card-image" style="background-image: url('<?php echo $src[0]; ?>')"></div>
        <div class="post-card-text">
          <h2><?php echo get_the_title(); ?></h2>
        </div>
      </a>
    <?php endwhile; ?>
  </div>
</section>
<?php get_footer(); ?>
