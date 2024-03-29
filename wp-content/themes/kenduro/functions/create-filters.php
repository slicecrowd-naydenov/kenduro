<?php

add_action('rest_api_init', 'add_get_filters_endpoint');
function add_get_filters_endpoint() {
  register_rest_route(
    'ss-data',
    '/get-filters/(?P<id>[^/]+)',
    array(
      'methods' => 'GET',
      'callback' => 'get_all_filters',
      'permission_callback' => function ($request) {
        return check_valid_nonce($request);
      }
    )
  );
}

function get_all_filters($request) {
  global $fieldsToRemove;
  $ss_ids = get_field('ss_ids', 'option');

  // $data = $request->get_json_params();
  $id = $request->get_param('id');

  $external_api_response = post_column_fields($id);
  $related_records = get_column_fields_related($id);
  $filters = fetch_column_fields($ss_ids['filters_id']);
  $filter_values = get_column_field_id('filter_values', $filters);
  $existing_ids = array_column($related_records['related_records'], 'id');

  if (is_wp_error($external_api_response)) {
    return $external_api_response;
  }


  related_records($external_api_response['items'], $filter_values, $existing_ids);

  $filteredData = filter_items($external_api_response['items'], $fieldsToRemove);

  create_woocommerce_filters($filteredData);

  return $filteredData;
}

function createAttribute(string $attributeName, string $attributeSlug): ?\stdClass {
  delete_transient('wc_attribute_taxonomies');
  \WC_Cache_Helper::incr_cache_prefix('woocommerce-attributes');

  $attributeLabels = wp_list_pluck(wc_get_attribute_taxonomies(), 'attribute_label', 'attribute_name');
  $attributeWCName = array_search($attributeSlug, $attributeLabels, TRUE);

  if (!$attributeWCName) {
    $attributeWCName = wc_sanitize_taxonomy_name($attributeSlug);
  }

  $attributeId = wc_attribute_taxonomy_id_by_name($attributeWCName);
  if (!$attributeId) {
    $taxonomyName = wc_attribute_taxonomy_name($attributeWCName);
    unregister_taxonomy($taxonomyName);
    $attributeId = wc_create_attribute(array(
      'name' => $attributeName,
      'slug' => $attributeSlug,
      'type' => 'select',
      'order_by' => 'menu_order',
      'has_archives' => 0,
    ));

    register_taxonomy($taxonomyName, apply_filters('woocommerce_taxonomy_objects_' . $taxonomyName, array(
      'product'
    )), apply_filters('woocommerce_taxonomy_args_' . $taxonomyName, array(
      'labels' => array(
        'name' => $attributeSlug,
      ),
      'hierarchical' => FALSE,
      'show_ui' => FALSE,
      'query_var' => TRUE,
      'rewrite' => FALSE,
    )));
  }

  return wc_get_attribute($attributeId);
}

function createTerm(string $termName, string $termSlug, string $taxonomy, int $order = 0): ?\WP_Term {
  $taxonomy = wc_attribute_taxonomy_name($taxonomy);

  if (!$term = get_term_by('slug', $termSlug, $taxonomy)) {
    $term = wp_insert_term($termName, $taxonomy, array(
      'slug' => $termSlug,
    ));
    $term = get_term_by('id', $term['term_id'], $taxonomy);
    if ($term) {
      update_term_meta($term->term_id, 'order', $order);
    }
  }

  return $term;
}

function create_woocommerce_filters($filteredData) {
  $ss_ids = get_field('ss_ids', 'option');
  $filter_values = post_column_fields($ss_ids['filter_values']);
  $related_records = get_column_fields_related($ss_ids['filter_values']);
  $existing_ids = array_column($related_records['related_records'], 'id');
  $filter_column_fields = fetch_column_fields($ss_ids['filters_id']);
  $filter_values_column_fields = fetch_column_fields($ss_ids['filter_values']);
  $get_field_slug = get_column_field_id('filter_name', $filter_values_column_fields);
  $value_name_bg = get_column_field_id('value_name_bg', $filter_values_column_fields);
  $filter_name_bg = get_column_field_id('filter_name_bg', $filter_column_fields);
  related_records($filter_values['items'], $get_field_slug, $existing_ids);

  foreach ($filteredData as $item) {
		createAttribute($item[$filter_name_bg], $item['id']);
    createAllTerms($filter_values['items'], $get_field_slug, $item['id'], $value_name_bg);

    // createAttribute('Colors', 'my-colors');
		// createTerm('Green', 'my-green', 'my-colors', 20);
		// createTerm('Blue', 'my-blue', 'my-colors', 30);
  }
}

function createAllTerms($values, $field_slug, $item_id, $name_bg) {
  $count = 1; 
  foreach ($values as $value) {
    $count++;
    if ($value[$field_slug][0] === $item_id) {
      createTerm($value[$name_bg], $value['id'], $item_id, $count);
    }
  }
}
