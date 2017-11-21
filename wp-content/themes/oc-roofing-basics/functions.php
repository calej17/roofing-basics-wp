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

  // Update Login Page Logo URL
  function my_login_logo_url() {
    return home_url();
  }
  add_filter( 'login_headerurl', 'my_login_logo_url' );

  // Add Okta SSO Login Link to Login Page
  function add_okta_sso_login() {
    echo "<div class='custom-login-module'>";
    echo do_shortcode("[mo_oauth_login]");
    echo "</div>";
  }
  add_filter('login_message', 'add_okta_sso_login');


  /* ----- Post Functions ----- */

  // Add Featured Images to Posts
  add_theme_support( 'post-thumbnails' );

  // Remove p tags from content images
  add_filter( 'the_content', 'remove_some_ptags' );
  function remove_some_ptags( $content ) {
    $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    return $content;
  }

  // Require Featured Image
  function require_featured_image($post_id) {
    // Limit affected post type.
    if (get_post_type($post_id) !== 'post') {
      return;
    }

    // Skip Featured Image check when on new post page, or deleting a post.
    $statuses_to_ignore = array('auto-draft', 'trash');
    $status = get_post_status($post_id);
    if (in_array($status, $statuses_to_ignore)) {
      return;
    }

    // Save as draft, and fire flash message if Featured Image is missing.
    if (!has_post_thumbnail($post_id)) {
      // Set a transient to show the users an admin message.
      set_transient("has_post_thumbnail", "no");
      // Unhook this function so it doesn't loop infinitely.
      remove_action('save_post', 'require_featured_image');
      // Update the post set it to draft.
      wp_update_post(array('ID' => $post_id, 'post_status' => 'draft'));
      add_action('save_post', 'require_featured_image');
    }
    else {
      delete_transient("has_post_thumbnail");
    }
  } // End require_featured_image
  add_action('save_post', 'require_featured_image');

  // Show Required Featured Image flash message when adding / editing posts.
  function required_featured_image_flash() {
    if (get_transient("has_post_thumbnail") == "no") {
      echo "<div id='message' class='error'><p>Please select a Featured Image before publishing. Your post has been saved as a draft.</p></div>";
      delete_transient("has_post_thumbnail");
    }
  } // End required_featured_image_flash
  add_action('admin_notices', 'required_featured_image_flash');

  // Update "Post Published" messaging if saving as draft.
  function update_published_messaging($location, $post_id) {
    if (isset($_POST['publish'])) {
      $status = get_post_status( $post_id );
      // The post was 'published', but if it is still a draft, display draft message (10).
      if( $status == 'draft' ) {
        $location = add_query_arg('message', 10, $location);
      }
    }

    return $location;
  } // End update_published_messaging
  add_filter('redirect_post_location', 'update_published_messaging', 10, 2);

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
