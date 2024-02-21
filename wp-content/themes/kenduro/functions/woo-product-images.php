<?php
add_action('after_setup_theme', 'remove_woo_three_support', 11);
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
  // $tabs['size_guide'] = array(
  //   'title' => __( 'Size Guide', 'woocommerce' ), // TAB TITLE
  //   'priority' => 40, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
  //   'callback' => 'size_guide_product_tab_content', // TAB CONTENT CALLBACK
  // );

  // $tabs['shipping_and_return'] = array(
  //   'title' => __( 'Shipping & Returns', 'woocommerce' ), // TAB TITLE
  //   'priority' => 50, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
  //   'callback' => 'shipping_and_return_product_tab_content', // TAB CONTENT CALLBACK
  // );

  unset( $tabs['additional_information'] ); // To remove the additional information tab

  return $tabs;
}
 
// function size_guide_product_tab_content() {
//   global $product;
//   echo 'Whatever Size Guide for ' . $product->get_name();
// }

// function shipping_and_return_product_tab_content() {
//   global $product;
//   echo 'Shipping & Returns for ' . $product->get_name();
// }

add_filter( 'woocommerce_output_related_products_args', 'bbloomer_change_number_related_products', 9999 );
 
function bbloomer_change_number_related_products( $args ) {
 $args['posts_per_page'] = 5; // # of related products
 $args['columns'] = 5; // # of columns per row
 return $args;
}

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

/**
* WooCommerce Loop Product Thumbs
**/
if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
  function woocommerce_template_loop_product_thumbnail() {
    echo "<div class='wc-img-wrapper'>";
    echo woocommerce_get_product_thumbnail();
    echo "</div>";
  }
}