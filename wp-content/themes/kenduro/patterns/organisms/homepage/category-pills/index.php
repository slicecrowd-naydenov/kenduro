<?php 
use Lean\Load;

// $main_categories = get_transient('main_categories_transients');

// if (false === $main_categories) {
//   echo 'Кешът не е наличен. Записвам кеш за main_categories.<br>';
  
//   global $wpdb;

//   // Извършване на SQL заявка за извличане на основните категории
//   $sql = "
//     SELECT t.term_id, t.name, t.slug
//     FROM {$wpdb->terms} AS t
//     INNER JOIN {$wpdb->term_taxonomy} AS tt ON t.term_id = tt.term_id
//     WHERE tt.taxonomy = 'product_cat' AND tt.parent = 0 AND tt.count > 0
//   ";

//   $main_categories = $wpdb->get_results($sql);

//   set_transient('main_categories_transients', $main_categories, 3600);
// } else {
//   echo 'Кешът е наличен. Зареждам от кеша.<br>';
// }

$args = array(
  'taxonomy' => 'product_cat',
  'parent' => 0,
  'hide_empty' => true
);
$main_categories = get_terms($args);
// $main_categories = get_transient('main_categories_transients');

// if (false === $main_categories) {
//   echo 'Кешът не е наличен. Записвам кеш за main_categories.<br>';
//   set_transient('main_categories_transients', $main_categories, 3600);
// } else {
//   echo 'Кешът е наличен. Зареждам от кеша.<br>';
//   // pretty_dump($main_categories); // Показва кешираните данни
// }

// $main_categories = wp_cache_get('main_categories', 'custom_group');

// if (false === $main_categories) {
//   echo 'Кешът не е наличен. Записвам кеш за main_categories.<br>';
//   $main_categories = get_terms($args);
//   wp_cache_set('main_categories', $main_categories, 'custom_group', 3600); // Запис в кеша
// } else {
//   echo ('Кешът е наличен. Зареждам от кеша.<br>');
//   pretty_dump($main_categories); // Показва съдържанието на кеша
// }

if ($main_categories) : ?>

<div class="category-pills">
  <div class="container">
    <div class="row">
      <div class="col">
        <?php
          Load::atoms('link/index', [
            'text' => 'Разгледай всички Продукти',
            'class' => 'underline',
            'url' => 'shop',
            'icon' => 'arrow_down'
          ]); 
        ?>
        <div class="dropdown">
          <p class="paragraph paragraph-xl semibold dropdown__head">Kenduro Продукти</p>
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Всички Продукти
          </button>
          <ul class="nav nav-pills dropdown-menu" id="pills-tab" role="tablist" aria-labelledby="dropdownMenuButton">
            <li class="nav-item" role="presentation">
              <button class="paragraph paragraph-l nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">Всички</button>
            </li>
            <?php foreach ($main_categories as $id => $info) : ?>
              <li class="nav-item" role="presentation">
                <button class="paragraph paragraph-l nav-link" id="pills-<?php echo $info->slug; ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?php echo $info->slug; ?>" type="button" role="tab" aria-controls="pills-<?php echo $info->slug; ?>" aria-selected="false" data-category-id="<?php echo $info->term_id; ?>">
                  <?php echo $info->name; ?>
                </button>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <hr>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
          <!-- ADD PAGINATION 
          [products limit='10' paginate='true'] 
          ================================= -->
            <?php echo do_shortcode("[products limit='10' columns='5']"); ?>
            <a href="<?php echo esc_attr(get_site_url()); ?>/shop" class="cat-img">
              <img src="<?php echo IMAGES_PATH; ?>/categories/Image=Grey, For=All Products.jpg" />
              <h4>
                Разгледайте <strong>всички</strong> Kenduro продукти
                <?php Load::atom('svg', ['name' => 'arrow_xl']); ?>
              </h4>
            </a>
          </div>
          <?php foreach ($main_categories as $id => $info) : ?>
            <div class="tab-pane fade" id="pills-<?php echo $info->slug; ?>" role="tabpanel" aria-labelledby="pills-<?php echo $info->slug; ?>-tab">
              <div id="products-<?php echo $info->term_id; ?>">
                <p class="paragraph paragraph-xl">Зареждане на продукти...</p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
