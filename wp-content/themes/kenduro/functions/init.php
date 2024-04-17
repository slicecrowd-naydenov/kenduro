<?php

use Lean\Load;


if (!is_admin()) {
  include 'create-categories.php';
  include 'create-products.php';
  include 'create-filters.php';
  include 'create-brands.php';
  include 'ss-create-order.php';
  include 'get-column-fields.php';
  // include 'filter.php';
  include 'woo-recently-viewed-products.php';
  include 'woo-product-images.php';
  include 'woo-header-cart-button.php';
  include 'woo-checkout-fields.php';
  include 'woo-create-orders.php';
} 

function add_custom_query_var($vars) {
  $vars[] = 'page';

  return $vars;
}
add_filter('query_vars', 'add_custom_query_var');

/**
 * Change the Focus Keyword Limit
 */
add_filter( 'rank_math/focus_keyword/maxtags', function() {
  return 20; // Number of Focus Keywords. 
});

// declare Global var
$fieldsToRemove = ['deleted_date', 'first_created', 'followed_by', 'ranking', 'autonumber', 'comments_count'];
/**
 * Actions on init
 */
function my_custom_init() {
  add_theme_support('post-thumbnails');
  register_custom_menus();
  custom_posts_init();
  // add_get_categories_endpoint();
  // add_get_products_endpoint();
  // get_column_fields_endpoint();
  // add_get_filters_endpoint();
}

// function get_external_api_response($id, $data) {
//   $url = 'https://app.smartsuite.com/api/v1/applications/' . $id . '/records/list/';

//   $headers = array(
//     'Content-Type: application/json',
//     'Authorization: Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
//     'ACCOUNT-ID: sd0y91s2',
//   );

//   $ch = curl_init($url);

//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//   curl_setopt($ch, CURLOPT_POST, true);
//   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//   $response = curl_exec($ch);

//   if (curl_errno($ch)) {
//       return new WP_Error('api_error', 'Error fetching data from get_external_api_response: ' . curl_error($ch), array('status' => 500));
//   }

//   curl_close($ch);

//   return json_decode($response, true);
// }


function get_column_fields($id) {
  $response = wp_remote_request(
    'https://app.smartsuite.com/api/v1/applications/' . $id,
    array(
      'method' => 'GET',
      'headers' => array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
        'ACCOUNT-ID' => 'sd0y91s2',
      ),
    )
  );

  if (is_wp_error($response)) {
    return new WP_Error('api_error', 'Error fetching data from get_column_fields', array('status' => 500));
  }

  return json_decode(wp_remote_retrieve_body($response), true);
}

function get_record($tableId, $recordId) {
  $response = wp_remote_request(
    'https://app.smartsuite.com/api/v1/applications/' . $tableId . '/records/' . $recordId,
    array(
      'method' => 'GET',
      'headers' => array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
        'ACCOUNT-ID' => 'sd0y91s2',
      ),
    )
  );

  if (is_wp_error($response)) {
    return new WP_Error('api_error', 'Error fetching data from get_column_fields', array('status' => 500));
  }

  return json_decode(wp_remote_retrieve_body($response), true);
}

function post_column_fields($id) {
  $response = wp_remote_request(
    'https://app.smartsuite.com/api/v1/applications/' . $id . '/records/list/',
    array(
      'method' => 'POST',
      'headers' => array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
        'ACCOUNT-ID' => 'sd0y91s2',
      ),
    )
  );

  if (is_wp_error($response)) {
    return new WP_Error('api_error', 'Error fetching data from get_column_fields', array('status' => 500));
  }

  return json_decode(wp_remote_retrieve_body($response), true);
}

function post_column_fields_limit($id, $limit = 5, $offset = 0) {
  $response = wp_remote_request(
    'https://app.smartsuite.com/api/v1/applications/' . $id . '/records/list/?limit='.$limit.'&offset='.$offset,
    array(
      'method' => 'POST',
      'headers' => array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
        'ACCOUNT-ID' => 'sd0y91s2',
      ),
    )
  );

  if (is_wp_error($response)) {
    return new WP_Error('api_error', 'Error fetching data from get_column_fields', array('status' => 500));
  }

  return json_decode(wp_remote_retrieve_body($response), true);
}

function get_column_fields_related($id) {
  $response = wp_remote_request(
    'https://app.smartsuite.com/api/v1/applications/' . $id . '/records/records_with_related/',
    array(
      'method' => 'GET',
      'headers' => array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
        'ACCOUNT-ID' => 'sd0y91s2',
      ),
    )
  );

  if (is_wp_error($response)) {
    return new WP_Error('api_error', 'Error fetching data from get_column_fields', array('status' => 500));
  }

  return json_decode(wp_remote_retrieve_body($response), true);
}

