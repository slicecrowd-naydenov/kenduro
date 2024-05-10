<?php

// require_once(ABSPATH . 'wp-admin/includes/media.php');
// require_once(ABSPATH . 'wp-admin/includes/file.php');
// require_once(ABSPATH . 'wp-admin/includes/image.php');
/* Template Name: Delivery SS data*/

get_header();

?>
<main>
  <div class="container">
    <div class="row">
      <div class="col">

        
        <?php $ss_ids = get_field('ss_ids', 'option');
        $offset = get_field('offset_product', 'option') ? get_field('offset_product', 'option') : 0;
        $limit = get_field('limit_product', 'option') ? get_field('limit_product', 'option') : 5;
        ?>
        <p class="paragraph paragraph-xl">Ъпдейтва/създава продукти от датата на последния ъпдейт до днешна дата:</p>
        <a 
          href="#" 
          id="updateProducts"
          class="button button-error"
          data-products-id="<?php echo esc_attr($ss_ids['products_app_id']); ?>" 
          data-offset="<?php echo $offset; ?>" 
          data-limit="<?php echo $limit; ?>"
        >update Products</a>
        </br>
        <hr>
        <p class="paragraph paragraph-xl">Ъпдейтва/създава марки:</p>
        <a 
          href="#" 
          id="createBrands" 
          class="button button-primary-orange"
          data-brands-id="<?php echo esc_attr($ss_ids['filter_brands']); ?>"
        >create Brands</a>
        </br>
        <hr>
        <p class="paragraph paragraph-xl">Ъпдейтва/създава категории:</p>
        <a 
          href="#" 
          id="createCategories" 
          class="button button-primary-orange"
          data-main-cat-id="<?php echo esc_attr($ss_ids['main_category_id']); ?>" 
          data-child-cat-id="<?php echo esc_attr($ss_ids['child_category_id']); ?>" 
          data-sub-child-cat-id="<?php echo esc_attr($ss_ids['sub_child_category_id']); ?>"
        >
          create Categories
        </a>
        </br>
        <hr>
        <p class="paragraph paragraph-xl">Ъпдейтва/създава филтри:</p>
        <a 
          href="#" 
          id="createFilters"
          class="button button-primary-orange"
          data-filters-id="<?php echo esc_attr($ss_ids['filters_id']); ?>"
        >create Filters</a>
      </div>
    </div>
  </div>
</main>
<?php
get_footer();
