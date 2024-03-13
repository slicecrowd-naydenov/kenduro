<?php

if (!is_admin()) {
  require_once ABSPATH . 'wp-admin/includes/media.php';
  require_once ABSPATH . 'wp-admin/includes/file.php';
  require_once ABSPATH . 'wp-admin/includes/image.php';
}
add_action('rest_api_init', 'add_get_products_endpoint');
// $product_variations = post_column_fields($ss_ids['product_variations']);

function add_get_products_endpoint() {
  register_rest_route(
    'ss-data',
    '/get-products/(?P<id>[^/]+)(?:/(?P<product_id>[^/]+))?',
    array(
      'methods' => 'GET',
      'callback' => 'get_all_products',
      'permission_callback' => function () {
        return true;
      }
    )
  );
}

function get_all_products($request) {
  global $fieldsToRemove;
  $ss_ids = get_field('ss_ids', 'option');
  $product_variations = post_column_fields($ss_ids['product_variations']);


  $data = $request->get_json_params();
  $id = $request->get_param('id');
  $product_id = $request->get_param('product_id');
  $external_api_response = post_column_fields($id);
  $related_records = get_column_fields_related($id);
  $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);
  $product_fields = fetch_column_fields($ss_ids['products_app_id']);
  $product_variation = get_column_field_id('product_variation', $product_variations_fields);
  $product_var_id = get_column_field_id('product_var_id', $product_fields);
  $existing_ids = array_column($related_records['related_records'], 'id');
  $outputArray = array();

  if (is_wp_error($external_api_response)) {
    return $external_api_response;
  }

  // IMPORTANT -> remove unnecessary IDs from Product
  if (!$product_id) {
    related_records($external_api_response['items'], $product_var_id, $existing_ids);
  }

  foreach ($product_variations['items'] as $variation) {
    if (isset($variation[$product_variation]) && is_array($variation[$product_variation])) {
      foreach ($variation[$product_variation] as $value) {
        if (!in_array($value, $outputArray)) {
          $outputArray[] = $value;
        }
      }
    }
  }

  $filteredData = filter_items($external_api_response['items'], $fieldsToRemove);

  $filteredArrays = array_filter($filteredData, function ($item) use ($outputArray) {
    return in_array($item['id'], $outputArray);
  });

  if (!$product_id) {
    // Create product
    create_woocommerce_products($filteredArrays);
  } else {
    // Update product
    $item = get_record($id, $product_id);
    // $filteredArrays = array_filter($filteredData, function ($item) use ($product_id) {
    //   return $item['id'] === $product_id;
    // });
    update_woocommerce_product($item, $id);
  }

  return $filteredArrays;
}

function is_variation_id($id) {
  $result = 0;
  $arr = array(
    'post_type'       => 'product_variation',
    'post_status'     => 'publish',
    'posts_per_page'  => 1,
    'meta_query'      => array(
      'relation'    => 'AND',
      array(
        'key'     => '_my_product_variation_id',
        'value'   => $id,
        'compare' => '='
      )
    ),
  );

  $q = new WP_Query( $arr );

  if ($q->have_posts()) {
    $q->the_post();
    $result = get_the_ID();
  }
  wp_reset_postdata();

  return $result;
}

function is_product_id($id) {
  $result = 0;

  $arr = array(
    'posts_per_page' => 1,
    'post_type' => 'product',
    'meta_query'    => array(
      'relation'      => 'AND',
      array(
        'key'       => 'meta_data_$_key',
        'compare'   => '=',
        'value'     => 'product_variation_id',
      ),
      array(
        'key'       => 'meta_data_$_value',
        'compare'   => '=',
        'value'     => $id,
      )
    )
  );

  $q = new WP_Query($arr);

  if ($q->have_posts()) {
    $q->the_post();
    $result = get_the_ID();
  }

  wp_reset_postdata();

  return $result;
}

function is_exist_product($id) {
  $result = 0;

  $arr = array(
    'posts_per_page' => 1,
    'post_type' => 'product',
    'meta_query'    => array(
      'relation'      => 'AND',
      array(
        'key'       => 'meta_data_$_key',
        'compare'   => '=',
        'value'     => 'id',
      ),
      array(
        'key'       => 'meta_data_$_value',
        'compare'   => '=',
        'value'     => $id,
      )
    )
  );

  $q = new WP_Query($arr);

  if ($q->have_posts()) {
    // $result = $q->posts[0]->ID;
    $q->the_post();
    $result = get_the_ID();
  }

  wp_reset_postdata();

  return $result;
}

