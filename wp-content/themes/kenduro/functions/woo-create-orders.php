<?php
add_action('rest_api_init', 'register_custom_endpoint');

function register_custom_endpoint() {
  register_rest_route('custom/v1', '/create-woo-order/', array(
    'methods' => 'POST',
    'callback' => 'handle_create_woo_order',
    'permission_callback' => function ($request) {
      return check_valid_nonce($request);
    }
  ));
}

function create_order_from_product_ids($product_ids, $product_info) {
  $order = wc_create_order();

  foreach ($product_ids as $product_id) {
    $product = wc_get_product($product_id);

    if ($product) {
      $key = array_search($product->get_name(), array_column($product_info, 'product_name'));
      $quantity = $product_info[$key]['quantity'];
      $order->add_product($product, $quantity);
    }
  }
  // $address = array(
  //   "phone" => $client_phone,
  //   "email" => $client_email,
  // );

  $order->calculate_totals();
  // $order->set_address($address, 'billing');
  // $order->update_status('quick-order');
  $order_id = $order->save();

  return $order_id;
}

function create_sales_record($response) {
  $ss_ids = get_field('ss_ids', 'option');
  $sales_id = $ss_ids['sales'];
  $invoices_id = $ss_ids['invoices'];
  $sales_fields = fetch_column_fields($sales_id);
  $invoices_fields = fetch_column_fields($invoices_id);

  $invoices_items = get_column_field_id('invoices_items', $invoices_fields);
  $delivery_address_field = get_column_field_id('delivery_address_field', $invoices_fields);
  $delivery_city = get_column_field_id('delivery_city', $invoices_fields);
  $delivery_street = get_column_field_id('delivery_street', $invoices_fields);
  $delivery_street_no = get_column_field_id('delivery_street_no', $invoices_fields);
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
    $sale_price = $product->get_price(); 
    /**
    * Get the discount price of a product
    * @param $sale_price float|integer
    * @param $product object[wc_get_product($product_id))]|integer
    * @return float|integer
    */
    $sale_price = apply_filters('advanced_woo_discount_rules_get_product_discount_price', $sale_price, $product);
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
      $final_price_manual => round($sale_price, 2)
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

    $delivery_address_arr = array(
      "location_address" => $address_street,
      "location_address2" => $address_street_number,
      "location_city" => $city,
      "location_state" => "",
      "location_zip" => get_post_meta($response['order_id'], '_billing_postcode', true),
      "location_country" => "Bulgaria",
    );

    $new_data = array(
      $invoices_items => $sales_ids_array,
      $delivery_type => $econt_delivery_type,
      $delivery_city => $city,
      $delivery_ekont_office => $econt_office,
      $delivery_street => $address_street,
      $delivery_street_no => $address_street_number,
      $delivery_address_field => $delivery_address_arr,
    );

    $invoice_details = create_record_curl($invoices_id, $new_data, '');

    if (!is_wp_error($invoice_details)) {
      create_CRM_record($response['order_id'], $invoice_details['id']);
    }
    update_field('sync_order_with_smartsuite', 'synced', $response['order_id']);
  } else {
    $error_message = $sales_results->get_error_message();
    echo "Грешка при изпълнение на заявката: $error_message";
  }
}

function handle_create_woo_order($data) {
  if (isset($data['action'])) {
    $product_info = isset($data['product_info']) ? $data['product_info'] : array();
    $product_ids = isset($data['product_ids']) && is_array($data['product_ids']) ? $data['product_ids'] : array();
    // $client_phone = isset($data['client_phone']) ? $data['client_phone'] : '';
    // $client_email = isset($data['client_email']) ? $data['client_email'] : '';

    if (!empty($product_ids)) {
      $order_id = create_order_from_product_ids($product_ids, $product_info);

      $response = array(
        'order_id' => $order_id,
        'product_info' => $product_info
      );
      create_sales_record($response);
      wp_send_json($response);
    } else {
      wp_send_json('error');
    }
  } else {
    return array('error' => 'Липсват необходимите данни за заявката.');
  }
}

// Woocommerce Quick Order Form
function formatProduct($item) {
  return $item['product_name'] . ' / ' . $item['quantity'] . 'бр.';
}

function encodedValue($value) {
  return json_encode($value);
}

