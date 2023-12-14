<?php 
  use Lean\Load; 

// $moto_icon = file_get_contents(ICON_PATH.'/moto_icon.svg'); ?>
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
                $cta = get_sub_field('cta');
              ?>
                <div class="swiper-slide">
                  <?php if ($image) : ?>
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
                    <a href="<?php echo esc_attr($cta['url']) ?>" class="button"><?php echo $cta['text']; ?></a>
                  <?php
                  endif;
                  ?>
                </div>
              <?php endwhile; ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
          <div class="hero-banner">
            <div class="hero-banner__header">
              <p class="paragraph paragraph-xl semibold primary">Your Kenduro ❤️</p>
              <a href="#" class="paragraph paragraph-m primary">Log in My Account</a>
            </div>
            <ul class="hero-banner__list">
              <li class="paragraph paragraph-l regular">See products that fit only for your bike</li>
              <li class="paragraph paragraph-l regular">Clothes that you like</li>
              <li class="paragraph paragraph-l regular">Get access to special discounts and offers</li>
            </ul>
            <div class="hero-banner__add-bike">
              <a href="#">
                <div class="moto-icon">
                  <?php Load::atom('svg', ['name' => 'moto_icon']); ?>
                </div>
                <div class="text">
                  <p class="paragraph paragraph-l semibold primary">Add Your Bike</p>
                  <p class="paragraph paragraph-m tetriary regular">And get up to 10% discount on everything</p>
                </div>
              </a>
            </div>
          </div>
        <?php endif; ?>
      <!-- </div>
    </div>
  </div> -->
</div>