function update_product_manually($data, $product_id) {
  $product = wc_get_product($product_id);
  if ($product) {
    $ss_ids = get_field('ss_ids', 'option');
    $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);
    $product_variations_quantity = get_column_field_id('product_variations_quantity', $product_variations_fields);
    $set_regular_price = get_column_field_id('set_regular_price', $product_variations_fields);
	  // $delivery_time = get_column_field_id('delivery_time', $product_variations_fields);

    $quantity = isset($data[$product_variations_quantity]) && (int)$data[$product_variations_quantity] !== 0 ? (int)$data[$product_variations_quantity] : 0;
    $stock_status = $quantity > 0 ? 'instock' : 'onbackorder';
    $manage_stock = $quantity > 0 ? true : false;
    // $delivery_value = $manage_stock ? 'no' : 'notify';
    
    $product->set_manage_stock($manage_stock);
    $product->set_stock_status($stock_status);
    $product->set_backorders('notify');
    $product->set_stock_quantity($quantity);
    $product->set_regular_price($data[$set_regular_price]);
    $product->save();
    // Uncomment this below to force delete woo cache:
    // wc_delete_product_transients($product_id)
  }
}

function is_exist_media($id) {
  $result = 0;
  $arr = array(
    'post_type'      => 'attachment',
    'post_mime_type' => 'image',
    'post_status'    => 'inherit',
    'posts_per_page' => 1,
    'meta_query'      => array(
      'relation'    => 'AND',
      array(
        'key'     => 'ss_image_id',
        'value'   => $id,
        'compare' => '='
      )
    ),
  );

  $q = new WP_Query( $arr );

  if ($q->have_posts()) {
    $q->the_post();
    $result = get_the_ID();
  }
  wp_reset_postdata();

  return $result;
}

function set_values($fields, $product_id, $item) {
  if (!$fields || !$product_id || !$item) {
    return;
  }

  $imageId = 0;

  $all_categories = get_categories(array(
    'taxonomy'     => 'product_cat',
    'orderby'      => 'name',
    'show_count'   => 0,
    'pad_counts'   => 0,
    'hierarchical' => 1,
    'title_li'     => '',
    'hide_empty'   => 0
  ));

  
  // update_post_meta($product_id, 'rank_math_title', 'Update Title goes here');
  // update_post_meta($product_id, 'rank_math_description', 'Update Description goes here');
  // update_post_meta($product_id, '_menu_order', 111);
  $product = wc_get_product($product_id);
  $filtered_data = array();
  $handlesToKeep = array();

  foreach ($fields as $field) {

    if ($field['help_text'] === 'product_name_bg') {
      $product->set_name($item[$field['slug']]);
    } else if ($field['help_text'] === 'set_regular_price') {
      $product->set_regular_price($item[$field['slug']]);
    } else if ($field['help_text'] === 'product_priority') {
      $priority = isset($item[$field['slug']]) && $item[$field['slug']] > 0 ? reverse_number($item[$field['slug']]) : 1001;
      $product->set_menu_order($priority);
    } else if ($field['help_text'] === 'product_description_bg') {
      $html = isset($item[$field['slug']]['html']) ? $item[$field['slug']]['html'] : '';
      $product->set_description($html);
    } else if ($field['help_text'] === 'main_category') {
      $filtered_data[] = isset($item[$field['slug']][0]) ? is_exist_cat($item[$field['slug']][0], $all_categories) : null;
    } else if ($field['help_text'] === 'child_category') {
      $filtered_data[] = isset($item[$field['slug']][0]) ? is_exist_cat($item[$field['slug']][0], $all_categories) : null;
    } else if ($field['help_text'] === 'sub_child_category') {
      $filtered_data[] = isset($item[$field['slug']][0]) ? is_exist_cat($item[$field['slug']][0], $all_categories) : null;
    } else if ($field['help_text'] === 'set_gallery_image_ids') {
      $imagesArr = $item[$field['slug']];

      if (count($imagesArr) > 0) {
        foreach ($imagesArr as $key => $image) {
          $file_urls_arr = getFileURL($image['handle'], $image['metadata']['filename']);
          if ($key != 0) {
            unset($imagesArr[$key]);
            $handlesToKeep[] = $file_urls_arr;
          } else {
            $imageId = $file_urls_arr;
            set_post_thumbnail($product_id, $imageId);
          }
        }
      } 
    } else if ($field['help_text'] === 'show_in_shop') {
      $show_in_shop = $item[$field['slug']] ? 'visible' : 'hidden';
      $product->set_catalog_visibility($show_in_shop);
    } 
    wp_set_post_terms($product_id, $filtered_data, 'product_cat');
  }

  add_img_to_gallery($product_id, $handlesToKeep); 

  // $product->set_name($name_bg);

  $product->save();
}

