<?php
/* Template Name: On sale filter */
use Lean\Load;

get_header();
?>

<style>
.on-sale .filter-content-wrapper .woocommerce {
  width: 100%;
}
</style>

<div class="on-sale" id="primary">
  <div class="container">
    <div class="row">
      <div class="col">
        <h3>Промоции</h3>
        <?php
          Load::molecules('product-category/product-category-info/index', [
            'title' => 'Разгледайте настоящите промоции в Kenduro',
            'class' => 'discount-container',
            // 'description' => 'Разгледайте детайлно нашите намалени продукти.',
            // 'cat' => 'намалени продукти',
            // 'cat_img_inner' => $cat_inner_image_url
          ]);
        ?>
				<div class="filter-content-wrapper">
          <?php if (get_option('wdr_on_sale_list')) { 
            $promo_products = get_option('wdr_on_sale_list')['list'];   
            $promo_product_ids = implode(',', $promo_products);
            ?>

          <div class="products-wrapper">
            <?php 
              echo do_shortcode('[products ids="'.$promo_product_ids.'" limit="12" columns="4" paginate="true"]');
            ?>
            </div> 
        <?php
          } else { ?>
          <div class="products-wrapper">
          <?php 
            // echo do_shortcode('[awdr_sale_items_list columns="4" per_page="20"]'); 
            echo do_shortcode('[products]');
            // echo do_shortcode('[products ids="12527, 12538, 12522, 12534, 12869"]');
            // echo do_shortcode('[products attribute="pa_brand" terms="garmin"]');
          ?>
          </div>
          <?php }// echo do_shortcode('[wpf-products]'); ?>
          <div class="filter-sidebar">
            <?php
              // $list_categories($taxonomies, array());
            ?>
            <p class="paragraph paragraph-xl semibold cat-head active-cat filters">Филтри</p>
            <?php echo do_shortcode('[wpf-filters id=2]'); ?>

          </div> 
        </div>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();