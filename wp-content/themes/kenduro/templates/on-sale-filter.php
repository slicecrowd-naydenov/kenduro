<?php
/* Template Name: On sale filter */
use Lean\Load;

get_header();
?>

<div class="on-sale" id="primary">
  <div class="container">
    <div class="row">
      <div class="col">
        <h3>Промоции</h3>
					<div class="mobile-wrapper filter-sidebar">
            <?php
              if (wp_is_mobile()) {
                ?>
                <!-- Button trigger modal -->
                <button type="button" class="button filter-modal" data-toggle="modal" data-target="#filterModal">
                  Филтри
                </button>

                <!-- Modal -->
                <div class="modal fade mobile-modal" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Филтри</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <?php Load::atom('svg', ['name' => 'close']); ?>
                        </button>
                      </div>
                      <div class="modal-body">
                        <?php
                          Load::molecules('product-category/product-categories-filter/index');
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
              } else {
                Load::molecules('product-category/product-categories-filter/index');
              }
            ?>
          </div>
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