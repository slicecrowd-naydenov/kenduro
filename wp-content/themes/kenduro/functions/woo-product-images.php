<?php
add_action('after_setup_theme', 'remove_woo_three_support', 100);
function remove_woo_three_support() {
  remove_theme_support('wc-product-gallery-zoom');
  // remove_theme_support( 'wc-product-gallery-lightbox' );
  // remove_theme_support( 'wc-product-gallery-slider' );
}

add_filter('storefront_woocommerce_args', 'bbloomer_resize_storefront_images');

function bbloomer_resize_storefront_images($args) {
  $args['single_image_width'] = 1260;
  $args['thumbnail_image_width'] = 500; 
  return $args;
}

add_filter( 'woocommerce_product_tabs', 'add_product_tab', 9999 );
   
function add_product_tab( $tabs ) {

  unset( $tabs['additional_information'] ); // To remove the additional information tab

  return $tabs;
}