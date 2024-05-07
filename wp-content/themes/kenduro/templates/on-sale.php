<?php
/* Template Name: On sale */
use Lean\Load;

get_header();
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
        ?>
        <?php echo do_shortcode('[awdr_sale_items_list columns="5" per_page="20"]'); ?>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();