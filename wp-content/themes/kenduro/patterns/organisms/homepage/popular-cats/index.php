<?php use Lean\Load; 
$terms = get_field('popular_categories', 'options');
$term_ids = '';

if( $terms ): 
  foreach( $terms as $term ): 
    $term_ids .= $term . ', ';
  endforeach; 
endif; 

$term_ids = rtrim($term_ids, ', ');
?>
<div class="container">
  <div class="row">
    <div class="col">
      <div class="popular-categories">
        <div class="popular-categories__header">
          <p class="paragraph paragraph-xl semibold primary">Популярни Категории</p>
          <?php 
            Load::atoms('link/index', [
              'text' => 'Разгледай всички Продукти',
              'class' => 'underline',
              'url' => 'shop',
              'icon' => 'arrow_down'
            ]); 
          ?>
        </div>
        <hr>
        <?php echo do_shortcode('[product_categories ids="'. $term_ids .'" columns="5"]'); ?>
      </div>
    </div>
  </div>
</div>