function get_column_field_id($helper_text, $fetch_variation_columns) {
  $result = null;
  foreach ($fetch_variation_columns as $column) {
    if (isset($column['help_text']) && $column['help_text'] === $helper_text) {
      $result = $column['slug'];
      break;
    }
  }
  
  return $result;
}

function is_variable_product($id, $product_id_slug, $product_variation_slug) {
  $ss_ids = get_field('ss_ids', 'option');
  $product_variations = post_column_fields($ss_ids['product_variations']);
  $result = false;

  foreach ($product_variations['items'] as $product_variation) {
    if (
      $product_variation[$product_id_slug][0] === $id && 
      strtolower($product_variation[$product_variation_slug]) === strtolower('Yes')
    ) {
      $result = true;
      break;
    }
  }

  return $result;
}

function process_product_attributes($product_variation, $filters, $filter_arr, $filter_values) {
  $attributes = array();

  foreach ($product_variation as $key => $product_column) {
    $active_filters = array_filter($filters, function ($filter) use ($key, $product_column) {
      return $filter['slug'] === $key && count($product_column) > 0;
    });
    
    if (count($active_filters) > 0) {
      $active_filters_arr = array_filter($filter_arr['items'], function($f) use ($filter_values, $product_column) {
        return (is_array($f[$filter_values]) && isset($product_column[0]) && in_array($product_column[0], $f[$filter_values]));
      });

      if (count($active_filters_arr) > 0) {
        foreach ($active_filters_arr as $key => $active_filters_value) {
          $attributes['pa_'.$active_filters_value['id']] = $product_column[0];
        }
      }
    }
  }

  return $attributes;
}

