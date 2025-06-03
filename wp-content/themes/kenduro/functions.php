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
  echo '<script type="text/javascript">';
  echo 'var ajaxurl = "' . admin_url('admin-ajax.php') . '";';

  if (is_product()) {
    global $post;
    echo 'var woocommerce_single_product_id = ' . intval($post->ID) . ';';
  }

  echo '</script>';
}
add_action('wp_head', 'add_ajaxurl_to_front');

function load_more_products_callback() {
	$page     = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$cat      = sanitize_text_field($_GET['category']);
	$ids      = sanitize_text_field($_GET['ids']);
	$taxonomy = sanitize_text_field($_GET['taxonomy'] ?? '');
	$term     = sanitize_text_field($_GET['term'] ?? '');

	$shortcode = '[products limit="32" columns="4" paginate="false" page="' . $page . '"';

	if (!empty($cat)) {
		$shortcode .= ' category="' . $cat . '"';
	}

	if (!empty($ids)) {
		$shortcode .= ' ids="' . $ids . '"';
	}

	// Ако имаме специфична таксономия и термин (например pa_brand / michelin)
	if ($taxonomy === 'pa_brand' && !empty($term)) {
		$shortcode .= ' attribute="brand" terms="' . $term . '"';
	}

	$shortcode .= ']';

	echo do_shortcode($shortcode);
	wp_die();
}

add_action('wp_ajax_load_more_products', 'load_more_products_callback');
add_action('wp_ajax_nopriv_load_more_products', 'load_more_products_callback');

add_action( 'init', function() {
	// we're using a different hook priority (30 instead of 10) 
	remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 30 );
	// we're removing a different function from the hook
	remove_action( 'woocommerce_before_shop_loop', 'storefront_woocommerce_pagination', 30 );
} );

add_filter('woocommerce_package_rates', 'custom_shipping_if_tyre_mix', 10, 2);

function custom_shipping_if_tyre_mix($rates, $package) {
  $excluded_categories = ['motocross-tyres', 'enduro-tyres'];
  $free_shipping_min_amount = 149.00;
  $non_excluded_total = 0;
  $has_excluded_product = false;

  foreach ($package['contents'] as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $product = wc_get_product($product_id);
    $line_total = $product->get_price() * $quantity;

    if (has_term($excluded_categories, 'product_cat', $product_id)) {
      $has_excluded_product = true;
    } else {
      $non_excluded_total += $line_total;
    }
  }

  // Само ако има поне един продукт от изключените категории И
  // ако стойността на останалите продукти е под прага
  if ($has_excluded_product && $non_excluded_total < $free_shipping_min_amount) {
    // Задаваме фиксирани цени за woo_bg_econt
    foreach ($rates as $rate_id => $rate) {
      if ($rate->method_id === 'woo_bg_econt') {
        if (strpos($rate->label, 'адрес') !== false) {
          $rates[$rate_id]->cost = 7.50;
          $rates[$rate_id]->label = 'Доставка до адрес';
        } elseif (strpos($rate->label, 'Офис') !== false) {
          $rates[$rate_id]->cost = 5.00;
          $rates[$rate_id]->label = 'Вземи от Офис на ЕКОНТ';
        }
      }
    }
  }

  return $rates;
}

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













// add_action('wp_ajax_apply_loyalty_points', 'ajax_apply_loyalty_points');
// add_action('wp_ajax_nopriv_apply_loyalty_points', 'ajax_apply_loyalty_points');

// function ajax_apply_loyalty_points() {
//     check_ajax_referer('apply_points_nonce', 'security');

//     if (!is_user_logged_in()) {
//         wp_send_json(['success' => false, 'message' => 'Трябва да сте влезли в профила си.']);
//     }

//     $user_id = get_current_user_id();
//     $available_points = (int) get_field('user_points', 'user_' . $user_id);
//     $requested_points = (int) $_POST['points'];

//     if ($requested_points <= 0 || $requested_points > $available_points) {
//         wp_send_json(['success' => false, 'message' => 'Невалиден брой точки.']);
//     }

//     $coupon_code = 'points_' . $requested_points;

//     // Проверка дали вече има създаден такъв купон
//     $coupon = get_posts([
//       'title'        => $coupon_code,
//       'post_type'    => 'shop_coupon',
//       'post_status'  => 'publish',
//       'numberposts'  => 1,
//     ]);

//     if (empty($coupon)) {
//       $coupon_id = wp_insert_post([
//           'post_title'  => $coupon_code,
//           'post_status' => 'publish',
//           'post_type'   => 'shop_coupon',
//           'post_author' => 1,
//       ]);
  
//       update_post_meta($coupon_id, 'discount_type', 'fixed_cart');
//       update_post_meta($coupon_id, 'coupon_amount', $requested_points);
//       update_post_meta($coupon_id, 'individual_use', 'yes');
//       update_post_meta($coupon_id, 'usage_limit', 1);
//       update_post_meta($coupon_id, 'customer_email', get_userdata($user_id)->user_email);

//     }

//     // update_post_meta($coupon_id, 'expiry_date', date('Y-m-d', strtotime('+1 day')));

//     // Прилагане на купона
//     // WC()->cart->add_discount($coupon_code);

//     // Намаляване на точките
//     // $new_balance = $available_points - $requested_points;
//     // update_field('user_points', $new_balance, 'user_' . $user_id);

//     wp_send_json(['success' => true, 'message' => '<span style="color:green;">Успешно приложихте ' . $requested_points . ' точки като отстъпка!</span>']);
// }

// add_filter('woocommerce_coupon_is_valid', 'validate_points_coupon_user_and_balance', 10, 2);

// function validate_points_coupon_user_and_balance($is_valid, $coupon) {
//     $code = $coupon->get_code();

//     // Работим само с нашите купони
//     if (strpos($code, 'points_') !== 0) {
//         return $is_valid;
//     }

//     // Ако потребителят не е логнат, не може да използва точки
//     if (!is_user_logged_in()) {
//         return false;
//     }

//     $user_id = get_current_user_id();
//     $user = wp_get_current_user();
//     $user_email = $user->user_email;

//     // Сигурна проверка по имейл
//     $allowed_email = get_post_meta($coupon->get_id(), 'customer_email', true);
//     if ($allowed_email && strtolower($allowed_email) !== strtolower($user_email)) {
//         return false;
//     }

//     // Проверка за реален брой точки
//     $requested_points = (int) str_replace('points_', '', $code);
//     $user_points = (int) get_field('user_points', 'user_' . $user_id);

//     if ($requested_points > $user_points) {
//         return false;
//     }

//     return true;
// }












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
