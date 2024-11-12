<?php 
use Lean\Load; 

// Определяне на ключ за транзиента
$popular_categories_ids_key = 'popular_categories_ids';

// Опитваме да получим кеширани термини
$term_ids = get_transient($popular_categories_ids_key);

if ($term_ids === false) {
  // Ако няма кеширани данни, извличаме термини
  $terms = get_field('popular_categories', 'options');
  $term_ids = '';

  if ($terms) { 
    foreach ($terms as $term) { 
      $term_ids .= $term . ', ';
    }
    // Премахваме последната запетая
    $term_ids = rtrim($term_ids, ', ');

    // Кешираме терминалните идентификатори за 12 часа (43200 секунди)
    set_transient($popular_categories_ids_key, $term_ids, 12 * HOUR_IN_SECONDS);
  }
}
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
        <?php 
          if ($term_ids) :
            echo do_shortcode('[product_categories ids="'. esc_attr($term_ids) .'" columns="5"]'); 
          endif; 
        ?>
      </div>
    </div>
  </div>
</div>