function filter_items($items, $fieldsToRemove) {
  $filteredItems = array_map(function ($item) use ($fieldsToRemove) {
    foreach ($fieldsToRemove as $field) {
      unset($item[$field]);
    }
    return $item;
  }, $items);

  return $filteredItems;
}

function update_acf($fields, $id, $is_cat_prefix) {
  $repeater_key = 'meta_data';
  $values_to_update = [];

  foreach ($fields as $field_name => $field_value) {
    $value = is_array($field_value) ? json_encode($field_value) : $field_value;
    $values_to_update[] = [
      'key' => $field_name,
      'value' => $value
    ];
  }
  if ($is_cat_prefix) {
    update_field($repeater_key, $values_to_update, 'product_cat_' . $id);
  } else {
    update_field($repeater_key, $values_to_update, $id);
  }
}

// function fetch_records_in_app($app_id) {
//   $url = 'http://localhost:3003/api/v1/applications/'.$app_id.'/records/list/';

//   $response = wp_remote_post($url, array(
//     'body' => json_encode(array()),
//     'headers' => array(
//       'Content-Type' => 'application/json',
//       'Authorization' => 'Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
//       'ACCOUNT-ID' => 'sd0y91s2'
//     ),
//   ));

//   if (is_wp_error($response)) {
//     echo 'Error fetching data from REST API: ' . $response->get_error_message();
//     return;
//   }

//   $body = wp_remote_retrieve_body($response);
//   $data = json_decode($body, true);

//   return $data;
// }

// filter
function my_posts_where($where) {
  // echo $where;
  // echo '<br>';
  $where = str_replace("meta_key = 'meta_data_$", "meta_key LIKE 'meta_data_%", $where);

  return $where;
}

add_filter( 'woocommerce_single_product_carousel_options', 'sf_update_woo_flexslider_options' );
/** 
 * Filer WooCommerce Flexslider options - Add Navigation Arrows
 */
function sf_update_woo_flexslider_options( $options ) {
    $options['directionNav'] = true;
    $options['controlNav'] = wp_is_mobile() ? true : 'thumbnails';
    // $options['animationLoop'] = true;
    // $options['sync'] = '.flex-control-thumbs';
    // $options['sync'] = '.flex-control-thumbs';
    // $options['animation'] = 'fade';

    return $options;
}
add_theme_support( 'wc-product-gallery-slider' ); 

add_shortcode('pricefilter', 'price_filter');
function price_filter($atts) {
  Load::molecules('filter-price/index');
}

