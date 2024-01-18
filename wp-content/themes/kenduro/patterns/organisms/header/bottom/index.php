<?php

use Lean\Load;

$chosenCat = '';
$args = array(
  'taxonomy' => 'product_cat',
  'parent' => 0,
  'hide_empty' => true
);
$main_categories = get_terms($args);

?>
<div id="bottom-section" class="storefront-primary-navigation">
  <div class="container">
    <div class="row">
      <div class="col">
        <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Primary Navigation">
          <button id="site-navigation-menu-toggle" class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span>Menu</span></button>
          <div class="primary-navigation">
            <div id="mobile-nav" class="mobile-nav">
              <div class="mobile-nav__search">
                <?php Load::atom('svg', ['name' => 'search']); ?>
              </div>
              <div class="mobile-nav__logo">
                <?php Load::molecules('logo/index'); ?>
              </div>
              <div class="mobile-nav__close">
                <?php Load::atom('svg', ['name' => 'close']); ?>
              </div>
            </div>
            <?php if ($main_categories) : ?>
              <ul class="main-menu" aria-expanded="false">
                <?php foreach ($main_categories as $main_category) : ?>
                  <?php
                  $category_link = get_term_link($main_category);
                  $args['parent'] = $main_category->term_id;
                  $child_categories = get_terms($args);
                  ?>
                  <li class="menu-item menu-item-type-post_type menu-item-object-page page_item <?php echo $child_categories ? 'menu-item-has-children' : ''; ?>">
                    <span class="cat-name">
                      <?php
                      echo $main_category->name;
                      if ($child_categories) {
                        Load::atom('svg', ['name' => 'arrow_down']);
                      }
                      ?>
                    </span>
                    <?php if ($child_categories) : ?>
                      <ul class="sub-menu">
                        <li class="sub-menu-head-mobile">
                          <div class="sub-menu-head-mobile__close">
                            <?php Load::atom('svg', ['name' => 'arrow_down']); ?>
                          </div>
                          <div class="sub-menu-head-mobile__cat"><?php echo $main_category->name; ?></div>
                        </li>
                        <li class="sub-menu__item-mobile">
                          <a href="<?php echo esc_url($category_link); ?>">
                            Виж всички <?php echo $main_category->name; ?>
                            <span>
                              <?php Load::atom('svg', ['name' => 'arrow_down']); ?>
                            </span>
                          </a>
                        </li>
                        <?php foreach ($child_categories as $child_category) : ?>
                          <li class="sub-menu__item">
                            <?php
                            $child_category_link = get_term_link($child_category);
                            // get_site_url() . '/product-category/' . $main_category->slug . '/?yith_wcan=1&product_cat=' . $main_category->slug . '+' . $child_category->slug
                            ?>
                            <a href="<?php echo esc_url($child_category_link); ?>" class="sub-menu__item-link">
                              <?php echo $child_category->name ?>
                              <span>
                                <?php Load::atom('svg', ['name' => 'arrow_down']); ?>
                              </span>
                            </a>
                            <?php
                            $args['parent'] = $child_category->term_id;
                            $sub_child_categories = get_terms($args);

                            if ($sub_child_categories) : ?>
                              <ul class="sub-sub-menu">
                                <div class="sub-sub-menu-head-mobile">
                                  <div class="sub-sub-menu-head-mobile__close">
                                    <?php Load::atom('svg', ['name' => 'arrow_down']); ?>
                                  </div>
                                  <div class="sub-sub-menu-head-mobile__cat"><?php echo $child_category->name; ?></div>
                                </div>
                                <li class="sub-sub-menu__item-mobile">
                                  <a href="<?php echo esc_url($child_category_link); ?>">
                                    Виж всички <?php echo $child_category->name; ?>
                                    <span>
                                      <?php Load::atom('svg', ['name' => 'arrow_down']); ?>
                                    </span>
                                  </a>
                                </li>
                                <?php foreach ($sub_child_categories as $sub_child_category) : ?>
                                  <li>
                                    <?php
                                    $sub_child_category_link = get_term_link($sub_child_category);
                                    // get_site_url() . '/product-category/' . $main_category->slug . '/?yith_wcan=1&product_cat=' . $main_category->slug . '+' . $sub_child_category->slug
                                    ?>
                                    <a href="<?php echo esc_url($sub_child_category_link); ?>" class="sub-sub-menu__item-link">
                                      <?php echo $sub_child_category->name ?>
                                      <span>
                                        <?php Load::atom('svg', ['name' => 'arrow_down']); ?>
                                      </span>
                                    </a>
                                    <?php
                                    ?>
                                  </li>
                                <?php endforeach; ?>
                              </ul>
                            <?php endif; ?>
                          </li>
                        <?php endforeach; ?>
                        <li class="main-category-link">
                          <a href="<?php echo esc_url($category_link); ?>">
                            View all products in <?php echo $main_category->name; ?>
                            <span>
                              <?php Load::atom('svg', ['name' => 'arrow_down']); ?>
                            </span>
                          </a>
                        </li>
                        <!-- <li class="product-of-the-week">
                          <p class="paragraph paragraph-m regular">Prdouct of the week</p>
                          <?php // echo do_shortcode("[products ids='5420']"); ?> 
                        </li> -->
                      </ul>
                    <?php endif; ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </nav>
      </div>
    </div>
  </div>
</div>