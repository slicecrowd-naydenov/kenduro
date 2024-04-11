<?php
/* Template Name: On sale */
use Lean\Load;

get_header();
?>

<div class="on-sale" id="primary">
  <div class="container">
    <div class="row">
      <div class="col">
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
          
          echo do_shortcode('[awdr_sale_items_list columns="5" per_page="20"]'); ?>
      </div>
    </div>
  </div>
</div>


<?php
get_footer();