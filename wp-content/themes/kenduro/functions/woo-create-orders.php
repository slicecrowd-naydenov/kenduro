<?php
// pretty_dump('test');
function create_sales_record($response) {
  $ss_ids = get_field('ss_ids', 'option');
  $sales_id = $ss_ids['sales'];
  $invoices_id = $ss_ids['invoices'];
  $sales_fields = fetch_column_fields($sales_id);
  $invoices_fields = fetch_column_fields($invoices_id);

  $invoices_items = get_column_field_id('invoices_items', $invoices_fields);
  $origins = get_column_field_id('origins', $invoices_fields);
  $source_type = get_column_field_id('source-type', $invoices_fields);
  $source_medium = get_column_field_id('source-medium', $invoices_fields);
  $source_campaign_name = get_column_field_id('source-campaign-name', $invoices_fields);
  $source_session_pages = get_column_field_id('source-session-pages', $invoices_fields);
  $source_devices = get_column_field_id('source-device', $invoices_fields);
  $delivery_address_field = get_column_field_id('delivery_address_field', $invoices_fields);
  $delivery_city = get_column_field_id('delivery_city', $invoices_fields);
  $woo_items_subtotal = get_column_field_id('woo_items_subtotal', $invoices_fields);
  $woo_delivery_cost = get_column_field_id('woo_delivery_cost', $invoices_fields);
  $woo_vat = get_column_field_id('woo_vat', $invoices_fields);
  $woo_items_total = get_column_field_id('woo_items_total', $invoices_fields);
  $woo_coupon = get_column_field_id('woo_coupon', $invoices_fields);
  $delivery_street = get_column_field_id('delivery_street', $invoices_fields);
  $delivery_street_no = get_column_field_id('delivery_street_no', $invoices_fields);
  $order_from = get_column_field_id('order_from', $invoices_fields);
  $delivery_type = get_column_field_id('delivery_type', $invoices_fields);
  $delivery_ekont_office = get_column_field_id('delivery_ekont_office', $invoices_fields);
  $sales_quantity_ordered = get_column_field_id('sales_quantity_ordered', $sales_fields);
  $sales_link_to_product_variations = get_column_field_id('sales_link_to_product_variations', $sales_fields);
  $wp_order_id = get_column_field_id('wp_order_id', $sales_fields);
  $final_price_manual = get_column_field_id('final_price_manual', $sales_fields);

  $sales_body = array(
    'items' => array() 
  );

  foreach ($response['product_info'] as $key => $value) {
    $product_id = $value['product_id'];
    $product = wc_get_product($product_id);
    // $sale_price = $product->get_price(); 
    // $sale_price = apply_filters('advanced_woo_discount_rules_get_product_discount_price', $sale_price, $product);
    $meta_fields = get_field("meta_data", $product_id);
    $field_id = array();
    if ($product->is_type('variation')) {
      $field_id = get_post_meta($product_id, '_my_product_variation_id', true);
    } else {
      foreach ($meta_fields as $meta_field) {
        if ($meta_field['key'] === 'product_variation_id') {
          $array = json_decode($meta_field['value'], true);
          $string_without_brackets = implode('', $array);
          $field_id = $string_without_brackets;
        }
      }
    }

    $item_data = array(
      $sales_quantity_ordered => $value['quantity'],
      $sales_link_to_product_variations => $field_id,
      $wp_order_id => $response['order_id'],
      $final_price_manual => $value['product_total']
    );

    $sales_body['items'][] = $item_data;
  }

  $sales_results = create_record_curl($sales_id, $sales_body, 'bulk/');
  if (!is_wp_error($sales_results)) {

    $sales_ids_array = array();

    foreach ($sales_results as $result) {
      if (!empty($result['id'])) {
        $sales_ids_array[] = $result['id'];
      }
    }

    $econt_details = get_post_meta($response['order_id'], 'woo_bg_econt_cookie_data', true);
    $address_street = isset($econt_details['selectedAddress']) ? $econt_details['selectedAddress']['label'] : '';
    $address_street_number = isset($econt_details['streetNumber']) ? $econt_details['streetNumber'] : '';
    $city = get_post_meta($response['order_id'], '_billing_city', true);
    $econt_delivery_type = $econt_details['type'] === 'address' ? 'rRAy5' : 'uMXsH';
    $econt_office = $econt_delivery_type === 'uMXsH' ? get_post_meta($response['order_id'], '_billing_address_1', true) : '';

    // Incoming from WooCommerce
    $order = wc_get_order($response['order_id']);
    $order_shipping_total = $order->get_data()['shipping_total'];
    $order_total_tax = $order->get_data()['total_tax'];
    $order_total = $order->get_data()['total'];
    $order_coupon = $order->get_data()['discount_total'];
    $order_items_subtotal = $order_total - $order_total_tax - $order_shipping_total + $order->get_data()['discount_total'];
    $order_client_first_name = $order->get_data()['billing']['first_name'];
    $order_client_last_name = $order->get_data()['billing']['last_name'];
    $prim_rows = [];

    foreach ( $order->get_items() as $item ) {
      $product_data = $item->get_data();
      $id = $product_data['product_id'];
      $product = wc_get_product($id);
      $product_total = $item['total'];
      $product_total_tax = $item['total_tax'];
      $product_discount = $product_total + $product_total_tax;
        // $product = $item->get_product();
      $prim_rows[] = [
        "sku" => $product ? $product->get_sku() : '', // Защита ако продуктът е изтрит
        "price" => $product_discount,
        "quantity" => $item->get_quantity()
      ];
    }

    $prim_mockup = [
      "data" => [
        [
          "sale_type" => "Основен",
          "pos_code" => "amz",
          "partner" => [
            "name" => $order_client_first_name . ' ' . $order_client_last_name
          ],
          "delivery_address" => [
            "country" => "България"
          ],
          "tax_address" => [
            "country" => "България"
          ],
          "contract" => new stdClass(),
          "rows" => $prim_rows
        ]
      ]
    ];

    create_prim_sales_curl($prim_mockup);

    $delivery_address_arr = array(
      "location_address" => $address_street,
      "location_address2" => $address_street_number,
      "location_city" => $city,
      "location_state" => "",
      "location_zip" => get_post_meta($response['order_id'], '_billing_postcode', true),
      "location_country" => "Bulgaria",
    );

    $utm_source = get_post_meta($response['order_id'], '_wc_order_attribution_utm_source', true);
    $utm_source_type = get_post_meta($response['order_id'], '_wc_order_attribution_source_type', true);
    $utm_source_medium = get_post_meta($response['order_id'], '_wc_order_attribution_utm_medium', true);
    $utm_source_campaign_name = get_post_meta($response['order_id'], '_wc_order_attribution_utm_campaign', true);
    $utm_session_pages = get_post_meta($response['order_id'], '_wc_order_attribution_session_pages', true);
    $utm_source_devices = get_post_meta($response['order_id'], '_wc_order_attribution_device_type', true);
    $utm_source = !empty($utm_source) ? $utm_source : '';
    $utm_source_type = !empty($utm_source_type) ? $utm_source_type : '';
    $utm_source_medium = !empty($utm_source_medium) ? $utm_source_medium : '';
    $utm_source_campaign_name = !empty($utm_source_campaign_name) ? $utm_source_campaign_name : '';
    $utm_session_pages = !empty($utm_session_pages) ? $utm_session_pages : '';
    $utm_source_devices = !empty($utm_source_devices) ? $utm_source_devices : '';

    $new_data = array(
      $invoices_items => $sales_ids_array,
      $origins => $utm_source,
      $source_type => $utm_source_type,
      $source_medium => $utm_source_medium,
      $source_campaign_name => $utm_source_campaign_name,
      $source_session_pages => $utm_session_pages,
      $source_devices => $utm_source_devices,
      $delivery_type => $econt_delivery_type,
      $delivery_city => $city,
      $woo_items_subtotal => $order_items_subtotal,
      $woo_delivery_cost => $order_shipping_total,
      $woo_vat => $order_total_tax,
      $woo_items_total => $order_total,
      $woo_coupon => $order_coupon,
      $delivery_ekont_office => $econt_office,
      $delivery_street => $address_street,
      $delivery_street_no => $address_street_number,
      $delivery_address_field => $delivery_address_arr,
      $order_from => 'FR74e' // FR74e (Website), KFx5s Phone
    );

    $invoice_details = create_record_curl($invoices_id, $new_data, '');

    if (!is_wp_error($invoice_details)) {
      create_CRM_record($response['order_id'], $invoice_details['id']);
    }
    update_field('sync_order_with_smartsuite', 'synced', $response['order_id']);
    update_field('invoice_id', $invoice_details['id'], $response['order_id']);
  } else {
    $error_message = $sales_results->get_error_message();
    echo "Грешка при изпълнение на заявката: $error_message";
  }
}

