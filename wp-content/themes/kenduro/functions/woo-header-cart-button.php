<?php

use Lean\Load;

/**
 * Show cart contents / total Ajax
 */
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
add_filter('woocommerce_add_to_cart_fragments', 'custom_total_fragment');

function woocommerce_header_add_to_cart_fragment($fragments) {
  global $woocommerce;
  // $cart_icon = file_get_contents(ICON_PATH.'/cart.svg');

  ob_start();

?>
  <a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
    <span class="cart-icon"><?php Load::atom('svg', ['name' => 'cart']); ?></span>
    <span class="text">Количка :</span>
    <?php echo $woocommerce->cart->get_cart_total(); ?></a>
<?php
  $fragments['a.cart-customlocation'] = ob_get_clean();
  return $fragments;
}

function custom_total_fragment($fragments) {
  ob_start();
?>
  <span id="total"><?php echo WC()->cart->get_cart_total(); ?></span>
<?php
  $fragments['span#total'] = ob_get_clean();
  return $fragments;
}

add_action('wp_footer', 'trigger_ajax_to_cart');
function trigger_ajax_to_cart() {
?>
  <script type="text/javascript">
    (function($) {
      if ($('.single-product').length) {
        $('.dsk_btn_click').removeClass('single_add_to_cart_button');
      }
      const custom_price_box = $('.custom-price-box');
      const $body = $('body');
      $body.on('added_to_cart', function() {
        // let imgPath = $('.woocommerce-product-gallery__image').find('.wp-post-image').attr('src');
        // $('#addedToCart').find('img').attr('src', imgPath);
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
        
        if ($body.find('.woocommerce-variation-price').children().length > 0) {
          $('.product-type-variable').find('.summary > .price').slideUp();
        }
        // console.log('variation_id: ', variation_id);
        $('.sku-value').html($('.sku').attr('data-o_content'));
        let variation_option = $('.cfvsw-swatches-option');
        if (variation_option.hasClass('cfvsw-swatches-disabled')) {
          variation_option.removeClass('cfvsw-swatches-disabled');
        }

        if ($('.woocommerce-variation-price').html() !== '') {
          custom_price_box.html($('.woocommerce-variation-price').html());
        }

        // Логика за stock message:
        var delivery_time_text = variation.delivery_time_text;
        var delivery_message;
        var quantity = variationStockData[variation.variation_id];
        
        if (quantity > 0) {
          delivery_message = "Може да бъде доставено утре!";
        } else {
          switch (delivery_time_text) {
            case "В момента няма наличност":
              delivery_message = "В момента няма наличност";
              break;
            case "Ще се свържем с вас":
              delivery_message = "Наличност : ще се свържем с вас";
              break;
            case "1 Ден (утре)":
              delivery_message = "Може да бъде доставено утре!";
              break;
            default:
              delivery_message = "Доставка " + delivery_time_text;
          }
        }

        $('.custom-stock .stock span').text(delivery_message);
      });

      $(document).ready(function($) {
        // Change price if we have selected additional product (like Garmin cart) in Product
        const onsale = $('.onsale');
        const wapf_grand_total = $('.wapf-grand-total');
        $('.wapf-input').on('input', function() {
          // if (this.checked)
          if (onsale.length) {
            // if have discount
            let additionalTaxTimeout;
            clearTimeout(additionalTaxTimeout);
            additionalTaxTimeout = setTimeout(() => {
              let totalString = wapf_grand_total.text();
              let totalNum = parseFloat(totalString.replace(/,/g, '').replace(/[^\d.]/g, ''));
              let percentDiscount = onsale.text();

              // remove sign '%' and transform it into number
              let discountValue = parseFloat(percentDiscount) / 100;

              // Calculation of the final amount after the discount
              let finalTotal = totalNum * (1 + discountValue);

              let formattedTotal = finalTotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

              custom_price_box.find('del ins bdi').html(totalString);
              custom_price_box.find('> ins bdi').html(formattedTotal + ' лв.');
            }, 0);
          } else {
            // if don't have discount

            let additionalTaxTimeout;
            clearTimeout(additionalTaxTimeout);
            additionalTaxTimeout = setTimeout(() => {
              custom_price_box.find('bdi').html(wapf_grand_total.text());
            }, 0);
          }
        });

        let variation_option = $('.cfvsw-swatches-option');
        if (variation_option.hasClass('cfvsw-swatches-disabled')) {
          variation_option.removeClass('cfvsw-swatches-disabled');
        }
        let tyre_inch_size = $('#pa_6595243a37ed0de3a4b3ae1c');
        let tyre_placement = $('#pa_6595244a28efc03f09ca0e63');
        let tyre_type = $('#pa_659524527b8cf849288731f3');

        tyre_inch_size.parents('tr').hide();
        tyre_placement.parents('tr').hide();
        tyre_type.parents('tr').hide();

        $body.find('#yith-s, .lapilliUI-Input__field').attr('placeholder', 'Търси продукт');
        // $('.lapilliUI-Input__field').attr('placeholder', 'Търси продукт');
        $('.sku-value').html($('.sku').text());
      });

      let productEl = '';
      const confirmationModal = $('#deleteProductConfirmation');
      // const totalEl = $('#total');
      
      // if (totalEl.length) {
      //   totalEl.find('bdi span').remove();
      // }

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
              $body.trigger('wc_fragment_refresh');
              // const productPrice = $(productEl).closest('li').find('.product-price bdi')
              //   .clone()    //clone the element
              //   .children() //select all the children
              //   .remove()   //remove all the children
              //   .end()  //again go back to selected element
              //   .text();

              // let total = totalEl.text();
              // let sum = total - productPrice;
              // let updatedTotal = Number(sum.toFixed(2));
              // totalEl.text(updatedTotal);
            }
          }))
          .catch((err) => {
            console.log('error: ', err);
          });
      });

      confirmationModal.on('click', '#cancelDeleteButton', function () {
        confirmationModal.modal('hide');
      });

      // $(document).ajaxComplete((event, xhr, settings) => {
      //   if (settings.url === '/?wc-ajax=apply_coupon' || settings.url === '/?wc-ajax=remove_coupon') {
      //     // Update Total price in checkout page after
      //     $('body').trigger('wc_fragment_refresh');
      //   }
      // });

      // Update Total price in checkout page after
      $(document).on('ajaxComplete', (event, xhr, settings) => {
        if (settings.url === '/?wc-ajax=apply_coupon' || settings.url === '/?wc-ajax=remove_coupon') {
          $body.trigger('wc_fragment_refresh');
          
          $.ajax({
            url: wc_add_to_cart_params.ajax_url,
            type: 'POST',
            data: {
              action: 'update_cart_discounts'
            },
            success: function(response) {
              $('.cart-discounts-container').html(response);
            }
          });
        }
      });

    })(jQuery);
  </script>
<?php
}