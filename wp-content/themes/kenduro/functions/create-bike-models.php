<?php

// add_action('rest_api_init', 'add_get_bike_models_endpoint');
// function add_get_bike_models_endpoint() {
//   register_rest_route(
//     'ss-data',
//     '/get-bike-models/(?P<id>[^/]+)',
//     array(
//       'methods' => 'GET',
//       'callback' => 'get_all_bike_models',
//       'permission_callback' => function ($request) {
//         return true;
//       }
//     )
//   );
// }

// function get_all_bike_models($request) {
//   global $fieldsToRemove;
//   $id = $request->get_param('id');

//   $external_api_response = post_column_fields($id);

//   if (is_wp_error($external_api_response)) {
//     return $external_api_response;
//   }


//   $filteredData = filter_items($external_api_response['items'], $fieldsToRemove);

//   create_woo_bike_models($filteredData);

//   return $filteredData;
// }

// function createBikeModelTerms(string $termName, string $termSlug, string $taxonomy, int $order = 0): ?\WP_Term {
//   $taxonomy = wc_attribute_taxonomy_name($taxonomy);

//   if (!$term = get_term_by('slug', $termSlug, $taxonomy)) {
//     $term = wp_insert_term($termName, $taxonomy, array(
//       'slug' => $termSlug,
//     ));
//     $term = get_term_by('id', $term['term_id'], $taxonomy);
//     if ($term) {
//       update_term_meta($term->term_id, 'order', $order);
//     }
//   }

//   return $term;
// }

// function create_woo_bike_models($filteredData) {
//   $count = 1; 
//   foreach ($filteredData as $item) {
//     $count++;
//     // create Bike Model terms
//     createBikeModelTerms($item['title'], $item['title'], 'compability', $count);

//     // DELETE all created terms which are deleted in SS
//     $terms = get_terms([
//       'taxonomy' => 'pa_compability',
//       'hide_empty' => false,
//     ]);
  
//     $validTitles = array_map(function($t) {
//       return $t['title'];
//     }, $filteredData);
  
//     foreach ($terms as $term) {
//       if (!in_array($term->name, $validTitles)) {
//         // Delete terms whcih aren't in $validTitles list
//         wp_delete_term($term->term_id, 'pa_compability');
//       }
//     }
//   }
// }












// Create Brand/Model/Year dropdowns

function create_term_if_not_exists($term_name, $taxonomy) {
  $term = get_term_by('name', $term_name, $taxonomy);
  
  if (!$term) {
    // Ако терминът не съществува, създай го
    $result = wp_insert_term($term_name, $taxonomy);
    if (is_wp_error($result)) {
        // Обработка на грешки
      return $result;
    } else {
      return $result['term_id'];
    }
  } else {
      // Връщане на съществуващия термин ID
    return $term->term_id;
  }
}

function process_mockup($mockup) {

  $deleted_all_posts = delete_all_compatibility_posts();

  if (is_wp_error($deleted_all_posts)) {
    // Обработка на грешките, ако има такива
    // error_log($deleted_all_posts);
    return; // Прекратяване на изпълнението, ако изтриването е неуспешно
  } else {
    foreach ($mockup as $item) {
      // Създаване на пост
      $post_id = wp_insert_post(array(
        'post_title' => $item['title'],
        'post_type' => 'compatibility',
        'post_status' => 'publish'
      ));
  
      if ($post_id) {
        // Обработване на термини за "bike-year"
        $years_term_ids = array();
        foreach ($item['bike-year'] as $year) {
          $year_id = create_term_if_not_exists($year, 'bike-year');
          if (!is_wp_error($year_id)) {
            $years_term_ids[] = $year_id;
          }
        }
        wp_set_post_terms($post_id, $years_term_ids, 'bike-year');
        
        // Обработване на термини за "bike-brand"
        $brands_term_ids = array();
        foreach ($item['bike-brand'] as $brand) {
          $brand_id = create_term_if_not_exists($brand, 'bike-brand');
          if (!is_wp_error($brand_id)) {
            $brands_term_ids[] = $brand_id;
          }
        }
        wp_set_post_terms($post_id, $brands_term_ids, 'bike-brand');
      }
    }
  }
}

function convert_dynamic_data($dynamic_data) {
  $ss_ids = get_field('ss_ids', 'option');
  $bike_model_types = fetch_column_fields($ss_ids['bike_model_types']);
  $bike_brand_text = get_column_field_id('bike_brand_text', $bike_model_types);
  $bike_year_text = get_column_field_id('bike_year_text', $bike_model_types);

  $converted_data = array();

  foreach ($dynamic_data as $item) {
    $converted_data[] = array(
      'title' => $item['title'],
      'bike-year' => explode(', ', $item[$bike_year_text]),
      'bike-brand' => array($item[$bike_brand_text]),
    );
  }

  return $converted_data;
}

function get_bike_model_types() {
  global $fieldsToRemove;

  $bike_model_types_response = post_column_fields('65030eb5e5ae89fc66e0812e');

  if (is_wp_error($bike_model_types_response)) {
    return $bike_model_types_response;
  }


  $filteredData = filter_items($bike_model_types_response['items'], $fieldsToRemove);

  $response = convert_dynamic_data($filteredData);

  return $response;
}

function delete_all_compatibility_posts() {
  // Заявка за вземане на всички постове от тип 'compatibility'
  $query = new WP_Query(array(
    'post_type' => 'compatibility',
    'posts_per_page' => -1, // Взимаме всички постове
    'fields' => 'ids' // Взимаме само ID-тата на постовете
  ));

  // Проверяваме дали има намерени постове
  if ($query->have_posts()) {
    // Цикъл през всички постове
    foreach ($query->posts as $post_id) {
      // Изтриваме всеки пост
      $deleted = wp_delete_post($post_id, true);
      // Проверяваме дали изтриването е успешно
      if (!$deleted) {
        return new WP_Error('delete_failed', 'Неуспешно изтриване на поста с ID: ' . $post_id);
      }
    }
  }

  return true; // Връщаме true ако всички постове са успешно изтрити
}

// Масив с данни
// $mockup = array(
//   array(
//     'title' => 'EXC-F',
//     'bike-year' => array('2020', '2019', '2022', '2021', '2023', '2024', '2018', '2017'),
//     'bike-brand' => array('KTM')
//   ),
//   array(
//     'title' => 'RR',
//     'bike-year' => array('2020'),
//     'bike-brand' => array('Honda')
//   ),
//   array(
//     'title' => 'EXC',
//     'bike-year' => array('2024'),
//     'bike-brand' => array('KTM')
//   ),
//   array(
//     'title' => 'Vespa',
//     'bike-year' => array('2020'),
//     'bike-brand' => array('Kawasaki')
//   ),
//   array(
//     'title' => 'SX',
//     'bike-year' => array('2019'),
//     'bike-brand' => array('KTM')
//   )
// );



// Обработка на масива
// process_mockup(get_bike_model_types());