function create_CRM_record($order_id, $invoice_id) {
  $ss_ids = get_field('ss_ids', 'option');
  $crm_id = $ss_ids['crm'];
  $crm_fields = fetch_column_fields($crm_id);

  $first_name = get_column_field_id('first_name', $crm_fields);
  $last_name = get_column_field_id('last_name', $crm_fields);
  $phone_number = get_column_field_id('phone_number', $crm_fields);
  $email = get_column_field_id('email', $crm_fields);
  $vat_id = get_column_field_id('vat_id', $crm_fields);
  $vat_registered = get_column_field_id('vat_registered', $crm_fields);
  $bulstat = get_column_field_id('bulstat', $crm_fields);
  $company_phone = get_column_field_id('company_phone', $crm_fields);
  $company_name = get_column_field_id('company_name', $crm_fields);
  $email_agreement = get_column_field_id('email_agreement', $crm_fields);
  $viber_agreement = get_column_field_id('viber_agreement', $crm_fields);
  $accountable_person = get_column_field_id('accountable_person', $crm_fields);
  $link_to_invoices = get_column_field_id('link_to_invoices', $crm_fields);
  
  $order = wc_get_order($order_id);
  
  $vat_choice = get_post_meta($order_id, '_billing_vat_number', true) !== '' ? true : false;
  $email_agreement_val = get_post_meta($order_id, '_email_agreement', true) === 'yes' ? true : false;
  $viber_agreement_val = get_post_meta($order_id, '_viber_agreement', true) === 'yes' ? true : false;
  $item_data = array(
    $first_name => $order->get_billing_first_name(),
    $last_name => $order->get_billing_last_name(),
    $phone_number => $order->get_billing_phone(),
    $email => $order->get_billing_email(),
    $vat_id => get_post_meta($order_id, '_billing_vat_number', true),
    $vat_registered => $vat_choice,
    $email_agreement => $email_agreement_val,
    $viber_agreement => $viber_agreement_val,
    $bulstat => get_post_meta($order_id, '_billing_company_eik', true),
    $company_phone => $order->get_billing_phone(),
    $company_name => get_post_meta($order_id, '_invoice_company_name', true),
    $accountable_person => get_post_meta($order_id, '_billing_company_mol', true),
    $link_to_invoices => array($invoice_id)
  );

  $CRM_results = create_record_curl($crm_id, $item_data, '');

  if (is_wp_error($CRM_results)) {
    $error_message = $CRM_results->get_error_message();
    echo "Грешка при изпълнение на заявката: $error_message";
  }
}

