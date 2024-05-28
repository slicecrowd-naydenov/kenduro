<!-- Modal -->
<div class="modal fade" id="addedToCart" tabindex="-1" role="dialog" aria-labelledby="addedToCartTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="img-wrapper">
          <?php 
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
            $image_url = $image ? $image[0] : wc_placeholder_img_src();
          ?>
          <img class="no-lazy" src="<?php echo esc_url($image_url); ?>" alt="">
        </div>
        <div>
          <p class="paragraph paragraph-xl primary">Продуктът е добавен в количката ❤️</p>
          <div class="content-footer">
            <a href="<?php echo esc_attr(get_site_url()); ?>/shop" class="button button-secondary-grey paragraph paragraph-m semibold">
              <span>Избери си още нещо</span>
            </a>
            <p class="paragraph paragraph-l">или</p>
            <a href="<?php echo esc_attr(get_site_url()); ?>/checkout" class="button button-primary-orange paragraph paragraph-m semibold">
              <span>Завърши поръчката</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>