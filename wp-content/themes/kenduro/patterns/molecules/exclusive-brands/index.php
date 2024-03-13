<?php
  $exclusive_brand_title = get_field('exclusive_brand_title', 'option');
  $exclusive_brand_description = get_field('exclusive_brand_description', 'option');
  $exclusive_brands_list = get_field('exclusive_brands_list', 'option');
?>
<div class="exclusive-brands">
  <div class="container">
    <div class="row">
      <div class="col">
        <?php if (isset($exclusive_brand_title)) : ?>
          <p class="paragraph paragraph-xl semibold">
            <?php echo $exclusive_brand_title; ?>
          </p>
        <?php endif; ?>
        <?php if (isset($exclusive_brand_description)) : ?>
          <p class="paragraph paragraph-m regular tetriary">
            <?php echo $exclusive_brand_description; ?>
          </p>
        <?php endif; ?>
        
        <?php if( $exclusive_brands_list ): ?>
          <ul class="brands__list">
            <?php foreach( $exclusive_brands_list as $brand ): 
              $term_id = $brand->term_id;
              $term_link = get_term_link($brand);
              $meta_fields = get_term_meta($term_id);
              $term_logo_id = $meta_fields['exclusive_logo'][0];
              $term_logo = wp_get_attachment_url($term_logo_id);
            ?>
              <li class="brands__list-item">
                <a href="<?php echo esc_attr($term_link); ?>" class="brands__list-item-link" target="_blank">
                  <img src="<?php echo esc_attr($term_logo)?>" alt="<?php echo esc_attr($brand->slug); ?>"/>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>