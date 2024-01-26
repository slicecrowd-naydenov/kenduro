<?php 
use Lean\Load;
$args = array(
  'taxonomy' => 'product_cat',
  'parent' => 0,
  'hide_empty' => true
);
$main_categories = get_terms($args);


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
          <!-- <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div> -->
          <ul class="nav nav-pills dropdown-menu" id="pills-tab" role="tablist" aria-labelledby="dropdownMenuButton">
            <li class="nav-item" role="presentation">
              <button class="paragraph paragraph-l nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">Всички</button>
            </li>
            <?php foreach ($main_categories as $main_category) :
              // pretty_dump($main_category);
              $slug = $main_category->slug;
            ?>
              <li class="nav-item" role="presentation">
                <button class="paragraph paragraph-l nav-link" id="pills-<?php echo $slug; ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?php echo $slug; ?>" type="button" role="tab" aria-controls="pills-<?php echo $slug; ?>" aria-selected="false"><?php echo $main_category->name; ?></button>
              </li>
            <?php 
              endforeach;
            ?>
          </ul>
        </div>
        <hr>
        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab">
          <!-- ADD PAGINATION 
          [products limit='10' paginate='true'] 
          ================================= -->
            <?php echo do_shortcode("[products limit='10']"); ?>
            <a href="<?php echo esc_attr(get_site_url()); ?>/shop" class="cat-img">
              <img src="<?php echo IMAGES_PATH; ?>/categories/Image=Grey, For=All Products@2x.jpg" />
              <h4>
                Разгледайте <strong>всички</strong> Kenduro продукти
                <?php Load::atom('svg', ['name' => 'arrow_xl']); ?>
              </h4>
            </a>
          </div>
          <?php foreach ($main_categories as $main_category) :
            $id = $main_category->term_id;
            $slug = $main_category->slug;
            $thumbnail_id = get_term_meta( $main_category->term_id, 'thumbnail_id', true );
            $image_url = wp_get_attachment_url( $thumbnail_id ); 
            // pretty_dump($main_category);
            ?>
            <div class="tab-pane fade" id="pills-<?php echo $slug; ?>" role="tabpanel" aria-labelledby="pills-<?php echo $slug; ?>-tab">
              <?php echo do_shortcode("[products category='".$id."' limit='10']");
              if ($image_url) { ?>             
                <a href="<?php echo esc_url(get_site_url() . '/product-category/'.$main_category->slug.'/')?>" class="cat-img">
                  <img src="<?php echo $image_url; ?>" />
                  <h4>
                    Разгледайте всички <strong><?php echo $main_category->name; ?></strong> продукти
                    <?php Load::atom('svg', ['name' => 'arrow_xl']); ?>
                  </h4>
                </a>
              <?php } ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
