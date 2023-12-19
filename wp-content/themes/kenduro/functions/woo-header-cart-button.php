<?php

use Lean\Load;

/**
 * Show cart contents / total Ajax
 */
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment($fragments) {
  global $woocommerce;
  // $cart_icon = file_get_contents(ICON_PATH.'/cart.svg');

  ob_start();

?>
  <a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
    <span class="cart-icon"><?php Load::atom('svg', ['name' => 'cart']); ?></span>
    <span class="text">Cart :</span>
    <?php echo $woocommerce->cart->get_cart_total(); ?></a>
<?php
  $fragments['a.cart-customlocation'] = ob_get_clean();
  return $fragments;
}

add_action('wp_footer', 'trigger_for_ajax_add_to_cart');
function trigger_for_ajax_add_to_cart() {
?>
  <script type="text/javascript">
    (function($) {
      $('body').on('added_to_cart', function() {
        let imgPath = $('.woocommerce-product-gallery__image').find('.wp-post-image').attr('src');
        $('#addedToCart').find('img').attr('src', imgPath);
        $('#addedToCart').modal('show');
        // Your code goes here
      });

      $('.single_variation_wrap').on('show_variation', function(event, variation) {
        let variation_id = $('.variation_id').val();
        let variation_sku = $('.sku').html();

        $('.woocommerce-variation-add-to-cart')
          .find('.single_add_to_cart_button')
          .attr('data-product_id', variation_id)
          .attr('data-product_sku', variation_sku);
        // console.log('variation_id: ', variation_id);
      });
    })(jQuery);
  </script>
<?php
}