<?php
function change_default_checkout_country() {
  return 'BG';
}
add_filter('default_checkout_billing_country', 'change_default_checkout_country');

function wc_unrequire_wc_phone_field($fields) {
  $fields['billing_country']['required'] = false;
  $fields['billing_state']['required'] = true;
  $fields['billing_state']['label'] = 'Region';
  $fields['billing_state']['priority'] = 31;
  $fields['billing_city']['priority'] = 33;
  return $fields;
}
add_filter('woocommerce_billing_fields', 'wc_unrequire_wc_phone_field');


function wc_remove_checkout_fields($fields) {
  // Billing fields
  // unset($fields['billing']['billing_company']);
  // unset($fields['billing']['billing_state']);
  // unset($fields['billing']['billing_address_2']);
  // unset($fields['billing']['billing_country']);

  // $fields['billing']['billing_state']['class'][] = 'update_totals_on_change';

  return $fields;
}
add_filter('woocommerce_checkout_fields', 'wc_remove_checkout_fields');
