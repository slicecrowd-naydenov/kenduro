<?php 
use Lean\Load;
$args = array(
  'taxonomy' => 'product_cat',
  'parent' => 0,
  'hide_empty' => true
);
$main_categories = get_terms($args);


if ($main_categories) : ?>

  <ul class="nav nav-pills" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">All</button>
    </li>
    <?php foreach ($main_categories as $main_category) :
      // pretty_dump($main_category);
      $slug = $main_category->slug;
    ?>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-<?php echo $slug; ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?php echo $slug; ?>" type="button" role="tab" aria-controls="pills-<?php echo $slug; ?>" aria-selected="false"><?php echo $main_category->name; ?></button>
      </li>
    <?php 
      endforeach;
      Load::atoms('link/index', [
        'text' => 'Browse All Products',
        'class' => 'underline',
        'url' => '#',
        'icon' => 'arrow_down'
      ]); 
    ?>
  </ul>
  <hr>
  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
    <!-- ADD PAGINATION 
    [products limit='10' paginate='true'] 
    ================================= -->
      <?php echo do_shortcode("[products limit='10']"); ?> 
    </div>
    <?php foreach ($main_categories as $main_category) :
      $id = $main_category->term_id;
      $slug = $main_category->slug;
    ?>
      <div class="tab-pane fade" id="pills-<?php echo $slug; ?>" role="tabpanel" aria-labelledby="pills-<?php echo $slug; ?>-tab">
        <?php echo do_shortcode("[products category='".$id."' limit='10']"); ?>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