function custom_pagination($numpages = '', $pagerange = '', $paged = '') {

  if (empty($pagerange)) {
    $pagerange = 5;
  }

  global $paged;

  if (empty($paged)) {
    $paged = 1;
  }

  if ($numpages == '') {
    global $wp_query;

    $numpages = $wp_query->max_num_pages;

    if (!$numpages) {
      $numpages = 1;
    }
  }

  $pagination_args = array(
    'base'            => get_pagenum_link(1) . '%_%',
    'format'          => 'page/%#%/',
    'total'           => $numpages,
    'current'         => $paged,
    'show_all'        => False,
    'end_size'        => 1,
    'mid_size'        => $pagerange,
    'prev_next'       => True,
    'prev_text'       => __('Prev'),
    'next_text'       => __('Next'),
    'type'            => 'plain',
    'add_args'        => false,
    'add_fragment'    => ''
  );

  $paginate_links = paginate_links($pagination_args);

  if ($paginate_links) {
    echo '<div class="row">';
    echo '<div class="col">';
    echo "<div class='blog-pagination' data-animation-element='' data-animation-trigger=''>";
    // echo "<div class='left'>Страница " . $paged . " от " . $numpages . "</div> ";
    echo "<div class='right'>" . $paginate_links . "</div> ";
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
}

add_filter('posts_where', 'my_posts_where');
add_action('init', 'my_custom_init');

/**
 * Change the breadcrumb separator
 */
// add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_delimiter' );
// add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_delimiter', 20 );
// function wcc_change_breadcrumb_delimiter( $defaults ) {
// 	// Change the breadcrumb delimeter from '/' to '>'
// 	$defaults['delimiter'] = ' &#47; ';
// 	return $defaults;
// }

// add_filter('woocommerce_output_related_products_args', 'jk_related_products_args', 20);
// function jk_related_products_args($args) {
//   $args['posts_per_page'] = 4; // 4 related products
//   $args['columns'] = 4; // arranged in 2 columns
//   return $args;
// }

// add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
// function wpdocs_theme_setup() { 
//   add_image_size( 'category_thumb', 0, 180, true );
// }


function category_has_parent() {
  $category = get_queried_object();

  if ($category->parent > 0) {
    return true;
  }
  return false;
}

function check_valid_nonce($request) {
  $nonce = $request->get_header('X-WP-Nonce');
  if (!empty($nonce) && wp_verify_nonce($nonce, 'wp_rest')) {
    return true; // returns true if nonce is valid
  }
  return false; // returns false if nonce is not valid
}


// Add Variation Settings
add_action('woocommerce_product_after_variable_attributes', 'variation_settings_fields', 10, 3);

// Save Variation Settings
add_action('woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2);

/**
 * Create new fields for variations
 *
 */
function variation_settings_fields($loop, $variation_data, $variation) {
  // Text Field
  woocommerce_wp_text_input(
    array(
      'id'          => '_my_product_variation_id[' . $variation->ID . ']',
      'label'       => __('Variation Product ID', 'woocommerce'),
      'placeholder' => '65278c07fde1f03c6c9cf763',
      'desc_tip'    => 'true',
      'description' => __('Enter Product Variation ID here.', 'woocommerce'),
      'value'       => get_post_meta($variation->ID, '_my_product_variation_id', true)
    )
  );
}
/**
 * Save new fields for variations
 *
 */
function save_variation_settings_fields($post_id) {
  // Text Field
  $my_custom_field = $_POST['_my_product_variation_id'][$post_id];
  if (!empty($my_custom_field)) {
    update_post_meta($post_id, '_my_product_variation_id', esc_attr($my_custom_field));
  }

}


// Add New Variation Settings
add_filter('woocommerce_available_variation', 'load_variation_settings_fields');

/**
 * Add custom fields for variations
 *
 */
function load_variation_settings_fields($variations) {
  // Text Field
  $variations['my_custom_field'] = get_post_meta($variations['variation_id'], '_my_product_variation_id', true);

  return $variations;
}

// Get related values of Linked records
function related_records(&$records, $keyToModify, $existingIds) {
  foreach ($records as &$record) {
    $record[$keyToModify] = array_values(array_intersect($record[$keyToModify], $existingIds));
  }
}

add_filter('nav_menu_submenu_css_class','nav_menu_classes', 10, 3 );
function nav_menu_classes( $classes, $args, $depth ){
  foreach ( $classes as $key => $class ) {
    if ( $depth == 0) {
      $classes[ $key ] = 'sub-menu';
    } elseif ( $depth == 1) {
      $classes[ $key ] = 'sub-sub-menu';
    }
  } 
  return $classes;
}

function url_get_contents ($Url) {
  if (!function_exists('curl_init')){ 
    die('CURL is not installed!');
  }
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $Url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $output = curl_exec($ch);
  curl_close($ch);
  return $output;
}

/**
 * Trim zeros in price decimals
 **/
add_filter( 'woocommerce_price_trim_zeros', '__return_true' );

function featured_product_child_menu_item($item_output, $item, $depth, $args) {
  // Check we are on the right menu & right depth
  $featured_product_ID = get_field('featured_product', 'options');

  if (is_array($featured_product_ID) && !wp_is_mobile()) {
    if ($args->theme_location != 'primary' || $depth !== 1 || !in_array('main-category-link', $item->classes)) {
      return $item_output;
    } else {
      $new_output = $item_output;
      $new_output .= '<div class="product-of-the-week"><p class="paragraph paragraph-m regular">Продукт на седмицата</p>'.do_shortcode('[product id='.$featured_product_ID[0].']');'</div>'; // Add custom elems
    
      return $new_output;
    }
  
  } else {
    return $item_output;
  }
}
add_filter('walker_nav_menu_start_el', 'featured_product_child_menu_item', 10, 4);


// YITH show placeholder if missing image when we searching products
add_filter('ywcas_searching_result_data','ywcas_searching_result_data_fix_thumb', 10, 5);
function ywcas_searching_result_data_fix_thumb( $search_result_data, $query_string, $lang, $post_type, $category ) {

foreach( $search_result_data as $item => $values ) {
  if ( 'product' === $values['post_type'] ) {
    if ( empty( $values['thumbnail']['small'] ) ) {
      $search_result_data[$item]['thumbnail']['small'] = wc_placeholder_img_src();
    }
    
    if ( empty( $values['thumbnail']['big'] ) ) {
      $search_result_data[$item]['thumbnail']['big'] = wc_placeholder_img_src();
    }
  }
}

return $search_result_data;
}