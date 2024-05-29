<?php 
  $args = wp_parse_args($args, [
    'permalink'   => null,
    'attr'        => null,
    'price'       => null,
    'id'          => null,
    'title'       => null,
    'description' => null,
    'bg_pattern'  => null
  ]);


  // pretty_dump($args);

  $attr = $args['attr'];
  // $attr_color = isset($attr['attribute_pa_color']) && $attr['attribute_pa_color'] !== '' ? '<span>Цвят: '.urldecode($attr['attribute_pa_color']).'</span>' : '';
  // $attr_size = isset($attr['attribute_pa_size']) && $attr['attribute_pa_size'] !== '' ? '<span>Размер: '.urldecode($attr['attribute_pa_size']).'</span>' : '';
  // $attr_flower = isset($attr['attribute_pa_flower_type']) && $attr['attribute_pa_flower_type'] !== '' ? '<span>Тип: '.urldecode($attr['attribute_pa_flower_type']).'</span>' : '';
?>
  <li class="wc-block-grid__product fade-in">
    <a href="<?php echo $args['permalink'] ?>" class="wc-block-grid__product-link">
    </a>
    <?php if ($args['description']) { ?>
      <!-- if we have description, we opening this tag here -->
      <div class="wc-block-grid__product-description-wrapper">
    <?php } ?>

    <div class="wc-block-grid__product-info-wrapper">
      <div class="wc-block-grid__product-info-wrapper-inner">
        <a href="<?php echo $args['permalink'] ?>" class="wc-block-grid__product-title">
          <?php //echo $args['title'] . $attr_color . $attr_size . $attr_flower; ?>
          <strong><?php echo $args['title']; ?> </strong>
        </a>
        <div class="wc-block-grid__product-price-wrapper">
          <div class="wc-block-grid__product-price-wrapper-inner">
            <?php echo wp_kses_post($args['price']); ?>
          </div>
        </div>
      </div>
      <div class="wp-block-button wc-block-grid__product-add-to-cart"><a href="?add-to-cart=<?php echo $args['id'] ?>" aria-label="Add <?php echo $args['title'] ?> to your cart" data-quantity="1" data-product_id="<?php echo $args['id'] ?>" data-product_sku="" rel="nofollow" class="wp-block-button__link add_to_cart_button" style="background-color: <?php echo $args['bg_pattern']; ?>">Buy Now</a></div>
    </div>
    <?php if ($args['description']) { ?>
      <div class="wc-block-grid__product-info-description">
        <?php echo $args['description']; ?>
      </div>
    </div> <!-- if we have description, we closing this tag here -->
    <?php } ?>
  </li>
