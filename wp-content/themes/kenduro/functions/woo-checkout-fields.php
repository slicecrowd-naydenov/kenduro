<?php
function change_default_checkout_country() {
  return 'BG';
}
add_filter('default_checkout_billing_country', 'change_default_checkout_country');

function wc_unrequire_fields($fields) {
  $fields['billing_country']['required'] = false;
  $fields['billing_state']['required'] = true;
  $fields['billing_state']['label'] = 'Region';
  $fields['billing_state']['priority'] = 31;
  $fields['billing_city']['priority'] = 33;
  return $fields;
}
add_filter('woocommerce_billing_fields', 'wc_unrequire_fields');


function wc_edit_checkout_fields($fields) {
  $fields['billing']['billing_first_name']['label'] = 'Име';
  $fields['billing']['billing_first_name']['placeholder'] = 'Теодор';
  $fields['billing']['billing_last_name']['label'] = 'Фамилия';
  $fields['billing']['billing_last_name']['placeholder'] = 'Кабакчиев';
  $fields['billing']['billing_phone']['label'] = 'Телефон';
  $fields['billing']['billing_phone']['placeholder'] = '0888 888 888';
  $fields['billing']['billing_email']['label'] = 'Имейл';
  $fields['billing']['billing_email']['placeholder'] = 'teo@kabakchiev.net';
  $fields['order']['order_comments']['label'] = 'Коментар по поръчката';
  $fields['order']['order_comments']['placeholder'] = '';

  $fields['billing']['billing_phone']['priority'] = 21;
  $fields['billing']['billing_email']['priority'] = 22;

  if (!isset($fields['billing']['billing_state']['default']) || empty($fields['billing']['billing_state']['default'])) {
    $fields['billing']['billing_state']['default'] = 'BG-22'; 
  }

  // Billing fields
  unset($fields['billing']['billing_company']);
  // unset($fields['billing']['billing_country']);
  // unset($fields['billing']['billing_state']);
  // unset($fields['billing']['billing_address_2']);

  // $fields['billing']['billing_state']['class'][] = 'update_totals_on_change';

  return $fields;
}
add_filter('woocommerce_checkout_fields', 'wc_edit_checkout_fields');

// Add Cart info to Checkout page 
add_action('woocommerce_before_checkout_form', 'cart_on_checkout_page', 11);
function cart_on_checkout_page() {
  echo do_shortcode('[woocommerce_cart]');
}

// Redirect to checkout from cart and if cart is not empty
add_filter('woocommerce_get_cart_url', 'redirect_empty_cart_checkout_to_shop');
function redirect_empty_cart_checkout_to_shop() {
  return (isset(WC()->cart) && !WC()->cart->is_empty()) ? wc_get_checkout_url() : wc_get_page_permalink('shop');
}

add_filter('woocommerce_shipping_package_name', 'custom_shipping_package_name');
function custom_shipping_package_name($name) {
  return '<p class="section-title paragraph paragraph-xl semibold primary">Доставка с ЕКОНТ</p>';
}

add_filter('woocommerce_order_button_text', 'wc_custom_order_button_text');
function wc_custom_order_button_text() {
  return __('Изпрати Поръчката', 'woocommerce');
}

add_action('woocommerce_checkout_after_terms_and_conditions', 'checkout_additional_checkboxes');
function checkout_additional_checkboxes( ){
  $email_checkbox = __( "Съгласен съм да получавам съобщения за отстъпки и промоции по имейл", "woocommerce" );
  $viber_checkbox = __( "Съгласен съм да получавам съобщения за отстъпки и промоции по Viber", "woocommerce" );
  ?>
  <p class="form-row custom-checkboxes paragraph paragraph-m">
    <label class="woocommerce-form__label checkbox custom-one">
      <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="email_agreement" > <span><?php echo  $email_checkbox; ?></span> <span class="required">*</span>
    </label>
  </p>
  <p class="form-row custom-checkboxes paragraph paragraph-m">
    <label class="woocommerce-form__label checkbox custom-two">
      <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="viber_agreement" > <span><?php echo  $viber_checkbox; ?></span> <span class="required">*</span>
    </label>
  </p>
  <?php
}

add_action('woocommerce_checkout_create_order', 'save_custom_checkboxes_values', 10, 2);
function save_custom_checkboxes_values($order, $data) {
    if (isset($_POST['email_agreement'])) {
        $order->update_meta_data('_email_agreement', 'yes');
    }

    if (isset($_POST['viber_agreement'])) {
        $order->update_meta_data('_viber_agreement', 'yes');
    }
}

add_action('woocommerce_admin_order_data_after_billing_address', 'display_custom_checkboxes_values', 10, 1);
function display_custom_checkboxes_values($order){
    $email_agreement_value = $order->get_meta('_email_agreement');
    $viber_agreement_value = $order->get_meta('_viber_agreement');

    echo '<p><strong>Email Marketing:</strong> ' . ($email_agreement_value ? 'Yes' : 'No') . '</p>';
    echo '<p><strong>Viber Marketing:</strong> ' . ($viber_agreement_value ? 'Yes' : 'No') . '</p>';
}