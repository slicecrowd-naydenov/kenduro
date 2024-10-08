<?php
define('ICON_PATH', get_stylesheet_directory_uri() . '/assets/icons/svg');
define('IMAGES_PATH', get_stylesheet_directory_uri() . '/assets/images');

require_once get_stylesheet_directory() . '/patterns/vendor/autoload.php';

/**
 * Templates loader
 */
require_once get_stylesheet_directory() . '/functions/loader.php';

/**
 * Custom post types
 */
require_once get_stylesheet_directory() . '/functions/custom-posts.php';

/**
 * Custom menu functions
 */
require_once get_stylesheet_directory() . '/functions/menus.php';

/**
 * Add theme scripts
 */
require_once get_stylesheet_directory() . '/functions/assets.php';

/**
 * Actions on init
 */
require_once get_stylesheet_directory() . '/functions/init.php';

/**
 * Actions on ACF Options page
 */
require_once get_stylesheet_directory() . '/functions/acf-options.php';

function pretty_dump($data) {
  echo '<pre>' . var_export($data, true) . '</pre>';
}

function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

// Delete Woo Transients when we create products
add_action('wp_ajax_clear_woocommerce_transients', 'clear_woocommerce_transients_callback');
add_action('wp_ajax_nopriv_clear_woocommerce_transients', 'clear_woocommerce_transients_callback');

function clear_woocommerce_transients_callback() {
  // Изтриване на транзиентите
  delete_transient('wc_transients_cache');

  // Връщане на отговор
  echo 'Транзиентите са изтрити успешно.';
  wp_die();
}

function add_ajaxurl_to_front() {
  echo '<script type="text/javascript">
      var ajaxurl = "' . admin_url('admin-ajax.php') . '";
  </script>';
}
add_action('wp_head', 'add_ajaxurl_to_front');

add_filter('woocommerce_dropdown_variation_attribute_options_args','fun_select_default_option',10,1);
function fun_select_default_option( $args) { 
  if(count($args['options']) > 0) //Check the count of available options in dropdown
    $args['selected'] = $args['options'][0];
    return $args;
}

function load_products_on_homepage_via_ajax() {
  $category_id = intval($_POST['category_id']);
  
  $products = do_shortcode("[products category='$category_id' limit='10' columns='5']");
  
  echo $products;
  wp_die();
}

// Регистрирай AJAX екшъните за автентифицирани и неавтентифицирани потребители
add_action('wp_ajax_load_products', 'load_products_on_homepage_via_ajax');
add_action('wp_ajax_nopriv_load_products', 'load_products_on_homepage_via_ajax');

// Improve Google pagespeed
function remove_additional_libs_script() {
    // Премахни React-DOM скрипта
    wp_deregister_script('jquery-ui-core');
}
add_action('wp_enqueue_scripts', 'remove_additional_libs_script', 100);