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

add_action('wp_footer', 'trigger_ajax_to_cart');
function trigger_ajax_to_cart() {
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
        
        if ($('body').find('.woocommerce-variation-price').children().length > 0) {
          $('.product-type-variable').find('.summary > .price').slideUp();
        }
        // console.log('variation_id: ', variation_id);
        $('.sku-value').html(variation_sku);
        let variation_option = $('.cfvsw-swatches-option');
        if (variation_option.hasClass('cfvsw-swatches-disabled')) {
          variation_option.removeClass('cfvsw-swatches-disabled');
        }

        // console.log();
        $('.custom-price-box').html($('.woocommerce-variation-price').html());
      });

      $(document).ready(function($) {
        let variation_option = $('.cfvsw-swatches-option');
        if (variation_option.hasClass('cfvsw-swatches-disabled')) {
          variation_option.removeClass('cfvsw-swatches-disabled');
        }

        // if (variation_option) {
        //   for (let index = 0; index < variation_option.length; index++) {
        //     const element = variation_option[index];
        //     $(element).trigger('click');
            
        //   }
        //   // console.log(variation_option);
        // }

        let choose_first_available_el = $('.cfvsw-swatches-option:not(.cfvsw-swatches-blur-disable):first');

        if (choose_first_available_el.length > 0) {
          let choose_first_available_el_timeout;
          clearTimeout(choose_first_available_el_timeout);
          choose_first_available_el_timeout = setTimeout(() => {
            choose_first_available_el.trigger('click');
          }, 1000);
            // console.log(variation_option);
        }
      });

      let productEl = '';
      const confirmationModal = $('#deleteProductConfirmation');
      $('.remove').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        productEl = event.currentTarget;
        let imgPath = $(productEl).closest('.custom-cart-list__item').find('.product-thumbnail img').attr('src');
        let productName = $(productEl).closest('.custom-cart-list__item').find('.product-name a').text();
        
        confirmationModal.find('img').attr('src', imgPath);
        confirmationModal.find('#product_name').text('"' + productName + '"');
        confirmationModal.modal('show');
        // console.log(productName);
        // const productID = $(event.currentTarget).attr('data-product_id');

        // if (productEl) {
        //   const productElID = $(productEl).attr('data-product_id');

        //   if (productID === productElID) {
        //     return;
        //   }
        // }
        // console.log('event: ', event);
      });

      confirmationModal.on('click', '#confirmDeleteButton', () => {
        $(productEl).closest('li').addClass('removing');
        confirmationModal.modal('hide');
        if (!productEl) {
          return;
        }
        
        fetch(productEl.href)
          .then(((res) => {
            console.log('OK!', res);
            if ( res.ok ) {
              $(productEl).closest('.custom-cart-list__item').remove();
              const productPrice = $(productEl).closest('li').find('.product-price bdi')
                .clone()    //clone the element
                .children() //select all the children
                .remove()   //remove all the children
                .end()  //again go back to selected element
                .text();

              let total = $('#total').text();
              let sum = total - productPrice;
              let updatedTotal = Number(sum.toFixed(2))
              $('#total').text(updatedTotal);
            }
          }))
          .catch((err) => {
            console.log('error: ', err);
          });
      });

      confirmationModal.on('click', '#cancelDeleteButton', function () {
        confirmationModal.modal('hide');
      });
    })(jQuery);
  </script>
<?php
}