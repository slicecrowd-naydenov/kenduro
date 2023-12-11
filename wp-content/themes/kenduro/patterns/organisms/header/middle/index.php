<div id="middle-section">
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="site-title">
          <?php
            if (has_custom_logo()) {
              the_custom_logo();
            } else {
          ?>
            <a href="<?php echo esc_url(get_site_url()); ?>" rel="home" class="logo">Kenduro</a>
          <?php } ?>
          <?php echo do_shortcode('[yith_woocommerce_ajax_search]'); ?>
        </div>
      </div>
    </div>
  </div>
</div>