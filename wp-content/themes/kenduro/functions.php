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

add_filter('woocommerce_dropdown_variation_attribute_options_args', 'select_first_available_option', 10, 1);
function select_first_available_option($args) {
  global $product;

  if (!empty($args['options']) && is_object($product)) {
    // Извличаме наличните опции за атрибута
    $available_variations = $product->get_available_variations();
    $valid_options = [];

    foreach ($available_variations as $variation) {
      $attribute_key = 'attribute_' . $args['attribute'];
      if (isset($variation['attributes'][$attribute_key])) {
        $valid_options[] = $variation['attributes'][$attribute_key];
      }
    }

    // Намираме първата активна опция
    foreach ($args['options'] as $option) {
      if (in_array($option, $valid_options)) {
        $args['selected'] = $option;
        break;
      }
    }
  }

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

// modify pagination structure on [products] shortcode
add_filter( 'woocommerce_shortcode_products_query', 'custom_shortcode_pagination' );
function custom_shortcode_pagination( $query_args ) {
  if ( is_shop() || is_product_taxonomy() ) {
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $query_args['paged'] = $paged;
  }
  return $query_args;
}

add_filter( 'woocommerce_pagination_args', 'custom_pagination_args' );
function custom_pagination_args( $args ) {
  if ( is_shop() || is_product_taxonomy() ) {
    $args['base'] = str_replace( '999999999', '%#%', get_pagenum_link( 999999999 ) );
    $args['format'] = '/page/%#%';
  }
  return $args;
}

// Филтър за промяна на каноничния URL
// add_filter( 'rank_math/frontend/canonical', function( $canonical ) {
//   $current_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  
//   // Ако в URL има "product-page=", използваме този параметър за каноничния линк
//   if (strpos($current_url, '?product-page=') !== false) {
//       $canonical = strtok($current_url, '#'); // Премахваме hash, ако съществува
//   }

//   return $canonical;
// });



// add_filter( "rank_math/frontend/next_rel_link", function( $link ) {
//   // Проверяваме дали има "page/" в линка
//   // $total   = isset($total) ? $total : wc_get_loop_prop('total_pages');
//   // $current = isset($current) ? $current : wc_get_loop_prop('current_page');
//   // $base    = isset($base) ? $base : esc_url_raw(add_query_arg('product-page', '%#%', remove_query_arg('add-to-cart')));
//   $product_page = isset($_GET['product-page']) ? (int) $_GET['product-page'] : 1;

//   if (strpos($link, '/page/') !== false) {
//     // Преобразуваме "page/X" в "?product-page=X"
//     $link = preg_replace('#/page/(\d+)#', '?product-page='.$product_page + 1, $link);
//   }
//   return $link;
// });

// add_filter( "rank_math/frontend/prev_rel_link", function( $link ) {
//   // Извличаме текущата стойност на "product-page" от URL
//   error_log('Generated Prev Link: ' . $link); // Записваме в логовете
// });




// add_action('wp_ajax_ql_woocommerce_ajax_add_to_cart', 'ql_woocommerce_ajax_add_to_cart'); 
// add_action('wp_ajax_nopriv_ql_woocommerce_ajax_add_to_cart', 'ql_woocommerce_ajax_add_to_cart');      
// function ql_woocommerce_ajax_add_to_cart() {  
//   $product_id = apply_filters('ql_woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
//   $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
//   $variation_id = absint($_POST['variation_id']);
//   $passed_validation = apply_filters('ql_woocommerce_add_to_cart_validation', true, $product_id, $quantity);
//   $product_status = get_post_status($product_id); 
//   if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) { 
//     do_action('ql_woocommerce_ajax_added_to_cart', $product_id);
//     // if ('yes' === get_option('ql_woocommerce_cart_redirect_after_add')) { 
//     //   wc_add_to_cart_message(array($product_id => $quantity), true); 
//     // } 

//     WC_AJAX::get_refreshed_fragments(); 
//   } else { 
//     $data = array( 
//       'error' => true,
//       'product_url' => apply_filters('ql_woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
//     );
//     echo wp_send_json($data);
//   }
//   wp_die();
// }
