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

add_action('wp_footer', 'trigger_ajax_to_cart', 22);
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
        var stockDataElement = document.getElementById('variation-stock');
        var stockData = JSON.parse(stockDataElement.getAttribute('data-stock'));
        var quantity = stockData[variation.variation_id];

        
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

        // $body.find('#yith-s, .lapilliUI-Input__field').attr('placeholder', 'Търси продукт');
        // $('.lapilliUI-Input__field').attr('placeholder', 'Търси продукт');
        $('.sku-value').html($('.sku').text());

        $('.product-type-easy_product_bundle').find('.single_add_to_cart_button').on('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          let $thisbutton = $(this),
          data = {
            'product_id': $($thisbutton).attr('data-product_id'),
            'asnp_wepb_items': $('#asnp_wepb_items').attr('value')
          };

          jQuery(document.body).trigger('adding_to_cart', [$thisbutton, data]);

          jQuery.ajax({
            type: 'POST',
            url: woocommerce_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
            data: data,
            beforeSend: function(response) {
              $thisbutton
                .prop('disabled', true)
                .removeClass('added')
                .addClass('loading');
            },
            complete: function(response) {
              $thisbutton
                .prop('disabled', false)
                .addClass('added')
                .removeClass('loading');
            },
            success: function(response) {
              if (response.error && response.product_url) {
                window.location = response.product_url;
                return;
              }
              jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
            },
          });

          // return false;
        });

        // $('.single_add_to_cart_button').on('click', function(e){ 
        //   e.preventDefault();
        //   $thisbutton = $(this),
        //   $form = $thisbutton.closest('form.cart'),
        //   id = $thisbutton.val(),
        //   product_qty = $form.find('input[name=quantity]').val() || 1,
        //   product_id = $form.find('input[name=product_id]').val() || id,
        //   variation_id = $form.find('input[name=variation_id]').val() || 0;
        //   wapf_field_groups = $form.find('input[name=wapf_field_groups]');
        //   wapf_field_groups_value = wapf_field_groups.attr('value') || 0;
        //   wapf_checked = $form.find('.wapf-checked');
        //   wapf_checked_name = wapf_checked.find('.wapf-input').attr('name') || 0;
        //   wapf_checked_value = wapf_checked.find('.wapf-input').val() || 0;

        //   var data = {
        //     action: 'ql_woocommerce_ajax_add_to_cart',
        //     product_id: product_id,
        //     product_sku: '',
        //     quantity: product_qty,
        //     variation_id: variation_id,
        //     [wapf_checked_name]: wapf_checked_value,
        //     wapf_field_groups: wapf_field_groups_value 
        //   };
          
        //   $.ajax({
        //     type: 'post',
        //     url: wc_add_to_cart_params.ajax_url,
        //     data: data,
        //     beforeSend: function (response) {
        //       $thisbutton.removeClass('added').addClass('loading');
        //     },
        //     complete: function (response) {
        //       $thisbutton.addClass('added').removeClass('loading');
        //     }, 
        //     success: function (response) { 
        //       if (response.error & response.product_url) {
        //         window.location = response.product_url;
        //         return;
        //       } else { 
        //         $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
        //         // $('body').trigger('wc_fragment_refresh');

        //       } 
        //       $(document.body).trigger('wc_fragment_refresh');
        //     }, 
        //   }); 
        // }); 
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
        let selectedElWrapper = $(productEl).closest('.custom-cart-list__item');
        let imgPath = selectedElWrapper.find('.product-thumbnail img').attr('src');
        let productName = selectedElWrapper.find('.product-name a').text();
        
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
        let selectedElWrapper = $(productEl).closest('.custom-cart-list__item');

        selectedElWrapper.addClass('removing');

        if (selectedElWrapper.hasClass('asnp-wepb-cart-bundle')) {
          selectedElWrapper.nextUntil(':not(.asnp-wepb-cart-bundle-item)').addClass('removing');
        }

        confirmationModal.modal('hide');
        if (!productEl) {
          return;
        }

        fetch(productEl.href)
          .then(((res) => {
            console.log('OK!', res);
            if ( res.ok ) {
              selectedElWrapper.remove();
              $('.asnp-wepb-cart-bundle-item.removing').remove();
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
          $('.coupon-area').addClass('loading');
          var responseText = xhr.responseText;
          if (responseText.includes('woocommerce-error')) {
            // var parser = new DOMParser();
            // var doc = parser.parseFromString(responseText, 'text/html');
            // var errorMessage = doc.querySelector('.woocommerce-error li').textContent.trim();
            // console.log('Coupon error message: ', errorMessage);
            $('.coupon-area').removeClass('loading');

            return;
          } else {
            $body.trigger('wc_fragment_refresh');

            $.ajax({
              url: wc_add_to_cart_params.ajax_url,
              type: 'POST',
              data: {
                action: 'update_cart_discounts'
              },
              success: function(response) {
                $('.cart-discounts-container').html(response);
                $('.coupon-wrapper').removeClass('added-coupon').addClass('valid-code');
                $('.coupon-area').removeClass('loading');

                if (settings.url === '/?wc-ajax=remove_coupon') {
                  // const $currentPointsEl = $('#user_points_display');
                  // const used = parseInt($('#used_points_value').val());
                  // const current = parseInt($currentPointsEl.text());
                  // const remaining = current + used;

                  // $currentPointsEl.text(remaining >= 0 ? remaining : 0);

                  $('.coupon-wrapper').removeClass('valid-code');
                }
              }
            });
          }
          
        }

      });

    })(jQuery);
  </script>
<?php
}