<?php
  use Lean\Load;

  $args = array(
    'taxonomy' => 'pa_brand',
    'orderby' => 'name', 
    'hide_empty' => true,
    'number' => 20
  );
  
  $terms = get_transient('get_brands_cached');

if (false === $terms) {
  // echo 'Кешът не е наличен. Извличам от базата данни.<br>';

  $terms = get_terms($args);

  if (!empty($terms)) {
    // Запис на резултата в кеша за 1 седмица (604800 секунди)
    set_transient('get_brands_cached', $terms, 604800);
    // echo 'Кешът е запазен.<br>';
  } else {
    // echo 'get_terms() не върна резултати.<br>';
  }
} else {
  // echo 'Кешът е наличен. Зареждам от кеша.<br>';
  // var_dump($main_categories); // Показва кешираните данни
}

?>
<div class="exclusive-brands"> 
  <div class="container">
    <div class="row">
      <div class="col">
        <p class="paragraph paragraph-xl semibold">
          При нас можете да намерите продукти на над 40 бранда.
          <a href="<?php echo get_site_url(); ?>/brands" class="list-all">Разгледай всички</a>
        </p>
        
        <?php if (!empty($terms)) : ?>
          <div 
            class="swiper" 
            data-slider-per-view-mobile="1"
            data-slider-per-view-tablet="2"
            data-slider-per-view="4"
            data-space-between="10"
            data-slider 
            >
            <ul class="brands__list swiper-wrapper">
              <?php foreach ($terms as $term) : 
                $term_id = $term->term_id;
                $term_name = $term->name;
                $term_link = get_term_link($term);
                $meta_fields = get_term_meta($term_id);
                $is_exclusive = isset($meta_fields['exclusive_brand']) && $meta_fields['exclusive_brand'][0];
                $term_logo_id = array_key_exists('exclusive_logo', $meta_fields) && isset($meta_fields['exclusive_logo'][0]) ? $meta_fields['exclusive_logo'][0] : '';
                $term_logo = wp_get_attachment_url($term_logo_id);
                $exclusive_class = $is_exclusive ? 'exclusive-brand' : '';
              ?>
                <li class="brands__list-item swiper-slide <?php echo esc_attr($exclusive_class); ?>">
                  <a href="<?php echo esc_attr($term_link); ?>" class="brands__list-item-link">
                    <img src="<?php echo esc_attr($term_logo)?>" />
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
              <?php endforeach; ?>
            </ul>
            <div class="siwper-navigation">
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>