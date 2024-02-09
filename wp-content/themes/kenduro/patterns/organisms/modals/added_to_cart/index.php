<!-- Modal -->
<div class="modal fade" id="addedToCart" tabindex="-1" role="dialog" aria-labelledby="addedToCartTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="img-wrapper">
          <img class="no-lazy" src="<?php echo esc_url(wc_placeholder_img_src()); ?>" alt="">
        </div>
        <div>
          <p class="paragraph paragraph-xl primary">Продуктът е добавен в количката ❤️</p>
          <a href="<?php echo esc_attr(get_site_url()); ?>/checkout" class="button button-secondary-grey paragraph paragraph-m semibold">
            <span>Виж количката</span>
          </a>
          <a href="<?php echo esc_attr(get_site_url()); ?>/shop" class="button button-primary-orange paragraph paragraph-m semibold">
            <span>Продължи пазаруването</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>