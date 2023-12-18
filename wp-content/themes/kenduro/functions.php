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

// add_action( 'woocommerce_before_cart', 'add_columns');

// function add_columns() {
//   echo '<div class="container"><div class="row"><div class="col">';
// }

// add_action( 'woocommerce_after_cart', 'add_additional_products_section');

// function add_additional_products_section() {
//   echo '</div></div></div>';
// }