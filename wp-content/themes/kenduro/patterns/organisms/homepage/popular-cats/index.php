<?php use Lean\Load; ?>
<div class="popular-categories">
  <div class="popular-categories__header">
    <p class="paragraph paragraph-xl semibold primary">Popular Categories</p>
    <?php 
      Load::atoms('link/index', [
        'text' => 'Browse All Products',
        'class' => 'underline',
        'url' => '#',
        'icon' => 'arrow_down'
      ]); 
    ?>
  </div>
  <hr>
  <?php echo do_shortcode('[product_categories ids="1937, 1941" columns="5"]'); ?>
</div>