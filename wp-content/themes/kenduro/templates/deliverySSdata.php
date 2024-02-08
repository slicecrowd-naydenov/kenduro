<?php

require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
/* Template Name: Delivery SS data*/

get_header();

?>
<main>
  <?php $ss_ids = get_field('ss_ids', 'option'); ?>
  <a href="#" id="createProducts" data-products-id="<?php echo esc_attr($ss_ids['products_app_id']); ?>">create Products</a>
  </br>
  <!-- <a href="#" id="updateProduct">update Product</a> -->
  <!-- </br> -->
  <!-- <a href="#" id="updateProductVariation">update Variation Product</a> -->
  <!-- </br> -->
  <a 
    href="#" 
    id="createCategories" 
    data-main-cat-id="<?php echo esc_attr($ss_ids['main_category_id']); ?>"
    data-child-cat-id="<?php echo esc_attr($ss_ids['child_category_id']); ?>"
    data-sub-child-cat-id="<?php echo esc_attr($ss_ids['sub_child_category_id']); ?>"
  >
    create Categories
  </a>
  </br>
  <a href="#" id="createFilters" data-filters-id="<?php echo esc_attr($ss_ids['filters_id']); ?>">create Filters</a>
</main>
<?php
get_footer();
