<?php
$category = get_queried_object();
if (is_product_category()) {
  $cat_term = $category->term_id;
  $cat_slug = $category->slug;
} else {
  $cat_term = 0;
  $cat_slug = '';
}
$cat_term_id = is_product_category() ? get_queried_object() : 0;
// pretty_dump(is_product_category());
$args = array(
  'taxonomy' => 'product_cat',
  'parent' => $cat_term,
  'hide_empty' => true
);
$main_categories = get_terms($args);
// pretty_dump($category);
?>
<ul class="nav nav-pills product-categories-view">
  <?php
  if ($main_categories) :
    ?>
      <li class="nav-item">
        <a href="#" class="nav-link active">
          All
        </a>
      </li>
    <?php
    foreach ($main_categories as $main_category) :
      $args['parent'] = $main_category->term_id;
      $child_categories = get_terms($args); ?>
      <!-- get_site_url() . '/product-category/' . $category->slug . '/?yith_wcan=1&product_cat=' . $category->slug . '+' . $main_category->slug -->
      <li class="nav-item">
        <a href="<?php echo esc_url(get_site_url() . '/product-category/'.$cat_slug.'/'.$main_category->slug); ?>" class="paragraph paragraph-l nav-link">
          <?php echo $main_category->name ?>
        </a>
      </li>
  <?php
    endforeach;
  endif;
  ?>
</ul>