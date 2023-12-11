<?php

add_action('rest_api_init', 'add_get_categories_endpoint');
function add_get_categories_endpoint() {
  register_rest_route(
    'ss-data',
    '/get-categories/(?P<id>[^/]+)',
    array(
      'methods' => 'GET',
      'callback' => 'get_all_categories',
      'permission_callback' => function ($request) {
        return check_valid_nonce($request);
      }
    )
  );
}

function get_all_categories($request) {
  global $fieldsToRemove;

  $data = $request->get_json_params();
  $id = $request->get_param('id');

  $external_api_response = get_external_api_response($id, $data);

  if (is_wp_error($external_api_response)) {
    return $external_api_response;
  }
  
  $filteredData = filter_items($external_api_response['items'], $fieldsToRemove);

  create_woocommerce_categories($filteredData);

  return $filteredData;
}

function is_exist_cat($id, $cats) {
  $result = 0;
  foreach ($cats as $cat) {
    $acf_fileds = get_field('meta_data', 'product_cat_' . $cat->term_id);

    if ($acf_fileds) {
      foreach ($acf_fileds as $acf_filed) {
        if ($acf_filed['key'] === 'id' && $acf_filed['value'] === $id) {
          $result = $cat->term_id;
          break;
        }
      }
    }

    if ($result) {
      break;
    }
  }

  return $result;
}

function create_woocommerce_categories($filteredData) {
  $all_categories = get_categories(array(
    'taxonomy'     => 'product_cat',
    'orderby'      => 'name',
    'show_count'   => 0,
    'pad_counts'   => 0,
    'hierarchical' => 1,
    'title_li'     => '',
    'hide_empty'   => 0
  ));

  global $ss_ids;
  $child_category_id = $ss_ids['child_category_id'];
  $sub_child_category_id = $ss_ids['sub_child_category_id'];
  $child_cat_fields = fetch_column_fields($child_category_id);
  $sub_child_cat_fields = fetch_column_fields($sub_child_category_id);

  $cat_main = get_column_field_id('cat_main', $child_cat_fields);
  $cat_child = get_column_field_id('cat_child', $sub_child_cat_fields);

  foreach ($filteredData as $item) {
    $incoming_id = $item['id'];
    $is_exist = is_exist_cat($incoming_id, $all_categories);
    $is_child = (isset($item[$cat_main][0])) ? is_exist_cat($item[$cat_main][0], $all_categories) : (isset(($item[$cat_child][0])) ? is_exist_cat($item[$cat_child][0], $all_categories) : 0);

    if (!$is_exist) {
      $new_id = wp_insert_term(
        $item['title'], // the term 
        'product_cat',
        array(
          'parent' => $is_child
        )
      );

      if (!is_wp_error($new_id) && $new_id['term_id']) {
        $is_exist = $new_id['term_id'];
      }
    }

    if ($is_exist) {
      update_acf($item, $is_exist, true);
    }
  }
}