function create_variation($pid, $term_slug, $product_variations_fields, $attributes_data) {
  $ss_ids = get_field('ss_ids', 'option');
  $product_variations = post_column_fields($ss_ids['product_variations']);
  $filters = array_filter($product_variations_fields, function($k) {
    return str_starts_with($k['help_text'], 'filter_');
  });
  $filters_id = fetch_column_fields($ss_ids['filters_id']);
  $filter_values = get_column_field_id('filter_values', $filters_id);
  $filter_arr = post_column_fields($ss_ids['filters_id']);
	$product_variations_quantity = get_column_field_id('product_variations_quantity', $product_variations_fields);
  // $parent_product = wc_get_product($pid);
  // $parent_product_sku = $parent_product->get_sku();
	$product_id_slug = get_column_field_id('product_variation', $product_variations_fields);
  $attr_color = get_column_field_id('attr_color', $product_variations_fields);
  $variation_product_id = get_column_field_id('variation_product_id', $product_variations_fields);
  $set_regular_price = get_column_field_id('set_regular_price', $product_variations_fields);

  $filters = array_filter($product_variations_fields, function($k) {
    return str_starts_with($k['help_text'], 'filter_');
  });

  foreach ($product_variations['items'] as $product_variation) {
    if ($product_variation[$product_id_slug][0] === $term_slug) {
      $quantity = isset($product_variation[$product_variations_quantity]) ? $product_variation[$product_variations_quantity] : 0;
      // $stock_status = $quantity > 0 ? 'instock' : 'onbackorder';
      // $manage_stock = $quantity > 0 ? true : false;
      // $delivery_value = $manage_stock ? 'no' : 'notify';
      // $attributes_data = array();
      $attributes = process_product_attributes($product_variation, $filters, $filter_arr, $filter_values);
      
      // $sku = $parent_product_sku.'_';
      foreach ($attributes as $key => $attr) {
        wp_set_object_terms($pid, $attr, $key, true);
        // $sku.= strtoupper($attr.'_');
        $attributes_data[$key] = array(
          'name' => $key,
          'value' => $attr,
          'is_visible' => '1',
          'is_taxonomy' => '1',
          'is_variation' => '1'
        );
      } 
      
      update_post_meta($pid, '_product_attributes', $attributes_data);
      $sale_price = ''; // One day when we add Sale price in SS we have to replace this string with that field from SS

      // Create variation
      $variation = new WC_Product_Variation();
      $variation->set_parent_id($pid);
      $variation->set_attributes($attributes);
      $variation->set_manage_stock(true);
      // $variation->set_stock_status($stock_status);
      $variation->set_backorders('notify');
      $variation->set_stock_quantity($quantity);
      // $variation->set_sku($pid);
      $variation->set_price($sale_price ? $sale_price : $product_variation[$set_regular_price]);
      $variation->set_regular_price($product_variation[$set_regular_price]);
      $variation->set_sale_price($sale_price ? $sale_price : null);
      $variation->save();

      $variation_id = $variation->get_id();
      update_post_meta($variation_id, '_sku', $variation_id);
      update_post_meta($variation_id, '_rank_math_gtin_code', sprintf("%012d", $variation_id));
      update_post_meta($variation_id, '_my_product_variation_id', $product_variation[$variation_product_id]);
    }
  }
}

function getFileURL($fileId, $fileName) {
  $url = 'https://app.smartsuite.com/api/v1/shared-files/' . $fileId . '/get_url/';
  $headers = array(
      'Authorization: Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
      'ACCOUNT-ID: sd0y91s2',
      'Content-Type: image/png'
  );

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_exec($ch);
  
  if (curl_errno($ch)) {
      echo 'Грешка: ' . curl_error($ch);
  }

  $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

  curl_close($ch);

  $tmp = download_url( $finalUrl );

  $file_array = array(
    'name' => $fileName,
    'tmp_name' => $tmp
  );

  $imageId = 0;
  $is_exist_media = is_exist_media($fileId);
  if ($is_exist_media !== 0) {
    $imageId = $is_exist_media;
  } else {
    $imageId = media_handle_sideload($file_array, 0);
  }
  update_post_meta($imageId, 'ss_image_id', $fileId);

  return $imageId;
}

function add_img_to_gallery($product_id,$image_id_array){
  update_post_meta($product_id, '_product_image_gallery', implode(',',$image_id_array));
}

function create_simple_product($pid, $term_slug, $product_fields) {
  $ss_ids = get_field('ss_ids', 'option');
  $product_variations = post_column_fields($ss_ids['product_variations']);
	$product_variations_quantity = get_column_field_id('product_variations_quantity', $product_fields);
  // $attr_color = get_column_field_id('attr_color', $product_fields);
	$product_id_slug = get_column_field_id('product_variation', $product_fields);
  $set_regular_price = get_column_field_id('set_regular_price', $product_fields);
  $product_variation_sku = get_column_field_id('product_variation_sku', $product_fields);
  
  foreach ($product_variations['items'] as $product_variation) {
    // $is_set_color = isset($product_variation[$attr_color]) && $product_variation[$attr_color] !== '';
    if ($product_variation[$product_id_slug][0] === $term_slug) {
      $quantity = isset($product_variation[$product_variations_quantity]) && (int)$product_variation[$product_variations_quantity] !== 0 ? (int)$product_variation[$product_variations_quantity] : 0;
      // $stock_status = $quantity > 0 ? 'instock' : 'onbackorder';
      // $manage_stock = $quantity > 0 ? true : false;
      // $delivery_value = $manage_stock ? 'no' : 'notify';
  
      // Define the attribute data
      // $attributes_data = array();


      $sale_price = ''; // One day when we add Sale price in SS we have to replace this string with that field from SS
      
      update_post_meta($pid, '_manage_stock', true);
      // update_post_meta($pid, '_stock_status', $stock_status);
      update_post_meta($pid, '_backorders', 'notify');
      update_post_meta($pid, '_stock', $quantity);
      update_post_meta($pid, '_price', $sale_price ? $sale_price : $product_variation[$set_regular_price]);
      update_post_meta($pid, '_regular_price', $product_variation[$set_regular_price]);
      update_post_meta($pid, '_sale_price', $sale_price ? $sale_price : null);
      update_post_meta($pid, '_sku', $product_variation[$product_variation_sku]);
    }
  }
}

