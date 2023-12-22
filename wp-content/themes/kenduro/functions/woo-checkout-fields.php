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


function wc_reorder_form($fields) {
  $fields['billing']['billing_phone']['priority'] = 21;
  $fields['billing']['billing_email']['priority'] = 22;

  // Billing fields
  unset($fields['billing']['billing_company']);
  // unset($fields['billing']['billing_country']);
  // unset($fields['billing']['billing_state']);
  unset($fields['billing']['billing_address_2']);

  // $fields['billing']['billing_state']['class'][] = 'update_totals_on_change';

  return $fields;
}
add_filter('woocommerce_checkout_fields', 'wc_reorder_form');

// Add Cart info to Checkout page 
add_action( 'woocommerce_before_checkout_form', 'cart_on_checkout_page', 11 );
function cart_on_checkout_page() {
  echo do_shortcode( '[woocommerce_cart]' );
}

// Redirect to checkout from cart and if cart is not empty
add_filter( 'woocommerce_get_cart_url', 'redirect_empty_cart_checkout_to_shop' );
function redirect_empty_cart_checkout_to_shop() {
  return ( isset( WC()->cart ) && ! WC()->cart->is_empty() ) ? wc_get_checkout_url() : wc_get_page_permalink( 'shop' );
}

add_filter( 'woocommerce_shipping_package_name', 'custom_shipping_package_name' );
function custom_shipping_package_name( $name ) {
  return '<p class="section-title paragraph paragraph-xl semibold primary">Доставка с ЕКОНТ</p>';
}

add_filter( 'woocommerce_order_button_text', 'wc_custom_order_button_text' ); 
function wc_custom_order_button_text() {
  return __( 'Изпрати Поръчката', 'woocommerce' ); 
}