function create_order_ajax_script($contactFormId, $data, $product_titles) {
?>
  <script>
    (function($) {
      var variation_id = 0;
      var order_response = <?php echo encodedValue($data); ?>;
      $(".hidden_product_name").val("<?php echo $product_titles; ?>");

      $('.single_variation_wrap').on('show_variation', function(event, variation) {
        variation_id = $('.variation_id').val();
        order_response.product_ids = [variation_id];
        order_response.product_info[0].product_id = variation_id;
        console.log('order_response: ', order_response);
      });
      document.addEventListener('wpcf7mailsent', function(event) {
        console.log("wpcf7mailsent event: ", event);
        
        order_response.client_phone = $('input[name="client-phone-number"]').val();
        order_response.client_email = $('input[name="client-email"]').val();
        // order_response.product_info[0].quantity = $('input[aria-label="Product quantity"]').val();
        if ('<?php echo $contactFormId; ?>' == event.detail.contactFormId) {
          $.ajax({
            type: 'POST',
            url: `${wpApiSettings.rest_url}custom/v1/create-woo-order/`,
            beforeSend: function(xhr) {
              xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
            },
            data: order_response,
            success: function(response) {
              console.log('Поръчката беше създадена успешно!', response);
            }
          });
        }
      }, false);
      document.addEventListener('wpcf7submit', function(event) {
        var inputs = event.detail.inputs;
        console.log("wpcf7submit: ", inputs);
      }, false);
      document.addEventListener('wpcf7spam', function(event) {
        var inputs = event.detail.inputs;
        console.log("wpcf7spam: ", inputs);
      }, false);
      document.addEventListener('wpcf7invalid', function(event) {
        var inputs = event.detail.inputs;
        console.log("wpcf7invalid: ", inputs);
      }, false);
      document.addEventListener('wpcf7mailfailed', function(event) {
        var inputs = event.detail.inputs;
        console.log("wpcf7mailfailed: ", inputs);
        console.log("wpcf7mailfailed event: ", event);
      }, false);
    })(jQuery);
  </script>
  <?php
}

function product_quick_order_form() {
  echo do_shortcode('[contact-form-7 id="7a3ed1e" title="Quick order"]');

  if (is_checkout()) {
    $cart_items = WC()->cart->get_cart();

    $product_info = array();
    $product_ids = [];
    foreach ($cart_items as $cart_item_key => $cart_item) {
      $product = $cart_item['data'];
      $product_id = $product->get_id();

      $product_info[] = array(
        'product_id' => $product_id,
        'product_name' => $product->get_name(),
        'quantity' => $cart_item['quantity']
      );
      $product_ids[] = $product_id;
    }
    $product_names_string = implode('; ', array_map('formatProduct', $product_info));

    $data = array(
      'action' => 'create_order_with_multiple_products',
      'product_ids' => $product_ids,
      'product_info' => $product_info
    );
    create_order_ajax_script('2140', $data, $product_names_string);
  } else {
    global $product;
    $product_id = $product->get_id();
    $product_title = $product->get_title();

    $data = array(
      'action' => 'create_order',
      'product_ids' => array($product_id),
      'product_info' => array(
        0 => array(
          'product_id' => $product_id,
          'product_name' => $product_title,
          'quantity' => 1
        )
      )
    );
    create_order_ajax_script('2140', $data, $product_title);
  }
}

// add_filter('woocommerce_after_add_to_cart_form', 'product_quick_order_form');
// add_filter('woocommerce_before_checkout_form', 'product_quick_order_form');
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
  
  $order = wc_get_order( $order_id );
  
  $vat_choice = get_post_meta( $order_id, '_billing_vat_number', true ) !== '' ? true : false;
  $email_agreement_val = get_post_meta( $order_id, '_email_agreement', true ) === 'yes' ? true : false;
  $viber_agreement_val = get_post_meta( $order_id, '_viber_agreement', true ) === 'yes' ? true : false;
  $item_data = array(
    $first_name => $order->get_billing_first_name(),
    $last_name => $order->get_billing_last_name(),
    $phone_number => $order->get_billing_phone(),
    $email => $order->get_billing_email(),
    $vat_id => get_post_meta( $order_id, '_billing_vat_number', true ),
    $vat_registered => $vat_choice,
    $email_agreement => $email_agreement_val,
    $viber_agreement => $viber_agreement_val,
    $bulstat => get_post_meta( $order_id, '_billing_company_eik', true ),
    $company_phone => $order->get_billing_phone(),
    $company_name => get_post_meta( $order_id, '_invoice_company_name', true ),
    $accountable_person => get_post_meta( $order_id, '_billing_company_mol', true ),
    $link_to_invoices => array($invoice_id)
  );

  $CRM_results = create_record_curl($crm_id, $item_data, '');

  if (is_wp_error($CRM_results)) {
    $error_message = $CRM_results->get_error_message();
    echo "Грешка при изпълнение на заявката: $error_message";
  }

}

add_action('woocommerce_thankyou', 'success_message_after_payment');
function success_message_after_payment($order_id) {
  $checkout_response = checkout_success_sent_form($order_id);
  $is_synced = get_field('sync_order_with_smartsuite', $order_id);
  if (get_post_type($order_id) == "shop_order" && $is_synced === NULL) {
    create_sales_record($checkout_response);
  }
}

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
  
    $product_info[] = array(
      'product_id' => $product_id,
      'product_name' => $product_data['name'],
      'quantity' => $product_data['quantity']
    );
  }
  
  $data = array(
    'order_id' => $order_id,
    'product_info' => $product_info
  );

  return $data;
}