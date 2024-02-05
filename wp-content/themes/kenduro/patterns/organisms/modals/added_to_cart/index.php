<!-- Modal -->
<div class="modal fade" id="addedToCart" tabindex="-1" role="dialog" aria-labelledby="addedToCartTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="img-wrapper">
          <img class="no-lazy" src="<?php echo esc_url(wc_placeholder_img_src()); ?>" alt="">
        </div>
        <div>
          <p class="paragraph paragraph-xl primary">The Product has been added to your card ❤️</p>
          <a href="<?php echo esc_attr(get_site_url()); ?>/checkout" class="button button-secondary-grey paragraph paragraph-l semibold">
            <span>Proceed to checkout</span>
          </a>
          <a href="<?php echo esc_attr(get_site_url()); ?>/shop" class="button button-primary-orange paragraph paragraph-l semibold">
            <span>Continue Shopping</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>