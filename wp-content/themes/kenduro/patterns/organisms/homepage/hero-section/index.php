<?php

use Lean\Load;

// $moto_icon = file_get_contents(ICON_PATH.'/moto_icon.svg'); 
?>
<div id="hero-section">
  <!-- <div class="container">
    <div class="row">
      <div class="col"> -->
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
            <div class="container">
              <div class="row">
                <div class="col">
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
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
    <div class="hero-banner">
      <div class="hero-banner__box">
        <div>
          <div class="hero-banner__header">
            <p class="paragraph paragraph-xl semibold primary">Your Personal Kenduro ❤️</p>
          </div>
          <ul class="hero-banner__list">
            <li class="paragraph paragraph-l regular">See products that fit only for your bike</li>
            <li class="paragraph paragraph-l regular">Clothes that you like</li>
            <li class="paragraph paragraph-l regular">Get access to special discounts and offers</li>
          </ul>
        </div>
        <div class="hero-banner__add-bike">
          <a href="#">
            <div class="moto-icon">
              <?php Load::atom('svg', ['name' => 'moto_icon']); ?>
            </div>
            <div class="text">
              <p class="paragraph paragraph-m regular primary">Add Your Bike</p>
            </div>
          </a>
        </div>
      </div>
      <div class="hero-banner__box">
        <div>
          <div class="hero-banner__header">
            <p class="paragraph paragraph-xl semibold primary">Одобрено от Teo ✊</p>
          </div>
          <p class="paragraph paragraph-m regular primary info">
            <b>Тео Кабакчиев</b>
            , световноизвестен хард ендуро състезател, ръководи Kenduro.com с непоколебима страст, гарантирайки нашия непоколебим ангажимент към първокласни услуги и качество.
            <?php
            // Load::atoms('link/index', [
            //   'text' => 'Learn more',
            //   'url' => '#'
            // ]); 
            ?>
          </p>
        </div>
        <img class="hero-banner__image" src="<?php echo IMAGES_PATH; ?>/teo_kabakchiev_bg.png" alt="teo_kabakchiev">
      </div>
    </div>
  <?php endif; ?>
  <!-- </div>
    </div>
  </div> -->
</div>