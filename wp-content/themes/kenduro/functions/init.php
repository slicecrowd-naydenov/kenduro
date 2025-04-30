<?php

use Lean\Load;


if (!is_admin()) {
  include 'create-categories.php';
  include 'create-products.php';
  include 'create-filters.php';
  include 'create-brands.php';
  include 'create-bike-models.php';
  include 'ss-create-order.php';
  include 'get-column-fields.php';
  // include 'filter.php';
  // include 'woo-recently-viewed-products.php';
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
  // $site_aliases = [
  //   1 => 'main',
  //   2 => 'old',
  //   3 => 'hebo',
  //   4 => 'michelin',
  //   5 => 'fmparts',
  //   6 => 'kabat'
  // ];

  // Ако blog_id съвпада с някой ключ от масива – го взимаме, иначе fallback на 'main'
  // define('CURRENT_SITE_ALIAS', $site_aliases[get_current_blog_id()] ?? 'main');
  // if (defined('CURRENT_SITE_ALIAS') && CURRENT_SITE_ALIAS !== 'main')
}

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
    return new WP_Error('api_error', 'Error fetching data from get_record', array('status' => 500));
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
    return new WP_Error('api_error', 'Error fetching data from post_column_fields', array('status' => 500));
  }

  return json_decode(wp_remote_retrieve_body($response), true);
}

function post_column_fields_limit($id, $limit = 5, $offset = 0) {
  $ss_fields = get_field('ss_fields', 'option');
  $link_to_product_variations = $ss_fields['link_to_product_variations'];
  $upload_update_to_wordpress = $ss_fields['upload_update_to_wordpress'];

  $last_date_mass_update = get_field('last_date_mass_update', 'option') ? get_field('last_date_mass_update', 'option') : date("Y-m-d"); 
  $date_today = date("Y-m-d");
  
  $body = json_encode(array(
    "filter" => array(
      "operator" => "and",
      "fields" => array(
        array(
          "field" => $link_to_product_variations,  // Field: Link to Product Variations
          "comparison" => "is_not_empty",
          "value" => ""
        ),
        array(
          "field" => $upload_update_to_wordpress,  // Field: Upload/Update to Wordpress
          "comparison" => "is",
          "value" => true
        ),
        array(
          "field" => "last_updated",
          "comparison" => "is",
          "value" => array(
            "date_mode" => "date_range",
            "date_mode_value" => array(
              "lower"=> $last_date_mass_update,
              "upper"=> $date_today
            )
          )
        )
      )
    )
  ));

  $response = wp_remote_request(
    'https://app.smartsuite.com/api/v1/applications/' . $id . '/records/list/?limit='.$limit.'&offset='.$offset,
    array(
      'method' => 'POST',
      'headers' => array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
        'ACCOUNT-ID' => 'sd0y91s2',
      ),
      'body' => $body
    )
  );

  if (is_wp_error($response)) {
    return new WP_Error('api_error', 'Error fetching data from post_column_fields_limit', array('status' => 500));
  }

  return json_decode(wp_remote_retrieve_body($response), true);
}

// function post_column_fields_compare($id) {
//   $ss_fields = get_field('ss_fields', 'option');
//   $link_to_product_variations = $ss_fields['link_to_product_variations'];
//   $upload_update_to_wordpress = $ss_fields['upload_update_to_wordpress'];
//   $supported_bikes_chatgpt = $ss_fields['supported_bikes_chatgpt'];
//   $body = json_encode(array(
//     "filter" => array(
//       "operator" => "and",
//       "fields" => array(
//         array(
//           "field" => $link_to_product_variations,  // Field: Link to Product Variations
//           "comparison" => "is_not_empty",
//           "value" => ""
//         ),
//         array(
//           "field" => $upload_update_to_wordpress,  // Field: Upload/Update to Wordpress
//           "comparison" => "is",
//           "value" => true
//         ),
//         array(
//           "field" => $supported_bikes_chatgpt,
//           "comparison" => "is_not_empty",
//           "value" => ""
//         )
//       )
//     )
//   ));
//   $response = wp_remote_request(
//     'https://app.smartsuite.com/api/v1/applications/' . $id . '/records/list/',
//     array(
//       'method' => 'POST',
//       'headers' => array(
//         'Content-Type' => 'application/json',
//         'Authorization' => 'Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
//         'ACCOUNT-ID' => 'sd0y91s2',
//       ),
//       'body' => $body
//     )
//   );
//   if (is_wp_error($response)) {
//     return new WP_Error('api_error', 'Error fetching data from post_column_fields_limit', array('status' => 500));
//   }
//   return json_decode(wp_remote_retrieve_body($response), true);
// }

