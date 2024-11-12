<?php

add_action('rest_api_init', 'get_column_fields_endpoint');
function get_column_fields_endpoint() {
  register_rest_route(
    'ss-data',
    '/get-column-fields/(?P<id>[^/]+)',
    array(
      'methods' => 'GET',
      'callback' => 'get_all_column_fields',
      'permission_callback' => '__return_true'
    )
  );
}

function get_all_column_fields($request) {
  // $data = $request->get_json_params();
  $id = $request->get_param('id');
  $external_api_response = get_column_fields($id);

  if (is_wp_error($external_api_response)) {
    return $external_api_response;
  }

  $data = $external_api_response['structure'];

  // create_woocommerce_products_2($data);

  return get_filtered_column_fields($data);
}

function get_filtered_column_fields($fields) {
  $filtered_data = array();
  foreach ($fields as $field) {
    // if ($field["params"]["help_doc"] !== null && $field["params"]["help_doc"]['preview'] !== '') {
    if (
      is_array($field["params"]["help_doc"]) &&
      $field["params"]["help_doc"]["html"] !== '' // Sale price with VAT field
    ) {
      $preview_text = array_key_exists('preview', $field["params"]["help_doc"]) && $field["params"]["help_doc"]['preview'] !== '';
      $html_text = $field["params"]["help_doc"]['html'];

      $filtered_item = array(
        "slug" => $field["slug"],
        "label" => $field["label"],
        "help_text" => $preview_text ? $field["params"]["help_doc"]['preview'] : strip_tags($html_text)
      );
      $filtered_data[] = $filtered_item;
    }
  }
  return $filtered_data;
}

function fetch_column_fields($app_id) {
  $rest_url = esc_url_raw(rest_url());

  $url = $rest_url . 'ss-data/get-column-fields/' . $app_id;

  $headers = array(
    'Content-Type' => 'application/json',
    'Authorization' => 'Token 2570295cb9c1e4c7f81d46ed046c09bf43fd5740',
    'ACCOUNT-ID' => 'sd0y91s2',
  );

  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);

  if (curl_errno($ch)) {
    echo 'Error fetching data from fetch_column_fields: ' . curl_error($ch);
    curl_close($ch);
    return;
  }

  curl_close($ch);

  $data = json_decode($response, true);

  return $data;
}

// function fetch_column_fields($app_id) {
//   $rest_url = esc_url_raw(rest_url());
//   $response = wp_remote_get($rest_url . 'ss-data/get-column-fields/'.$app_id);

//   if (is_wp_error($response)) {
//     echo 'Error fetching data from fetch_column_fields: ' . $response->get_error_message();
//     return;
//   }

//   $body = wp_remote_retrieve_body($response);
//   $data = json_decode($body, true);

//   return $data;
// }