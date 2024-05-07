<?php
/* Template Name: On sale */
// use Lean\Load;

get_header();
?>

<div class="on-sale" id="primary">
  <div class="container">
    <div class="row">
      <div class="col">
        <?php echo do_shortcode('[awdr_sale_items_list columns="5"]'); ?>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();