function reverse_number($number) {
  if ($number >= 1 && $number <= 10) {
    return 11 - $number;
  }
}

// Create Variable product
function generate_variable_products($item, $ss_ids, $product_fields, $product_variations_fields, $incoming_id) {
	$prduct_sku = get_column_field_id('set_sku', $product_fields);
	$attr_color = get_column_field_id('color', $product_fields);
	$attr_brand = get_column_field_id('brand', $product_fields);
	$brand_text = get_column_field_id('brand_text', $product_fields);
	$name_bg = get_column_field_id('product_name_bg', $product_fields);
  $seo_description_bg = get_column_field_id('seo_description_bg', $product_fields);
	$seo_keywords = get_column_field_id('seo_keywords', $product_fields);

  $variations = new WC_Product_Variable();

  $variations->set_name($item[$name_bg]);
  $variations->set_sku($item[$prduct_sku]);
  
  $variations->save();
  $pid = $variations->get_id();

  // $is_set_color = count($item[$attr_color]) > 0 ? $item[$attr_color][0] : '';
  // $is_set_brand = count($item[$attr_brand]) > 0 ? $item[$attr_brand][0] : '';

  $attributes_data = update_attributes(
    $item[$attr_brand], 
    $item[$brand_text], 
    'brand', 
    $item[$attr_color], 
    $ss_ids['filter_-_color_id'], 
    $pid
  );
  // if ($is_set_color !== '') {
  //   // if is set Attr Color, add Attributes but not create variations
  //   wp_set_object_terms($pid, array($is_set_color), 'pa_'.$ss_ids['filter_-_color_id'], true);

  //   $attributes_data['pa_'.$ss_ids['filter_-_color_id']] = array(
  //     'name' => 'pa_'.$ss_ids['filter_-_color_id'],
  //     'is_visible' => '1',
  //     'is_taxonomy' => '1'
  //   );
  // }

  // if ($is_set_brand !== '') {
  //   // if is set Attr Brand, add Attributes but not create variations
  //   wp_set_object_terms($pid, array($is_set_brand), 'pa_'.$ss_ids['filter_brands'], true);

  //   $attributes_data['pa_'.$ss_ids['filter_brands']] = array(
  //     'name' => 'pa_'.$ss_ids['filter_brands'],
  //     'is_visible' => '1',
  //     'is_taxonomy' => '1'
  //   );
  // }

  if (!empty($item[$seo_keywords])) {
    update_post_meta($pid, 'rank_math_focus_keyword', strtolower($item[$seo_keywords]));
  }

  if (!empty($item[$seo_description_bg])) {
    update_post_meta($pid, 'rank_math_description', $item[$seo_description_bg]);
  }

  update_post_meta($pid, '_rank_math_gtin_code', sprintf("%012d", $pid));


  // update_post_meta($pid, '_product_attributes', $attributes_data);
  set_values($product_fields, $pid, $item);
  update_acf($item, $pid, false);

  create_variation($pid, $incoming_id, $product_variations_fields, $attributes_data);

  return $pid;
}

