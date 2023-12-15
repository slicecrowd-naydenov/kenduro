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
        <a href="<?php echo esc_url(get_site_url() . '/product-category/'.$category->slug.'/'.$main_category->slug); ?>" class="paragraph paragraph-l nav-link">
          <?php echo $main_category->name ?>
        </a>
      </li>
  <?php
    endforeach;
  endif;
  ?>
</ul>