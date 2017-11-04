<?php // Custom Functions

  /* Head Functions */

  // Enqueue Styles and Scripts
  if(!is_admin()) {
    function enqueue_scripts() {
      // Theme Stylesheet
      wp_enqueue_style('theme_style', get_stylesheet_uri(), "", "2.1.4");
      // Theme Scripts
      wp_enqueue_script('theme_scripts', get_stylesheet_directory_uri() . '/assets/scripts/build.min.js', array('jquery'), "", true);
    }
    add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );
    // Remove query strings from static resources
    function _remove_script_version( $src ){
      $parts = explode( '?', $src );
      return $parts[0];
    }
    add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
    add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
    // Remove jQuery Migrate
    add_filter( 'wp_default_scripts', 'remove_jquery_migrate' );
    function remove_jquery_migrate( &$scripts) {
      if(!is_admin()) {
        $scripts->remove( 'jquery');
        $scripts->add( 'jquery', false, array( 'jquery-core' ), '3.2.1' );
      }
    }
    // Defer Scripts
    add_filter( 'script_loader_tag', 'wsds_defer_scripts', 10, 3 );
    function wsds_defer_scripts( $tag, $handle, $src ) {
      // The handles of the enqueued scripts we want to defer
      $defer_scripts = array(
        'theme_scripts',
        'admin-bar',
        'wp-embed'
      );
      if ( in_array( $handle, $defer_scripts ) ) {
        return '<script src="' . $src . '" defer type="text/javascript"></script>' . "\n";
      }
      return $tag;
    }
  } // End if is not admin

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

  // Add Featured Images to Posts
  add_theme_support( 'post-thumbnails' );

  // After Post Save Callback to Generate Static Pages
  add_action('transition_post_status', 'export_new_post', 10, 3);
  function export_new_post($new_status, $old_status, $post) {
    if($new_status === 'publish' && $post->post_type === 'post') {
      // Put URL to fire static site build here

      // 'Working' test code
      // $ch = curl_init('https://mdms-devel.owenscorning.com/api/v1/validzip');
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      // $output = curl_exec($ch);
      // wp_redirect( home_url($output) ); exit;
    }
  }

?>
