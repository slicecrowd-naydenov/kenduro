<?php
$category = get_queried_object();
$args = array(
  'taxonomy' => 'product_cat',
  'parent' => $category->term_id,
  'hide_empty' => true
);
$main_categories = get_terms($args);
// pretty_dump($category);
?>
<div class="product-categories-view">
  <?php
  if ($main_categories) :
    foreach ($main_categories as $main_category) :
      $args['parent'] = $main_category->term_id;
      $child_categories = get_terms($args); ?>
      <!-- get_site_url() . '/product-category/' . $category->slug . '/?yith_wcan=1&product_cat=' . $category->slug . '+' . $main_category->slug -->
      <a href="<?php echo esc_url(get_site_url() . '/product-category/'.$category->slug.'/'.$main_category->slug); ?>" class="product-categories-view__item paragraph paragraph-m tetriary">
        <?php echo $main_category->name ?>
      </a>
  <?php
    endforeach;
  endif;
  ?>
</div>