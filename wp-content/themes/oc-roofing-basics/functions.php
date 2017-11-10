<?php // Custom Functions

  /* ----- Head Functions ------ */

  // Enqueue Styles and Scripts
    if(!is_admin()) {
      // Theme Stylesheet
      wp_enqueue_style('theme_style', get_stylesheet_uri(), "", "1.2");
      // Theme Scripts
      wp_enqueue_script('theme_scripts', get_stylesheet_directory_uri() . '/assets/scripts/build.min.js', array('jquery'), false, true);
      // wp_enqueue_script('sharethis', '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-582cd07f6a10f588', array(), '', true);

      // Remove jQuery Migrate
      add_filter( 'wp_default_scripts', 'remove_jquery_migrate' );
      function remove_jquery_migrate( &$scripts) {
        if(!is_admin()) {
          $scripts->remove( 'jquery');
          $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.12.4' );
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
            return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
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

  // Remove p tags from content images
  add_filter( 'the_content', 'remove_some_ptags' );
  function remove_some_ptags( $content ) {
    $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    return $content;
  }

  // After Post Save Callback to Generate Static Pages
  add_action('transition_post_status', 'export_new_post', 10, 3);
  function export_new_post($new_status, $old_status, $post) {
    if($new_status === 'publish' && $post->post_type === 'post') {
      // Put URL to fire static site build here;
      // Replace test code below

      // $ch = curl_init('https://mdms-devel.owenscorning.com/api/v1/validzip');
      // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      // $output = curl_exec($ch);
      // wp_redirect( home_url($output) ); exit;
    }
  }

?>
