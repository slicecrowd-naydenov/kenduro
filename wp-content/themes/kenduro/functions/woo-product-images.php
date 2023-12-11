
<?php
add_action('after_setup_theme', 'remove_woo_three_support', 11);
function remove_woo_three_support() {
  remove_theme_support('wc-product-gallery-zoom');
  // remove_theme_support( 'wc-product-gallery-lightbox' );
  // remove_theme_support( 'wc-product-gallery-slider' );
}

add_filter('storefront_woocommerce_args', 'bbloomer_resize_storefront_images');

function bbloomer_resize_storefront_images($args) {
  $args['single_image_width'] = 630;
  // $args['thumbnail_image_width'] = 335;
  return $args;
}