// Create Simple products function
function generate_simple_product($item, $ss_ids, $product_fields, $product_variations_fields, $incoming_id) {
	$attr_color = get_column_field_id('color', $product_fields);
	$attr_brand = get_column_field_id('brand', $product_fields);
	$brand_text = get_column_field_id('brand_text', $product_fields);
	$name_bg = get_column_field_id('product_name_bg', $product_fields);
  $seo_description_bg = get_column_field_id('seo_description_bg', $product_fields);
	$seo_keywords = get_column_field_id('seo_keywords', $product_fields);
  $product_var_id = get_column_field_id('product_var_id', $product_fields);

  $simple_product = new WC_Product_Simple();
  $simple_product->set_name($item[$name_bg]); // product title
  $simple_product->set_status('publish');
  $p_id = $simple_product->save();     

  if (!empty($item[$seo_keywords])) {
    update_post_meta($p_id, 'rank_math_focus_keyword', strtolower($item[$seo_keywords]));
  }

  if (!empty($item[$seo_description_bg])) {
    update_post_meta($p_id, 'rank_math_description', $item[$seo_description_bg]);
  }

  update_post_meta($p_id, '_rank_math_gtin_code', sprintf("%012d", $p_id));

  $attributes_data = update_attributes(
    $item[$attr_brand], 
    $item[$brand_text], 
    'brand', 
    $item[$attr_color], 
    $ss_ids['filter_-_color_id'], 
    $p_id
  );

  // $is_set_color = count($item[$attr_color]) > 0 ? $item[$attr_color][0] : '';
  // $is_set_brand = count($item[$attr_brand]) > 0 ? $item[$attr_brand][0] : '';
  // if ($is_set_color !== '') {
  //   // if is set Attr Color, add Attributes but not create variations
  //   wp_set_object_terms($p_id, array($is_set_color), 'pa_'.$ss_ids['filter_-_color_id'], true);

  //   $attributes_data['pa_'.$ss_ids['filter_-_color_id']] = array(
  //     'name' => 'pa_'.$ss_ids['filter_-_color_id'],
  //     'is_visible' => '1',
  //     'is_taxonomy' => '1'
  //   );
  // }

  // if ($is_set_brand !== '') {
  //   // if is set Attr Brand, add Attributes but not create variations
  //   wp_set_object_terms($p_id, array($is_set_brand), 'pa_'.$ss_ids['filter_brands'], true);

  //   $attributes_data['pa_'.$ss_ids['filter_brands']] = array(
  //     'name' => 'pa_'.$ss_ids['filter_brands'],
  //     'is_visible' => '1',
  //     'is_taxonomy' => '1'
  //   );
  // }

  update_post_meta($p_id, '_product_attributes', $attributes_data);

  $item['product_variation_id'] = $item[$product_var_id];
  set_values($product_fields, $p_id, $item);
  update_acf($item, $p_id, false);
  create_simple_product($p_id, $incoming_id, $product_variations_fields);

  return $p_id;
}

function create_woocommerce_products($filteredData) {
  // $count = 0;
  $ss_ids = get_field('ss_ids', 'option');
  $product_fields = fetch_column_fields($ss_ids['products_app_id']);
  $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);
  $product_id_slug = get_column_field_id('product_variation', $product_variations_fields);
  $product_variation_slug = get_column_field_id('is_variation', $product_variations_fields);

  foreach ($filteredData as $item) {
    // $count++;
    $incoming_id = $item['id'];
    $product_id = is_exist_product($incoming_id);

    // if ($count >= 20) {
    //   break;
    // }

    if (!$product_id) {
      // if Product no exists
      if (is_variable_product($incoming_id, $product_id_slug, $product_variation_slug)) {
        $pid = generate_variable_products($item, $ss_ids, $product_fields, $product_variations_fields, $incoming_id);

        if (!is_wp_error($pid)) {
          $product_id = $pid;
        }
        
      } else {
        $p_id = generate_simple_product($item, $ss_ids, $product_fields, $product_variations_fields, $incoming_id);

        if (!is_wp_error($p_id)) {
          $product_id = $p_id;
        }
      }
    } else {
      // if Product exists // UPDATE PRODUCTS
      $product = wc_get_product($product_id);
      $iso_date = $item['last_updated']['on'];

      // Transform ISO 8601 format in Unix timestamp
      $timestamp = strtotime($iso_date);
      $ss_updated_product_date = new WC_DateTime(date('Y-m-d H:i:s', $timestamp), new DateTimeZone('UTC'));
      $ss_timestamp = $ss_updated_product_date->getTimestamp();
      $woo_updated_product_date = $product->get_data()['date_modified'];
      $woo_timestamp = $woo_updated_product_date->getTimestamp();
      if ($ss_timestamp >= $woo_timestamp) {
        if (is_variable_product($incoming_id, $product_id_slug, $product_variation_slug)) {
          // Delete post which is updated
          wp_delete_post($product_id, false);
          delete_transient('wc_transients_cache');
          // Create again post with updated DATA
          $pid = generate_variable_products($item, $ss_ids, $product_fields, $product_variations_fields, $incoming_id);

          if (!is_wp_error($pid)) {
            $product_id = $pid;
          }
        } else {
          // Delete post which is updated
          wp_delete_post($product_id, false);
          delete_transient('wc_transients_cache');
          // Create again post with updated DATA
          $p_id = generate_simple_product($item, $ss_ids, $product_fields, $product_variations_fields, $incoming_id);

          if (!is_wp_error($p_id)) {
            $product_id = $p_id;
          }
        }
      }
    }

    if (!$product_id) {
      return;
    }
  }
}

