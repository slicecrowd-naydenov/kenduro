<?php
/* Template Name: Brands */
use Lean\Load;

get_header();

$args = array(
  'taxonomy' => 'pa_brand',
  'orderby' => 'name', 
  'hide_empty' => true
);

$terms = get_terms($args);
?>

<div class="brands" id="primary">
  <div class="container">
    <div class="row">
      <div class="col">
        <h3 class="semibold">Производители</h3>
        <h1 class="hidden-h1">Производители</h1>
        <div class="mobile-wrapper">
          <?php
            Load::molecules('product-category/product-categories-view/index');
          ?>
				</div>
        <ul class="brands__list">
          <?php

            if (!empty($terms)) {
              foreach ($terms as $term) {
                $term_id = $term->term_id;
                $term_name = $term->name;
                $term_link = get_term_link($term);
                $meta_fields = get_term_meta($term_id);
                $is_exclusive = isset($meta_fields['exclusive_brand']) && $meta_fields['exclusive_brand'][0];
                $term_logo_id = array_key_exists('exclusive_logo', $meta_fields) && isset($meta_fields['exclusive_logo'][0]) ? $meta_fields['exclusive_logo'][0] : '';
                $term_logo = $term_logo_id != 0 ? wp_get_attachment_url($term_logo_id) : IMAGES_PATH.'/no-logo.jpg';
                $exclusive_class = $is_exclusive ? 'exclusive-brand' : '';
                ?>
                <li class="brands__list-item <?php echo esc_attr($exclusive_class); ?>">
                  <a href="<?php echo esc_attr($term_link); ?>" class="brands__list-item-link">
                    <img src="<?php echo esc_attr($term_logo)?>" alt="<?php echo esc_attr(strtolower($term_name)); ?>"/>
                  </a>
                  <a href="<?php echo esc_attr($term_link); ?>" class="paragraph paragraph-xl brand_name">
                    <?php echo $term_name; ?>
                    <?php if ($is_exclusive) : ?>
                      <p class="paragraph paragraph-m exclusive-banner">
                        <?php Load::atom('svg', ['name' => 'star-filled']); ?>
                        Ексклузивен партньор
                      </p>
                    <?php endif; ?>
                  </a>
                </li>
                <?php
              }
            }
          ?>

        </ul>

          <?php
            Load::molecules('product-category/product-category-info/index', [
              'title' => '<span class="highlighted">K</span>enduro е изработен от Teo',
              'class' => 'full-width-container',
              'description' => 'Тео Кабакчиев, световноизвестен хард ендуро състезател, ръководи Kenduro.com с непоколебима страст, гарантирайки нашия непоколебим ангажимент към услуги и качество от най-високо ниво.'
            ]);

            // echo do_shortcode('[products limit="12" columns="5" best_selling="true"]');
          ?>
      </div>
    </div>
  </div>

  <?php 
    Load::molecules('exclusive-brands/index');
    // Load::molecules('best-selling-products/index'); 
  ?>
</div>


<?php
get_footer();