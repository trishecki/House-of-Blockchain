<?php

function myhob_files() {
  wp_enqueue_style('myhob_main_style',  get_stylesheet_uri(), NULL, microtime());
  wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyD5RpyAt1-2-ZFmJut9Ju5Awvf0WnS6RsI', NULL, '1.0', true);
  wp_enqueue_script('GoogleMaplocal', get_theme_file_uri( '/assets/scripts/modules/GoogleMap.js'), NULL, '1.0', true);
  wp_enqueue_script('myhob_main_script', get_theme_file_uri( '/assets/scripts/scripts.js'), NULL, '1.0', true);
  wp_enqueue_script('myhob_jquery', get_theme_file_uri( '/assets/scripts/frameworks/jquery-3.2.1.min.js'), NULL, '1.0', true);
  wp_enqueue_script('myhob_ham', get_theme_file_uri( '/assets/scripts/modules/hamburger.js'), NULL, '1.0', true);
  wp_enqueue_script('myhob_slider', get_theme_file_uri( '/assets/scripts/modules/slider.js'), NULL, '1.0', true);
  wp_enqueue_script('myhob_calendar', get_theme_file_uri( '/assets/scripts/modules/calendar.js'), NULL, '1.0', true);
  wp_enqueue_script('myhob_nav', get_theme_file_uri( '/assets/scripts/modules/nav_bar.js'), NULL, '1.0', true);
  wp_enqueue_script('parallax', get_theme_file_uri( '/assets/scripts/modules/parallax.js'), NULL, '1.0', true);
  wp_enqueue_script('stars', get_theme_file_uri( '/assets/scripts/modules/stars.js'), NULL, '1.0', true);
  wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css', Null, microtime());

}
add_action('wp_enqueue_scripts', 'myhob_files');

function myhob_features(){
  add_theme_support('title-tag');
}
add_action('after_setup_theme', 'myhob_features');


function myhobMapKey($api){
  $api[key] ='AIzaSyD5RpyAt1-2-ZFmJut9Ju5Awvf0WnS6RsI';
  return $api;
}

add_filter('acf/fields/google_map/api', 'myhobMapKey');

function myhob_adjust_queries($query){
  if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }
}

add_action('pre_get_posts', 'myhob_adjust_queries');


add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar(){
  $ourCurrentUser = wp_get_current_user();

  if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    show_admin_bar(false);
  }
}

// Customize Login Screen

add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl(){
  return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS(){
  wp_enqueue_style('myhob_main_style',  get_stylesheet_uri(), NULL, microtime());
}



// Redirect Login to FrontPage

add_action('admin_init', 'redirectSubstoFrontend');

function redirectSubstoFrontend(){
  $ourCurrentUser = wp_get_current_user();

  if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'admin') {
    wp_redirect(site_url('/news'));
    exit;
  }
}







function add_svg_to_upload_mimes($upload_mimes)
	{
	$upload_mimes['svg'] = 'image/svg+xml';
	$upload_mimes['svgz'] = 'image/svg+xml';
	return $upload_mimes;
	}
add_filter('upload_mimes', 'add_svg_to_upload_mimes');

define('ALLOW_UNFILTERED_UPLOADS', true);

?>