function update_attributes($brand, $brand_text, $attrBrand, $color, $attrColor, $pid) {
  $product = wc_get_product($pid);

  $attributes_data = array();
  $is_set_brand = count($brand) > 0 ? $brand[0] : '';
  $is_set_color = count($color) > 0 ? $color[0] : '';
  // $product = wc_get_product($pid);

  if ($is_set_color !== '') {
    // if is set Attr Color, add Attributes but not create variations
    wp_set_object_terms($pid, array($is_set_color), 'pa_'.$attrColor, true);

    $attributes_data['pa_'.$attrColor] = array(
      'name' => 'pa_'.$attrColor,
      'is_visible' => '1',
      'is_taxonomy' => '1'
    );
  }

  if ($is_set_brand !== '') {
    // if is set Attr Brand, add Attributes but not create variations
    wp_set_object_terms($pid, array($brand_text), 'pa_'.$attrBrand, true);

    $attributes_data['pa_'.$attrBrand] = array(
      'name' => 'pa_'.$attrBrand,
      'is_visible' => '1',
      'is_taxonomy' => '1'
    );
  }
  update_post_meta($pid, '_product_attributes', $attributes_data);
  
  $product->save();
  return $attributes_data;
  // delete_transient('wc_attribute_taxonomies');
  // delete_transient('wc_transients_cache');
}

function update_woocommerce_product($item, $id) {
  $ss_ids = get_field('ss_ids', 'option');
  $product_fields = fetch_column_fields($ss_ids['products_app_id']);    
  $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);
  $product_var_id = get_column_field_id('product_var_id', $product_fields);
  
  $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);
  $product_id_slug = get_column_field_id('product_variation', $product_variations_fields);
  $product_variation_slug = get_column_field_id('is_variation', $product_variations_fields);

  // foreach ($data as $item) {
    $incoming_id = $item['id'];
    $product_id = is_exist_product($incoming_id);
    $product_no_variation_id = is_product_id('["'.$incoming_id.'"]');
    $product_variation_id = is_variation_id($incoming_id);

    if ($id === $ss_ids['products_app_id']) {
      // *****Update from Products - Product
      if (!is_variable_product($incoming_id, $product_id_slug, $product_variation_slug)) {
        // Delete and Create new Simple product
        $item['product_variation_id'] = $item[$product_var_id];

        // Delete post which is updated
        // pretty_dump('asd');
        wp_delete_post($product_id, false);
        delete_transient('wc_transients_cache');
        // Create again post with updated DATA
        $p_id = generate_simple_product($item, $ss_ids, $product_fields, $product_variations_fields, $incoming_id);

        if (!is_wp_error($p_id)) {
          $product_id = $p_id;
        }
      } else {
        // Delete and Create new Variable product

        wp_delete_post($product_id, false);
        delete_transient('wc_transients_cache');
        // Create again post with updated DATA
        $pid = generate_variable_products($item, $ss_ids, $product_fields, $product_variations_fields, $incoming_id);

        if (!is_wp_error($pid)) {
          $product_id = $pid;
        }
      }
    } else if ($product_variation_id !== 0) {
      // *****Update from Product Variations - Product variation
      update_product_manually($item, $product_variation_id);
    } else if ($product_no_variation_id !== 0) {
      // *****Update from Product Variations - No variation
      update_product_manually($item, $product_no_variation_id);
    }
  // }
}