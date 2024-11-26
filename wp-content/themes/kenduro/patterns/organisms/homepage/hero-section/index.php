<?php

use Lean\Load;
// process_mockup(get_bike_model_types());

// $moto_icon = file_get_contents(ICON_PATH.'/moto_icon.svg'); 
// Load::molecules('bike-compatibility/index');

$hero_slides_data_key = 'hero_slides_data';

// Опитваме да получим кешираните данни
// delete_transient('hero_slides_data');
$slides_data = get_transient($hero_slides_data_key);

if ($slides_data === false) {
  // Данните не са кеширани, извличаме ги
  if (have_rows('hero')) {
    $slides_data = []; // Създаване на масив за данните
    while (have_rows('hero')) : the_row();
      $slide = [
        'title' => get_sub_field('title'),
        'description' => get_sub_field('description'),
        'logo' => get_sub_field('logo_image'),
        'slide_image' => get_sub_field('slide_image'),
        'cta' => get_sub_field('cta'),
        'has_logo' => get_sub_field('logo_image') ? 'has-logo' : 'no-logo',
      ];
      $slides_data[] = $slide; // Добавяме всеки слайд в масива
    endwhile;

    // Записваме данните в transient за 12 часа (43200 секунди)
    set_transient($hero_slides_data_key, $slides_data, 24 * HOUR_IN_SECONDS);
  }
}


$on_sale_panel_data_key = 'on_sale_panel_data';

// Опитваме да получим кешираните данни
$on_sale_data = get_transient($on_sale_panel_data_key);

if ($on_sale_data === false) {
  // Данните не са кеширани, извличаме ги
  if (have_rows('on_sale_panel')) {
    $on_sale_data = []; // Създаваме масив за данните
    $count = 1;
    
    while (have_rows('on_sale_panel')) : the_row();
      $panel = [
        'percentage_discount' => get_sub_field('percentage_discount'),
        'title' => get_sub_field('title'),
        'expired_text' => get_sub_field('expired_text'),
        'url' => get_sub_field('url'),
        'background_image' => get_sub_field('background_image'),
        'open_by_default' => $count === 1 ? 'opened' : '',
        'aria_expanded_by_default' => $count === 1 ? 'true' : 'false',
        'show_by_default' => $count === 1 ? 'show' : '',
        'collapsed_by_default' => $count === 1 ? '' : 'collapsed',
        'count' => $count
      ];
      $on_sale_data[] = $panel; // Добавяме панела в масива
      $count++;
    endwhile;

    // Записваме данните в транзиент за 12 часа (43200 секунди)
    set_transient($on_sale_panel_data_key, $on_sale_data, 12 * HOUR_IN_SECONDS);
  }
}
?>
<div class="container">
  <div class="row">
    <div class="col">
      <div id="hero-section">
        <?php if (!empty($slides_data)) : ?>
          <div class="swiper" data-slider>
            <div class="swiper-wrapper">
              <?php 
                $first_slide = true;
                foreach ($slides_data as $slide) : 
                $set_no_lazy_class = $first_slide ? 'no-lazy' : '';
                ?>
                <div class="swiper-slide">
                  <?php if ($slide['slide_image']) : 
                    $transformedString = str_replace(['_', '-', '='], ' ', $slide['slide_image']['title']);
                  ?>
                    <div class="slide-image">
                      <img 
                        src="<?php echo esc_attr($slide['slide_image']['url']); ?>" 
                        alt="<?php esc_attr_e($transformedString); ?>" 
                        class="<?php echo $set_no_lazy_class; ?>"
                        srcset="
                          <?php echo $slide['slide_image']['sizes']['woocommerce_thumbnail']; ?> 500w, 
                          <?php echo $slide['slide_image']['sizes']['medium_large']; ?> 768w, 
                          <?php echo $slide['slide_image']['sizes']['large']; ?> 1024w"
                        sizes="
                          (max-width: 456px) 500px,
                          (max-width: 768px) 768px,
                          (max-width: 1024px) 1024px,
                          1260px"
                        <?php if ($first_slide) { ?>
                          rel="preload" 
                          as="image"
                          fetchpriority="high"
                        <?php } ?>
                      >
                    </div>
                  <?php
                  endif;
                  ?>
                  <div class="mobile-slide-view <?php echo esc_attr($slide['has_logo']); ?>">
                    <?php
                    if ($slide['logo']) : ?>
                      <div>
                        <div class="hero-logo">
                          <img 
                            src="<?php esc_attr_e($slide['logo']['url']); ?>" 
                            width="<?php esc_attr_e($slide['logo']['width']); ?>" 
                            height="<?php esc_attr_e($slide['logo']['height']); ?>"
                            alt="<?php esc_attr_e($slide['logo']['title']); ?>"
                          />
                        </div>
                      </div>
                    <?php endif; ?>
                    <div>
                      <?php if ($slide['title']) : ?>
                        <h2 class="hero_title"><?php echo $slide['title']; ?></h2>
                      <?php
                      endif;
                      if ($slide['description']) :
                      ?>
                        <p class="paragraph paragraph-l semibold "><?php echo $slide['description']; ?></p>
                      <?php
                      endif;
                      if ($slide['cta']['text']) :
                      ?>
                        <a href="<?php echo esc_attr($slide['cta']['url']) ?>" class="button button-primary-orange">
                          <span><?php echo $slide['cta']['text']; ?></span>
                        </a>
                      <?php
                      endif;
                      ?>
                    </div>
                  </div>
                </div>
              <?php $first_slide = false; endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        <?php endif; ?>

        <?php if (!empty($on_sale_data)) : ?>
          <div class="on-sale-container">
            <div class="on-sale-header">
              <h4 class="bold">Намалени в момента</h4>
              <?php 
                Load::atoms('link/index', [
                  'text' => 'Виж всички',
                  'class' => 'underline',
                  'url' => 'promotions',
                  'icon' => 'arrow_down'
                ]); 
              ?>
            </div>
            <div class="accordion accordion-flush" id="accordionOnSales">
              <?php foreach ($on_sale_data as $panel) : ?>
                <div class="accordion-item <?php esc_attr_e($panel['open_by_default']); ?>" id="accordion-item-<?php esc_attr_e($panel['count']); ?>" style="background-image: url(<?php echo esc_url($panel['background_image']); ?>)">
                  <div class="accordion-header">
                    <button class="accordion-button <?php esc_attr_e($panel['collapsed_by_default']); ?>" data-current-index="<?php esc_attr_e($panel['count']); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-<?php esc_attr_e($panel['count']); ?>" aria-expanded="<?php esc_attr_e($panel['aria_expanded_by_default']); ?>" aria-controls="flush-collapse-<?php esc_attr_e($panel['count']); ?>">
                      <div class="on-sale-percentage">
                        <?php echo esc_html($panel['percentage_discount']); ?>
                      </div>
                      <div>
                        <strong><?php echo esc_html($panel['title']); ?></strong>
                        <span class="expired-date"><?php echo esc_html($panel['expired_text']); ?></span>
                      </div>
                    </button>
                  </div>
                  <div id="flush-collapse-<?php esc_attr_e($panel['count']); ?>" class="accordion-collapse collapse <?php esc_attr_e($panel['show_by_default']); ?>" data-bs-parent="#accordionOnSales">
                    <div class="accordion-body">
                      <a href="<?php echo esc_url($panel['url']); ?>" class="button button-secondary-grey paragraph paragraph-l semibold">
                        <span>Виж промоциите</span>
                        <?php Load::atom('svg', ['name' => 'arrow_orange']); ?>
                      </a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>