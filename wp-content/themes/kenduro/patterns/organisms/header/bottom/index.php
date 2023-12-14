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
                        <?php foreach ($child_categories as $child_category) : ?>
                          <li class="sub-menu__item">
                            <?php
                            $child_category_link = get_term_link($child_category); 
                            // get_site_url() . '/product-category/' . $main_category->slug . '/?yith_wcan=1&product_cat=' . $main_category->slug . '+' . $child_category->slug
                            ?>
                            <a href="<?php echo esc_url($child_category_link); ?>" class="sub-menu__item-link">
                              <?php echo $child_category->name ?>
                            </a>
                            <?php
                            $args['parent'] = $child_category->term_id;
                            $sub_child_categories = get_terms($args);

                            if ($sub_child_categories) : ?>
                              <ul class="sub-sub-menu">
                                <?php foreach ($sub_child_categories as $sub_child_category) : ?>
                                  <li>
                                    <?php
                                    $sub_child_category_link = get_term_link($sub_child_category); 
                                    // get_site_url() . '/product-category/' . $main_category->slug . '/?yith_wcan=1&product_cat=' . $main_category->slug . '+' . $sub_child_category->slug
                                    ?>
                                    <a href="<?php echo esc_url($sub_child_category_link); ?>" class="sub-sub-menu__item-link">
                                      <?php echo $sub_child_category->name ?>
                                    </a>
                                    <?php
                                    ?>
                                  </li>
                                <?php endforeach; ?>
                              </ul>
                            <?php endif; ?>
                          </li>
                        <?php endforeach; ?>
                        <div class="main-category-link">
                          <a href="<?php echo esc_url($category_link); ?>">
                            View all products in <?php echo $main_category->name; ?>
                            <span>
                              <?php Load::atom('svg', ['name' => 'arrow_down']); ?>
                            </span>
                          </a>
                        </div>
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