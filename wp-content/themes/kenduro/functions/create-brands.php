<?php

add_action('rest_api_init', 'add_get_brands_endpoint');
function add_get_brands_endpoint() {
  register_rest_route(
    'ss-data',
    '/get-brands/(?P<id>[^/]+)',
    array(
      'methods' => 'GET',
      'callback' => 'get_all_brands',
      'permission_callback' => function ($request) {
        return true;
      }
    )
  );
}

function get_all_brands($request) {
  global $fieldsToRemove;
  $id = $request->get_param('id');

  $external_api_response = post_column_fields($id);

  if (is_wp_error($external_api_response)) {
    return $external_api_response;
  }

  $filteredData = filter_items($external_api_response['items'], $fieldsToRemove);

  create_woocommerce_brands($filteredData);

  return $filteredData;
}

function createBrandTerms(
  array $item, 
  string $taxonomy, 
  bool $exclusive_brand, 
  int $order = 0, 
  int $image_id = 0,
  int $logo_id = 0
): ?\WP_Term {
  $taxonomy = wc_attribute_taxonomy_name($taxonomy);
  $termName = $item['title'];
  // $termSlug = $item['id'];
  // $ss_ids = get_field('ss_ids', 'option');
  $iso_date = $item['last_updated']['on'];
  $current_date = new DateTime('now', new DateTimeZone('Europe/Sofia'));
  $date_now = $current_date->format('Y-m-d\TH:i:s.u\Z');
  $is_exclusive_brand = $exclusive_brand ? 1 : 0;
  $brand_description = isset($item['description']['html']) ? $item['description']['html'] : '';
  // $brand_description = str_replace(array('<div class="rendered">', '</div>'), '', $brand_description);
  
  if (!$term = get_term_by('slug', $termName, $taxonomy)) {
    $term = wp_insert_term($termName, $taxonomy, array(
      'slug' => $termName
    ));
    $term = get_term_by('id', $term['term_id'], $taxonomy);
    $term_id = $term->term_id;
    if ($term) {
      update_term_meta($term_id, 'order', $order);
		  update_term_meta($term_id, 'date_created', $date_now);
		  update_term_meta($term_id, 'date_modified', $date_now);
      update_term_meta($term_id, 'exclusive_brand', $is_exclusive_brand);
      update_term_meta($term_id, 'exclusive_banner', $image_id);
      update_term_meta($term_id, 'exclusive_logo', $logo_id);
      update_term_meta($term_id, 'brand_description', $brand_description);
    }
  } else {
    $term_id = $term->term_id;
    $get_term = get_term_meta($term_id);
    // Transform ISO 8601 format in Unix timestamp
    $timestamp = strtotime($iso_date);
    $ss_updated_product_date = new WC_DateTime(date('Y-m-d H:i:s', $timestamp), new DateTimeZone('UTC'));
    $ss_timestamp = $ss_updated_product_date->getTimestamp();
    $woo_updated_product_date = new DateTime($get_term['date_modified'][0]);
    $woo_timestamp = $woo_updated_product_date->getTimestamp();
    if ($ss_timestamp >= $woo_timestamp) {
		  update_term_meta($term_id, 'date_modified', $date_now);
      update_term_meta($term_id, 'exclusive_brand', $is_exclusive_brand);
      update_term_meta($term_id, 'exclusive_banner', $image_id);
      update_term_meta($term_id, 'exclusive_logo', $logo_id);
      update_term_meta($term_id, 'brand_description', $brand_description);
    }
  }
  return $term;
}

function create_woocommerce_brands($filteredData) {
  $ss_ids = get_field('ss_ids', 'option');
  $filter_brands = fetch_column_fields($ss_ids['filter_brands']);
  $exclusive_brands = get_column_field_id('exclusive_brands', $filter_brands);
  $exclusive_banner = get_column_field_id('exclusive_banner', $filter_brands);
  $exclusive_logo = get_column_field_id('exclusive_logo', $filter_brands);
  $banner_id = 0;
  $logo_id = 0;
  //exclusive_banner 

  $count = 1; 
  foreach ($filteredData as $item) {
    $count++;

    $bannerArr = isset($item[$exclusive_banner]) ? $item[$exclusive_banner] : array();
    $logoArr = isset($item[$exclusive_logo]) ? $item[$exclusive_logo] : array();

    if (count($bannerArr) > 0) {
      foreach ($bannerArr as $image) {
        $banner_id = getFileURL($image['handle'], $image['metadata']['filename']);
      }
    }

    if (count($logoArr) > 0) {
      foreach ($logoArr as $image) {
        $logo_id = getFileURL($image['handle'], $image['metadata']['filename']);
      }
    }

    // if ($count >= 5) {
    //   break;
    // }

    createBrandTerms($item, 'brand', false, $count, $banner_id, $logo_id);
    // pretty_dump($item[$exclusive_brands]);
  }
}
