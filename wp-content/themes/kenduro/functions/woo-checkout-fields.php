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
  $fields['billing']['billing_first_name']['placeholder'] = 'Теодор';
  $fields['billing']['billing_last_name']['placeholder'] = 'Кабакчиев';
  $fields['billing']['billing_phone']['placeholder'] = '0888 888 888';
  $fields['billing']['billing_email']['placeholder'] = 'teo@kabakchiev.net';

  $fields['billing']['billing_phone']['priority'] = 21;
  $fields['billing']['billing_email']['priority'] = 22;

  // Billing fields
  unset($fields['billing']['billing_company']);
  // unset($fields['billing']['billing_country']);
  // unset($fields['billing']['billing_state']);
  // unset($fields['billing']['billing_address_2']);

  // $fields['billing']['billing_state']['class'][] = 'update_totals_on_change';

  return $fields;
}
add_filter('woocommerce_checkout_fields', 'wc_reorder_form');


add_action('woocommerce_after_order_notes', 'custom_invoice_fields');
function custom_invoice_fields($checkout) {
  echo '<div id="custom_invoice_checkbox">';
  woocommerce_form_field('want_invoice', array(
    'type' => 'checkbox',
    'class' => array('input-checkbox'),
    'label' => '<span>' . __('Искам фактура') . '</span>',
  ), $checkout->get_value('want_invoice'));
  echo '</div>';
  echo '<div id="custom_invoice_fields">';

  woocommerce_form_field('invoice_company_name', array(
    'type' => 'text',
    'class' => array('form-row-wide'),
    'label' => __('Име на фирмата'),
    'placeholder' => __('Кендуро ООД'),
  ), $checkout->get_value('invoice_company_name'));

  woocommerce_form_field('invoice_bulstat', array(
    'type' => 'text',
    'class' => array('form-row-wide'),
    'label' => __('Булстат'),
    'placeholder' => __('BG-11111111'),
  ), $checkout->get_value('invoice_bulstat'));

  woocommerce_form_field('invoice_vat_registration', array(
    'type' => 'select',
    'class' => array('form-row-wide custom-select'),
    'label' => __('Регистрация по ДДС'),
    'options' => array(
      'yes' => __('Да'),
      'no' => __('Не'),
    ),
  ), $checkout->get_value('invoice_vat_registration'));

  woocommerce_form_field('invoice_vat_number', array(
    'type' => 'text',
    'class' => array('form-row-wide'),
    'label' => __('ДДС Номер'),
    'placeholder' => __('BG-11111111'),
  ), $checkout->get_value('invoice_vat_number'));

  woocommerce_form_field('invoice_mol', array(
    'type' => 'text',
    'class' => array('form-row-wide'),
    'label' => __('МОЛ'),
    'placeholder' => __('Теодор Кабакчиев'),
  ), $checkout->get_value('invoice_mol'));

  woocommerce_form_field('invoice_phone', array(
    'type' => 'text',
    'class' => array('form-row-wide'),
    'label' => __('Телефон'),
    'placeholder' => __('0888 888 888'),
  ), $checkout->get_value('invoice_phone'));

  woocommerce_form_field('invoice_address', array(
    'type' => 'text',
    'class' => array('form-row-wide'),
    'label' => __('Адрес'),
    'placeholder' => __('Град, улица'),
  ), $checkout->get_value('invoice_address'));

  echo '</div>';
}

add_action('woocommerce_checkout_update_order_meta', 'save_custom_invoice_fields');

function save_custom_invoice_fields($order_id) {
  if ($_POST['want_invoice']) {
    if (!empty($_POST['invoice_company_name'])) {
      update_post_meta($order_id, '_invoice_company_name', sanitize_text_field($_POST['invoice_company_name']));
    }

    if (!empty($_POST['invoice_bulstat'])) {
      update_post_meta($order_id, '_invoice_bulstat', sanitize_text_field($_POST['invoice_bulstat']));
    }

    if (!empty($_POST['invoice_vat_registration'])) {
      update_post_meta($order_id, '_invoice_vat_registration', sanitize_text_field($_POST['invoice_vat_registration']));
    }

    if (!empty($_POST['invoice_vat_number'])) {
      update_post_meta($order_id, '_invoice_vat_number', sanitize_text_field($_POST['invoice_vat_number']));
    }

    if (!empty($_POST['invoice_mol'])) {
      update_post_meta($order_id, '_invoice_mol', sanitize_text_field($_POST['invoice_mol']));
    }

    if (!empty($_POST['invoice_phone'])) {
      update_post_meta($order_id, '_invoice_phone', sanitize_text_field($_POST['invoice_phone']));
    }

    if (!empty($_POST['invoice_address'])) {
      update_post_meta($order_id, '_invoice_address', sanitize_text_field($_POST['invoice_address']));
    }
  }
}

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
      <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="custom_one" > <span><?php echo  $email_checkbox; ?></span> <span class="required">*</span>
    </label>
  </p>
  <p class="form-row custom-checkboxes paragraph paragraph-m">
    <label class="woocommerce-form__label checkbox custom-two">
      <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="custom_two" > <span><?php echo  $viber_checkbox; ?></span> <span class="required">*</span>
    </label>
  </p>
  <?php
}