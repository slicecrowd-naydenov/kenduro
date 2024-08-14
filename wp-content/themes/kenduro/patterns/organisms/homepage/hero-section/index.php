<?php

use Lean\Load;

// $moto_icon = file_get_contents(ICON_PATH.'/moto_icon.svg'); 
// Load::molecules('bike-compatibility/index');
?>
<div class="container">
  <div class="row">
    <div class="col">
      <div id="hero-section">
        <?php if (have_rows('hero')) : ?>
          <div class="swiper" data-slider>
            <div class="swiper-wrapper">
              <?php while (have_rows('hero')) : the_row();
                $title = get_sub_field('title');
                $description = get_sub_field('description');
                $image = get_sub_field('logo_image');
                $slide_image = get_sub_field('slide_image');
                $cta = get_sub_field('cta');
              ?>
                <div class="swiper-slide">
                  <?php if ($slide_image) : ?>
                    <div class="slide-image">
                      <img src="<?php echo esc_attr($slide_image['url']); ?>" alt="" class="no-lazy">
                    </div>
                  <?php
                  endif;
                  ?>
                  <div class="mobile-slide-view">
                    <?php
                    if ($image) : ?>
                      <div class="hero-logo">
                        <img src="<?php echo esc_attr($image['url']); ?>" />
                      </div>
                    <?php
                    endif;
                    if ($title) : ?>
                      <h2 class="hero_title"><?php echo $title; ?></h2>
                    <?php
                    endif;
                    if ($description) :
                    ?>
                      <p class="paragraph paragraph-l semibold "><?php echo $description; ?></p>
                    <?php
                    endif;
                    if ($cta['text']) :
                    ?>
                      <a href="<?php echo esc_attr($cta['url']) ?>" class="button button-primary-orange">
                        <span><?php echo $cta['text']; ?></span>
                      </a>
                    <?php
                    endif;
                    ?>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        <?php endif; ?>

        <?php if (have_rows('on_sale_panel')) : 
          
          $count = 1; ?>
          <div class="on-sale-container">
            <div class="on-sale-header">
              <h4 class="bold">Намалени в момента</h4>
              <?php 
                Load::atoms('link/index', [
                  'text' => 'Виж всички',
                  'class' => 'underline',
                  'url' => 'shop',
                  'icon' => 'arrow_down'
                ]); 
              ?>
            </div>
            <div class="accordion accordion-flush" id="accordionOnSales">
              <?php while (have_rows('on_sale_panel')) : the_row(); 
                $open_by_default = $count === 1 ? 'opened' : ''; 
                $aria_expanded_by_default = $count === 1 ? true : false; 
                $show_by_default = $count === 1 ? 'show' : ''; 
                $collapsed_by_default = $count === 1 ? '' : 'collapsed'; 

                $percentage_discount = get_sub_field('percentage_discount');
                $title = get_sub_field('title');
                $expired_text = get_sub_field('expired_text');
                $url = get_sub_field('url');
                $background_image = get_sub_field('background_image');
                // $background = 
                // pretty_dump($background_image);
              ?>
                <div class="accordion-item <?php esc_attr_e($open_by_default); ?>" id="accordion-item-<?php esc_attr_e($count); ?>" style="background-image: <?php echo esc_url($background_image); ?>">
                  <div class="accordion-header">
                    <button class="accordion-button <?php esc_attr_e($collapsed_by_default); ?>" data-current-index="<?php esc_attr_e($count); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-<?php esc_attr_e($count); ?>" aria-expanded="<?php esc_attr_e($aria_expanded_by_default); ?>" aria-controls="flush-collapse-<?php esc_attr_e($count); ?>">
                      <div class="on-sale-percentage">
                        <?php echo $percentage_discount;?>
                      </div>
                      <div>
                        <strong><?php echo $title;?></strong>
                        <span class="expired-date"><?php echo $expired_text;?></span>
                      </div>
                    </button>
                  </div>
                  <div id="flush-collapse-<?php esc_attr_e($count); ?>" class="accordion-collapse collapse <?php esc_attr_e($show_by_default); ?>" data-bs-parent="#accordionOnSales">
                    <div class="accordion-body">
                      <a href="<?php echo esc_url($url); ?>" class="button button-secondary-grey paragraph paragraph-l semibold">
                        <span>Виж промоциите</span>
                        <?php Load::atom('svg', ['name' => 'arrow_orange']); ?>
                      </a>
                    </div>
                  </div>
                </div>

              <?php $count++; endwhile; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>