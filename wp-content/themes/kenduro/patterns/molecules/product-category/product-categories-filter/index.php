<?php 
echo do_shortcode('[yith_wcan_reset_button]');

?>
<div id="cat-filters">
  <div id="child_cat">
    <?php echo do_shortcode('[yith_wcan_filters slug="default-preset-2"]'); ?>
  </div>
  <div id="sub_child_cat">
    <?php echo do_shortcode('[yith_wcan_filters slug="default-preset-2-2"]'); ?>
  </div>
</div>
<?php
echo do_shortcode('[yith_wcan_filters slug="default-preset"]');

// patterns/organisms/index.js ShopFilter()
// echo do_shortcode('[pricefilter]');