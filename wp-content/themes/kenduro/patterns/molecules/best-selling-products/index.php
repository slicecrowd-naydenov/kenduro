<?php
$args = array(
  'post_type'      => 'product',
  'posts_per_page' => -1,
  'meta_key'       => 'total_sales',
  'meta_query'     => array(
    array(
      'key'     => 'total_sales',
      'value'   => 0,
      'compare' => '>',
      'type'    => 'NUMERIC',
    ),
  ),
  'orderby'        => 'meta_value_num',
  'order'          => 'DESC',
);

$best_selling_query = new WP_Query($args);

if ($best_selling_query->have_posts()) { ?>
  <div class="best-selling">
    <div class="container">
      <div class="row">
        <div class="col">
          <p class="paragraph paragraph-xl semibold primary title">Top Sellers Last Week</p>
          <div class="swiper" data-slider>
            <ul class="swiper-wrapper">
              <?php
              $product_count = 0; // Counter for products
              while ($best_selling_query->have_posts()) {
                $best_selling_query->the_post();
                $product = wc_get_product(get_the_ID());
                $product_classes = implode(' ', wc_get_product_class('', $product));
                $product_image = has_post_thumbnail() ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'single-post-thumbnail')[0] : wc_placeholder_img_src();
              ?>

                <?php if ($product_count % 5 === 0) : ?>
                  <li class="swiper-slide">

                    <div class="woocommerce columns-5">
                      <ul class="products columns-5">
                      <?php endif; ?>

                      <li class="product <?php echo esc_attr($product_classes); ?>">
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                          <div class='wc-img-wrapper'>
                            <?php
                            // Product image
                            echo '<img src="' . esc_url($product_image) . '" alt="' . esc_attr(get_the_title()) . '" />';
                            ?>
                          </div>
                          <?php
                          // Product title
                          echo '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';

                          // Product price
                          echo '<span class="price">' . $product->get_price_html() . '</span>';
                          ?>
                        </a>
                      </li>

                      <?php if ($product_count % 5 === 4 || $product_count === $best_selling_query->post_count - 1) : ?>
                      </ul>
                    </div>
                  </li>
                <?php endif; ?>

              <?php
                $product_count++;
              }
              ?>
            </ul>
            <div class="swiper-pagination"></div>
            <div class="siwper-navigation">
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
  wp_reset_postdata();
}
?>