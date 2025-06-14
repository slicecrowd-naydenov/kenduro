<?php
  use Lean\Load;

  $args = wp_parse_args($args, [
    'title' => null,
    'class' => '',
    'description' => null,
    'cat'   => null,
    'cat_img_inner'   => null,
    'cta_text'   => null,
    'cta_link'   => '#',
  ]);

  $bg_image = isset($args['cat_img_inner']) ? 'background-image: url('.$args['cat_img_inner'].')' : '';
?>
<div class="product-category-info <?php echo $args['class']; ?>" style="<?php echo esc_attr($bg_image);?>">
  <?php Load::atom('svg', ['name' => 'k-logo']); ?>
  <img src="<?php echo IMAGES_PATH; ?>/teo-kabakchiev-bg.png" alt="teo kabakchiev" class="teo-bg" />
  <img src="<?php echo IMAGES_PATH; ?>/riders.png" alt="riders" class="riders-bg" />
  <div class="product-category-info__text">
    <h2 class="title h4">
      <?php
      if ($args['title']) :
        echo $args['title'];
      endif;
      if ($args['cat']) :
      ?>
        <strong><?php echo $args['cat']; ?> </strong>
      <?php endif; ?>
    </h2>
    <?php if ($args['description']) : ?>
      <p class="paragraph paragraph-l">
        <?php echo $args['description']; ?>
      </p>
    <?php endif; ?>
    <?php if ($args['cta_text']) : ?>
      <a href="<?php echo $args['cta_link'];?>" class="button button-secondary-blue paragraph paragraph-l semibold">
        <?php echo $args['cta_text'];?>
      </a>
    <?php endif; ?>
  </div>
</div>