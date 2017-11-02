<?php // Custom Functions

  /* Head Functions */

  // Render Page Title
  function render_site_title() {
    if(!is_front_page()) {
      if ( is_home() ) {
        $object = get_queried_object();
        echo get_the_title( $object );

      } elseif ( is_category() ) {
        echo single_cat_title("", false);

      } elseif ( is_tax() ) {
        $object = get_queried_object();
        echo $object->name;

      } else {
        echo wp_title("", false);
      }
      echo " | ";
    }
    echo get_bloginfo('name');
  }

  /* Post Functions */

  // After Post Save Callback to Generate Static Pages
  add_action('transition_post_status', 'export_new_post', 10, 3);
  function export_new_post($new_status, $old_status, $post) {
    if($new_status === 'publish' && $post->post_type === 'post') {
      // Do something!
      wp_redirect( home_url('/test') ); exit;
    }
  }

?>