function update_record_curl($appId, $dataBody, $recordId) {
  $url = 'https://app.smartsuite.com/api/v1/applications/' . $appId . '/records/' . $recordId . '/';

  $headers = array(
    'Content-Type: application/json',
    'Authorization: Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
    'ACCOUNT-ID: sd0y91s2'
  );

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Използваме PUT метод
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataBody)); // Подаваме тялото на заявката
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);

  if (curl_errno($ch)) {
    return new WP_Error('api_error', 'Error fetching data from API: ' . curl_error($ch), array('status' => 500));
  }

  curl_close($ch);
  
  return json_decode($response, true);
}

function get_column_fields_related($id) {
  $response = wp_remote_request(
    'https://app.smartsuite.com/api/v1/applications/' . $id . '/records/records_with_related/?nojsoncompress',
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
    return new WP_Error('api_error', 'Error fetching data from get_column_fields_related', array('status' => 500));
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

  // New Text Field for Delivery Time
  woocommerce_wp_text_input(
    array(
      'id'          => '_my_delivery_time_text[' . $variation->ID . ']',
      'label'       => __('Delivery Time', 'woocommerce'),
      'placeholder' => '3-6 дни',
      'desc_tip'    => 'true',
      'description' => __('Enter Delivery Time here.', 'woocommerce'),
      'value'       => get_post_meta($variation->ID, '_my_delivery_time_text', true)
    )
  );

  // Checkbox for Disable on Frontend
  woocommerce_wp_checkbox(
    array(
      'id'            => '_disable_in_website[' . $variation->ID . ']',
      'label'         => __('Disable in Website', 'woocommerce'),
      'desc_tip'    => 'true',
      'description'   => __('Check this box to disable this variation on the frontend.', 'woocommerce'),
      'value'         => get_post_meta($variation->ID, '_disable_in_website', true),
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

  // New Text Field for Delivery Time
  if (isset($_POST['_my_delivery_time_text'][$post_id])) {
    $delivery_time_text = $_POST['_my_delivery_time_text'][$post_id];
    if (!empty($delivery_time_text)) {
      update_post_meta($post_id, '_my_delivery_time_text', esc_attr($delivery_time_text));
    }
  }

  $disable_in_website = isset($_POST['_disable_in_website'][$post_id]) ? 'yes' : 'no';
  update_post_meta($post_id, '_disable_in_website', $disable_in_website);
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

  // New Text Field for Delivery Time
  $variations['delivery_time_text'] = get_post_meta($variations['variation_id'], '_my_delivery_time_text', true);

  $disable_in_website = get_post_meta($variations['variation_id'], '_disable_in_website', true);

  // Премахване на вариацията, ако е маркирана за скриване
  if ($disable_in_website === 'yes') {
    return false;
  }


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
  $wp_nav_menu_cached = get_transient('wp_nav_menu_cached');
  if (false === $wp_nav_menu_cached) {
    foreach ( $classes as $key => $class ) {
      if ( $depth == 0) {
        $classes[ $key ] = 'sub-menu';
      } elseif ( $depth == 1) {
        $classes[ $key ] = 'sub-sub-menu';
      }
    } 
    return $classes;
  }
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
  if (!wp_is_mobile()) {
    $featured_product_ID = get_field('featured_product', 'options');

    if (is_array($featured_product_ID)) {
      if ($args->theme_location == 'primary' && $depth === 1 && in_array('main-category-link', $item->classes)) {
        // Add custom elements only for desktop
        $new_output = $item_output;
        $new_output .= '<div class="product-of-the-week"><p class="paragraph paragraph-m regular">Продукт на седмицата</p>' . do_shortcode('[product id='.$featured_product_ID[0].']') . '</div>';
        return $new_output;
      }
    }
  }

  return $item_output;
}
add_filter('walker_nav_menu_start_el', 'featured_product_child_menu_item', 10, 4);


// YITH show placeholder if missing image when we searching products
// add_filter('ywcas_searching_result_data','ywcas_searching_result_data_fix_thumb', 10, 5);
// function ywcas_searching_result_data_fix_thumb( $search_result_data, $query_string, $lang, $post_type, $category ) {

//   foreach( $search_result_data as $item => $values ) {
//     if ( 'product' === $values['post_type'] ) {
//       if ( empty( $values['thumbnail']['small'] ) ) {
//         $search_result_data[$item]['thumbnail']['small'] = wc_placeholder_img_src();
//       }
      
//       if ( empty( $values['thumbnail']['big'] ) ) {
//         $search_result_data[$item]['thumbnail']['big'] = wc_placeholder_img_src();
//       }
//     }
//   }

//   return $search_result_data;
// }

function filter_loop_shop_per_page( $products ) {
  // if ( wp_is_mobile() ) {
  //     $products = 6;
  // } else {
  //     $products = 16;
  // }

  // OR shorthand
  // $products = wp_is_mobile() ? 6 : 16;
  $products = 16;

  return $products;
}
add_filter( 'loop_shop_per_page', 'filter_loop_shop_per_page', 10, 1 );

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form');
add_action( 'woocommerce_before_cart_collaterals', 'woocommerce_checkout_coupon_form');

function update_cart_discounts() {
  ob_start();

	Load::molecules('cart-discount-container/index');

  $content = ob_get_clean();
  echo $content;
  wp_die();
}

add_action('wp_ajax_update_cart_discounts', 'update_cart_discounts');
add_action('wp_ajax_nopriv_update_cart_discounts', 'update_cart_discounts');

add_action('wp_ajax_get_recently_viewed_products', 'get_recently_viewed_products_callback');
add_action('wp_ajax_nopriv_get_recently_viewed_products', 'get_recently_viewed_products_callback');

function get_recently_viewed_products_callback() {
  if (empty($_POST['ids'])) {
      wp_die();
  }

  $viewed_products = array_map('absint', explode(',', $_POST['ids']));
  $viewed_products = array_slice(array_unique($viewed_products), 0, 15);

  if (empty($viewed_products)) {
      wp_die();
  }

  $limit_products = wp_is_mobile() ? 2 : 5;
  $product_ids = implode(",", $viewed_products);

  $title = '<div class="popular-categories__header">
    <p class="paragraph paragraph-xl semibold primary">Последно разглеждани продукти</p>
  </div><hr>';

  echo '<div class="recently-viewed-products">';
  echo $title;
  echo do_shortcode("[products ids='$product_ids' orderby='post__in' order='ASC' columns='5' limit='$limit_products']");
  echo '</div>';

  wp_die();
}


function custom_coupon_error_message($msg, $err_code, $coupon) {
  switch ($err_code) {
    case WC_Coupon::E_WC_COUPON_NOT_EXIST:
      return __('Купонът не съществува!', 'woocommerce');
    case WC_Coupon::E_WC_COUPON_ALREADY_APPLIED :
      return __('Купонът вече е използван!', 'woocommerce');
    case WC_Coupon::E_WC_COUPON_EXPIRED:
      return __('Купонът е изтекъл!', 'woocommerce');
    case WC_Coupon::E_WC_COUPON_PLEASE_ENTER:
      return __('Моля въведете код!', 'woocommerce');

    // Добави още случаи според нуждите си
    default:
      return $msg;
  }
}
add_filter('woocommerce_coupon_error', 'custom_coupon_error_message', 10, 3);

// get all brands
function get_all_bike_brands() {
  $brands = get_terms(array(
    'taxonomy' => 'bike-brand',
    'hide_empty' => true, // Показване само на термини с публикации
  ));

  if (!empty($brands) && !is_wp_error($brands)) {
    // Сортиране на марките азбучно по име
    usort($brands, function ($a, $b) {
      return strcmp($a->name, $b->name); // Сравнение по име
    });

    // Извеждане на опциите
    foreach ($brands as $brand) {
      if (strtolower($brand->slug) === 'all') {
        continue;
      }
      echo '<option value="' . esc_attr($brand->name) . '">' . esc_html($brand->name) . '</option>';
    }
  }
}

// Ajax request to get all models by brand
add_action('wp_ajax_get_models_by_brand', 'get_models_by_brand');
add_action('wp_ajax_nopriv_get_models_by_brand', 'get_models_by_brand');
function get_models_by_brand() {
  $selected_brand = $_POST['brand'];

  $query = new WP_Query(array(
    'post_type' => 'compatibility',
    'tax_query' => array(
      array(
        'taxonomy' => 'bike-brand',
        'field' => 'name',
        'terms' => $selected_brand,
      ),
    ),
    'posts_per_page' => -1,
    'fields' => 'ids'
  ));

  if ($query->have_posts()) {
    $models = array();
    while ($query->have_posts()) {
      $query->the_post();
      $models[] = get_the_title(get_the_ID()); // Събиране на заглавията
    }

    // Сортиране на моделите азбучно
    natcasesort($models);

    // Извеждане на опциите
    foreach ($models as $model_title) {
      if (strtolower($model_title) === 'all') {
        continue;
      }
      echo '<option value="' . esc_attr($model_title) . '">' . esc_html($model_title) . '</option>';
    }
    wp_reset_postdata(); // Възстановяваме глобалната променлива post
  }

  wp_die(); // Close Ajax request
}

// Ajax request to get all years by model
add_action('wp_ajax_get_years_by_model', 'get_years_by_model');
add_action('wp_ajax_nopriv_get_years_by_model', 'get_years_by_model');
function get_years_by_model() {
  $selected_model = $_POST['model'];

  $query = new WP_Query(array(
    'post_type' => 'compatibility',
    'title' => $selected_model,
    'posts_per_page' => 1,
    'fields' => 'ids'
  ));

  if ($query->have_posts()) {
    $model_post_id = $query->posts[0];

    $years = get_the_terms($model_post_id, 'bike-year');

    if ($years && !is_wp_error($years)) {
      // Сортиране на годините от по-голяма към по-малка
      usort($years, function ($a, $b) {
        return intval($b->name) - intval($a->name); // Сравняване по числова стойност
      });

      // Извеждане на сортираните опции
      foreach ($years as $year) {
        if (strtolower($year->slug) === 'all') {
          continue;
        }
        echo '<option value="' . esc_attr($year->name) . '">' . esc_html($year->name) . '</option>';
      }
    }
  }

  wp_die(); // Затваряне на Ajax заявката
}


// bike compatibility modal
function remove_hyphen_after_first_and_before_last_word($string) {
	// Разбиване на стринга на масив от думи, разделени по тирета
	$parts = explode('-', $string);

	// Ако стрингът съдържа повече от една дума
	if (count($parts) > 2) {
		// Присъединяване на първата дума с останалата част, като се добавя интервал след първата дума
		$first_part = array_shift($parts);
		$last_part = array_pop($parts);
		$string = $first_part . ' ' . implode('-', $parts) . ' ' . $last_part;
	}

	return $string;
}

function check_is_set_bike_compatibility() {
  return isset($_COOKIE['bikeCompatibility']) ? $_COOKIE['bikeCompatibility'] : '';
}

function output_filter_modal($get_product_cat, $promo_checked, $promo_link) {
	if (wp_is_mobile()) {
		?>
		<!-- Button trigger modal -->
		<button type="button" class="button filter-modal" data-toggle="modal" data-target="#filterModal">
			Филтри
		</button>

		<!-- Modal -->
		<div class="modal fade mobile-modal" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Филтри</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<?php Load::atom('svg', ['name' => 'close']); ?>
						</button>
					</div>
					<div class="modal-body">
						<?php
							Load::molecules('product-category/product-categories-filter/index');
							
							if ($get_product_cat !== null) : ?>
								<label class="checkbox promo-products-filter">
									<input type="checkbox" <?php echo esc_attr($promo_checked); ?>>
									<span class="optional"></span> 
									<a href="<?php echo esc_url($promo_link); ?>">Промо продукти</a>
								</label>
							<?php endif;
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	} else {
		Load::molecules('product-category/product-categories-filter/index');
	}
}

add_action('woocommerce_order_status_changed', function($order_id, $status_from, $status_to, $order) {
  $ss_ids = get_field('ss_ids', 'option');
  $invoices_tab_id = $ss_ids['invoices'];
  $invoice_id = get_field('invoice_id', $order_id);
  
  if ($status_to === 'processing') {
    $dataBody = array(
      'status' => array(
        'value' => 'backlog'
      ),
    );
    update_record_curl($invoices_tab_id, $dataBody , $invoice_id);
    // error_log("Поръчка #$order_id е направена");

    // error_log("Поръчка #$order_id смени статуса си от $status_from на $status_to");
  }

  if ($status_to === 'completed') {  
    $dataBody = array(
        'status' => array(
          'value' => 'complete'
        ),
      );
      update_record_curl($invoices_tab_id, $dataBody , $invoice_id);
  }

  if ($status_to === 'cancelled') {
    $dataBody = array(
      'status' => array(
        'value' => 'NEGL9'
      ),
    );
    update_record_curl($invoices_tab_id, $dataBody , $invoice_id);
  }
}, 10, 4);

// Премахваме оригиналната функция
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

// Добавяме нашата нова версия с <h3>
add_action( 'woocommerce_shop_loop_item_title', 'custom_woocommerce_template_loop_product_title', 10 );
function custom_woocommerce_template_loop_product_title() {
	echo '<h3 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ) . '">' . get_the_title() . '</h3>';
}