// function update_menu_order($order_id) {
//   // Вземете поръчката по ID
//   $order = wc_get_order($order_id);

//   // Проверете дали поръчката съществува
//   if (!$order) {
//     return;
//   }

//   // Вземете всички артикули в поръчката
//   $items = $order->get_items();
//   $ss_fields = get_field('ss_fields', 'option');
//   $ss_ids = get_field('ss_ids', 'option');
//   $woo_items_order = $ss_fields['woo_items_order'];
//   $products_app_id = $ss_ids['products_app_id'];

//   // За всеки артикул актуализирайте menu_order
//   foreach ($items as $item) {
//     $product_data = $item->get_data();
//     $product_id = $product_data['product_id'];

//     $meta_data = get_field('meta_data', $product_id); // $product_id е ID-то на продукта, за който искате да вземете полето
//     if ($meta_data) {
//       $meta_data_keys = array_column($meta_data, 'value', 'key');
//       // pretty_dump($meta_data_keys['id']);
//       // Настройте новото значение на menu_order
//       $args = array(
//         'ID'         => $product_id,
//         'menu_order' => get_record($products_app_id, $meta_data_keys['id'])[$woo_items_order]
//       );
    
//       // Актуализирайте продукта
//       wp_update_post($args);
//     }
//   }
// }

add_action('woocommerce_thankyou', 'success_message_after_payment');
function success_message_after_payment($order_id) {
  $checkout_response = checkout_success_sent_form($order_id);
  $is_synced = get_field('sync_order_with_smartsuite', $order_id);
  if (get_post_type($order_id) == "shop_order" && $is_synced === NULL) {
    create_sales_record($checkout_response);
  }
}

// Function to create a record after completing an order
function checkout_success_sent_form($order_id) {
  $order = wc_get_order( $order_id );
  $items = $order->get_items();
  $product_id = 0;
  
  $product_info = array();
  foreach ($items as $item_key => $item) {
    $product_data = $item->get_data();
    $id = $product_data['product_id'];
    $product = wc_get_product($id);
  
    if ($product->is_type('variable')) {
      $product_id = $product_data['variation_id'];
    } else {
      $product_id = $id;
    }

    $product_total = $item['total'];
    $product_total_tax = $item['total_tax'];
    $product_discount = $product_total + $product_total_tax;

    if ($product_discount == 0) {
      continue;
    }
  
    $product_info[] = array(
      'product_id' => $product_id,
      'product_name' => $product_data['name'],
      'quantity' => $product_data['quantity'],
      'product_total' => $product_discount
    );
  }
  
  $data = array(
    'order_id' => $order_id,
    'product_info' => $product_info
  );

  return $data;
}
?>
