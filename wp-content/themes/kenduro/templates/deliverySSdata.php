<?php

// require_once(ABSPATH . 'wp-admin/includes/media.php');
// require_once(ABSPATH . 'wp-admin/includes/file.php');
// require_once(ABSPATH . 'wp-admin/includes/image.php');
/* Template Name: Delivery SS data*/

get_header();

// process_mockup(get_bike_model_types());

$transients = ['wp_nav_menu_cached_mobile', 'wp_nav_menu_cached_desktop', 'get_brands_cached', 'hero_slides_data', 'on_sale_panel_data', 'popular_categories_ids', 'main_categories_transients'];

foreach ($transients as $transient) {
  if (get_transient($transient)) {
    delete_transient($transient);
  }
}

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
        Последно ъпдейтвани на: 
        <b><?php echo get_field('last_date_mass_update', 'option'); ?> </b>(YYYY-MM-DD)
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
        </br>
        <hr>
        <p class="paragraph paragraph-xl">Ъпдейтва/създава Bike Models:</p>
        <a 
          href="#" 
          id="createBikeModels" 
          class="button button-primary-orange"
          data-bike-models-id="<?php echo esc_attr($ss_ids['bike_models']); ?>"
        >create Bike models</a>
        </br>
      </div>
    </div>
  </div>
</main>
<?php
get_footer();
