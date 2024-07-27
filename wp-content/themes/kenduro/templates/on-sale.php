<?php
/* Template Name: On sale */
use Lean\Load;

get_header();
$wccs_products = new WCCS_Products();
$promo_products = $wccs_products->get_discounted_products();
$promo_product_ids = implode(',', $promo_products);

?>

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

          // echo do_shortcode('[wccs_discounted_products]');
          echo do_shortcode('[products ids="'.$promo_product_ids.'" limit="12" columns="4" paginate="true"]');
        ?>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();