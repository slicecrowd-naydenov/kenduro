<?php
  $term = get_queried_object(); // Вземи текущия обект на категорията
  $category_id = $term->term_id; // Вземи ID-то на категорията
	$cat_ss_description = get_field('category_ss_description', 'product_cat_' . $category_id);

  if (!empty($cat_ss_description)) :
?>
<div class="category-description">
  <div class="category-description__box">
    <?php echo $cat_ss_description; ?>
    <div class="read-more button button-secondary-grey paragraph paragraph-l semibold">Прочети още</div>
  </div>
</div>

<?php endif; ?>