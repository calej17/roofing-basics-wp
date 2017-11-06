<?php
get_header();
if ( have_posts() ) while ( have_posts() ) : the_post();
  $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 5600,1000 ), false, '' ); ?>

  <section class="hero single-post" style="background-image: url('<?php echo $src[0]; ?>')">
    <h1><?php the_title(); ?></h1>
  </section>
  <section class="content single-post">
    <div class="wrap">
      <?php the_content(); ?>
    </div>
  </section>

<?php
endwhile;
get_footer();
?>
