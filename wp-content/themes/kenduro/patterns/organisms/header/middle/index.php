<?php use Lean\Load; ?>
<div id="middle-section">
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="site-title">
          <?php Load::molecules('logo/index'); ?>
          <a href="#" class="search">
            <?php Load::atom('svg', ['name' => 'search','class' => 'search_icon']); ?>
            <?php Load::atom('svg', ['name' => 'close', 'class' => 'close_icon']); ?>
          </a>
          <?php echo do_shortcode('[yith_woocommerce_ajax_search]'); ?>
        </div>
      </div>
    </div>
  </div>
</div>