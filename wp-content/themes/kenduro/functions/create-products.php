<?php
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
add_action('rest_api_init', 'add_get_products_endpoint');
$ss_ids = get_field('ss_ids', 'option');
$product_variations = post_column_fields($ss_ids['product_variations']);

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
  global $product_variations, $fieldsToRemove, $ss_ids;

  $data = $request->get_json_params();
  $id = $request->get_param('id');
  $product_id = $request->get_param('product_id');
  $external_api_response = post_column_fields($id);
  $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);  
  $product_variation = get_column_field_id('product_variation', $product_variations_fields);
  $outputArray = array();

  if (is_wp_error($external_api_response)) {
    return $external_api_response;
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
    $filteredArrays = array_filter($filteredData, function ($item) use ($product_id) {
      return $item['id'] === $product_id;
    });
    update_woocommerce_product($filteredArrays, $product_id);
  }

  return $filteredArrays;
}

function is_variation_id($id) {
  $result = 0;
  $arr = array(
    'post_type'       => 'product_variation',
    'post_status'     => 'publish',
    'posts_per_page'  => -1,
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
    'posts_per_page' => -1,
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
    'posts_per_page' => -1,
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
    global $ss_ids;
    $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);
    $set_quantity = get_column_field_id('product_variations_quantity', $product_variations_fields);
    $set_regular_price = get_column_field_id('set_regular_price', $product_variations_fields);
    $product->set_stock_quantity($data[$set_quantity]);
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
    'posts_per_page' => - 1,
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

  $product = wc_get_product($product_id);
  $filtered_data = array();
  $handlesToKeep = array();

  foreach ($fields as $field) {
    
    if ($field['help_text'] === 'set_name') {
      $product->set_name($item['title']);
    } else if ($field['help_text'] === 'set_regular_price') {
      $product->set_regular_price($item[$field['slug']]);
    } else if ($field['help_text'] === 'main_category') {
      $filtered_data[] = is_exist_cat($item[$field['slug']][0], $all_categories);
    } else if ($field['help_text'] === 'child_category') {
      $filtered_data[] = is_exist_cat($item[$field['slug']][0], $all_categories);
    } else if ($field['help_text'] === 'sub_child_category') {
      $filtered_data[] = is_exist_cat($item[$field['slug']][0], $all_categories);
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
    }
    wp_set_post_terms($product_id, $filtered_data, 'product_cat');
  }

  add_img_to_gallery($product_id, $handlesToKeep); 

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
  global $product_variations;
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

function create_variation($pid, $term_slug, $filter_slug, $product_variations_fields) {
  global $product_variations, $ss_ids;
	$product_variations_quantity = get_column_field_id('product_variations_quantity', $product_variations_fields);
	$product_variation_sku = get_column_field_id('product_variation_sku', $product_variations_fields);
	$get_filter_id = get_column_field_id('get_filter_id', $product_variations_fields);
	$product_id_slug = get_column_field_id('product_variation', $product_variations_fields);
  $attr_color = get_column_field_id('attr_color', $product_variations_fields);
  $variation_product_id = get_column_field_id('variation_product_id', $product_variations_fields);
  $set_regular_price = get_column_field_id('set_regular_price', $product_variations_fields);

  foreach ($product_variations['items'] as $product_variation) {
    if (isset($product_variation[$filter_slug][0]) && $product_variation[$product_id_slug][0] === $term_slug) {
      $attribute_value = isset($product_variation[$filter_slug][0]) ? $product_variation[$filter_slug][0] : null;
      $quantity = isset($product_variation[$product_variations_quantity]) ? $product_variation[$product_variations_quantity] : 0;
      $sku = isset($product_variation[$product_variation_sku]) ? $product_variation[$product_variation_sku] : 0;
      // Set terms for the product
      wp_set_object_terms($pid, array($attribute_value), $product_variation[$get_filter_id], true);

      $is_set_color = isset($product_variation[$attr_color]);

      // Define the attribute data
      $attributes_data  = array(
        $product_variation[$get_filter_id] => array(
          'name' => $product_variation[$get_filter_id],
          'is_visible' => '1',
          'is_taxonomy' => '1',
          'is_variation' => '1'
        )
      );

      if ($is_set_color) {
        // if is set Attr Color, add Attributes but not create variations
        wp_set_object_terms($pid, array($product_variation[$attr_color]), 'pa_'.$ss_ids['filter_-_color_id'], true);

        $attributes_data['pa_'.$ss_ids['filter_-_color_id']] = array(
          'name' => 'pa_'.$ss_ids['filter_-_color_id'],
          'is_visible' => '1',
          'is_taxonomy' => '1'
        );
      }
      
      update_post_meta($pid, '_product_attributes', $attributes_data);

      // Create variation
      $variation = new WC_Product_Variation();
      $variation->set_parent_id($pid);
      $variation->set_attributes(array($product_variation[$get_filter_id] => $attribute_value));
      $variation->set_manage_stock(true);
      $variation->set_stock_quantity($quantity);
      $variation->set_sku($sku);
      $variation->set_regular_price($product_variation[$set_regular_price]);
      $variation->save();

      $variation_id = $variation->get_id();

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
  global $product_variations, $ss_ids;
	$product_variations_quantity = get_column_field_id('product_variations_quantity', $product_fields);
  $attr_color = get_column_field_id('attr_color', $product_fields);
	$product_id_slug = get_column_field_id('product_variation', $product_fields);
  $set_regular_price = get_column_field_id('set_regular_price', $product_fields);
  $product_variation_sku = get_column_field_id('product_variation_sku', $product_fields);
  
  foreach ($product_variations['items'] as $product_variation) {
    $is_set_color = isset($product_variation[$attr_color]);
    if ($is_set_color && $product_variation[$product_id_slug][0] === $term_slug) {
      $quantity = isset($product_variation[$product_variations_quantity]) ? $product_variation[$product_variations_quantity] : 0;
      $is_stock = $quantity > 0 ? 'instock' : 'outofstock'; 
  
      // Define the attribute data
      $attributes_data = array();

      if ($is_set_color) {
        // if is set Attr Color, add Attributes but not create variations
        wp_set_object_terms($pid, array($product_variation[$attr_color]), 'pa_'.$ss_ids['filter_-_color_id'], true);

        $attributes_data['pa_'.$ss_ids['filter_-_color_id']] = array(
          'name' => 'pa_'.$ss_ids['filter_-_color_id'],
          'is_visible' => '1',
          'is_taxonomy' => '1'
        );
      }

      update_post_meta($pid, '_product_attributes', $attributes_data);
      update_post_meta($pid, '_manage_stock', true);
      update_post_meta($pid, '_stock_status', $is_stock);
      update_post_meta($pid, '_stock', $quantity);
      update_post_meta($pid, '_price', $product_variation[$set_regular_price]);
      update_post_meta($pid, '_sku', $product_variation[$product_variation_sku]);
    }
  }
}

function create_woocommerce_products($filteredData) {
  global $ss_ids;

  $product_fields = fetch_column_fields($ss_ids['products_app_id']);
  $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);
  
  $product_id_slug = get_column_field_id('product_variation', $product_variations_fields);
  $product_variation_slug = get_column_field_id('is_variation', $product_variations_fields);
  $filter_helmet_size_slug = get_column_field_id('filter_helmet_size', $product_variations_fields);
	$filter_clothing_size_slug = get_column_field_id('filter_clothing_size', $product_variations_fields);
	$filter_boot_size_slug = get_column_field_id('filter_boot_size', $product_variations_fields);
	$prduct_sku = get_column_field_id('set_sku', $product_fields);
  $product_var_id = get_column_field_id('product_var_id', $product_fields);

  foreach ($filteredData as $item) {
    $incoming_id = $item['id'];
    $product_id = is_exist_product($incoming_id);

    if (!$product_id) {
      // if Product no exists
      if (is_variable_product($incoming_id, $product_id_slug, $product_variation_slug)) {
        $variations = new WC_Product_Variable();

        $variations->set_name($item['title']);
        $variations->set_sku($item[$prduct_sku]);
        
        $variations->save();
        $pid = $variations->get_id();

        if (!is_wp_error($pid)) {
          $product_id = $pid;
        }
        
        set_values($product_fields, $pid, $item);
        update_acf($item, $pid, false);
        
        if ($filter_clothing_size_slug) {
          create_variation($pid, $incoming_id, $filter_clothing_size_slug, $product_variations_fields);
        }

        if ($filter_helmet_size_slug) {
          create_variation($pid, $incoming_id, $filter_helmet_size_slug, $product_variations_fields);
        }
        
        if ($filter_boot_size_slug) {
          create_variation($pid, $incoming_id, $filter_boot_size_slug, $product_variations_fields);
        }

      } else {
        $simple_product = new WC_Product_Simple();
        $simple_product->set_name($item['title']); // product title
        $simple_product->set_status('publish'); // product title
        $p_id = $simple_product->save();

        if (!is_wp_error($p_id)) {
          $product_id = $p_id;
        }

        $item['product_variation_id'] = $item[$product_var_id];
        set_values($product_fields, $p_id, $item);
        update_acf($item, $p_id, false);
        create_simple_product($p_id, $incoming_id, $product_variations_fields);
      }
    }

    if (!$product_id) {
      return;
    }
  }
}

function update_woocommerce_product($data, $update_product) {
  global $ss_ids;
  $product_fields = fetch_column_fields($ss_ids['products_app_id']);    
  $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);
  $product_var_id = get_column_field_id('product_var_id', $product_fields);
  $set_gallery_image_ids = get_column_field_id('set_gallery_image_ids', $product_fields);
  $is_variation = get_column_field_id('is_variation', $product_variations_fields);

  foreach ($data as $item) {
    $incoming_id = $item['id'];
    if ($incoming_id === $update_product) {
      $product_id = is_exist_product($incoming_id);
      $product_no_variation_id = is_product_id('["'.$incoming_id.'"]');
      $product_variation_id = is_variation_id($incoming_id);
      $product = wc_get_product($product_id);
      // pretty_dump($product_id);
      // pretty_dump($product_no_variation_id);
      // pretty_dump($product_variation_id);
      if ($product_id !== 0) {
        // pretty_dump('tuk sme');
        if (isset($item[$is_variation]) && strtolower($item[$is_variation]) === strtolower('No') || !$product->is_type( 'variable' )) {
          $item['product_variation_id'] = $item[$product_var_id];
        }
        set_values($product_fields, $product_id, $item);
        update_acf($item, $product_id, false);
        if (count($item[$set_gallery_image_ids]) === 0) {
          delete_post_thumbnail($product_id);
        }
      } else if ($product_variation_id !== 0) {
        update_product_manually($item, $product_variation_id);
      } else if ($product_no_variation_id !== 0) {
        update_product_manually($item, $product_no_variation_id);
      } 
    }
  }
}