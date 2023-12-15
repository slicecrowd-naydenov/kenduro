<?php
  use Lean\Load;

  $args = wp_parse_args($args, [
    'title' => null,
    'class' => '',
    'description' => null,
    'cat'   => null,
    'cta_text'   => null,
    'cta_link'   => '#',
  ]);
?>
<div class="product-category-info <?php echo $args['class']; ?>">
  <?php Load::atom('svg', ['name' => 'k-logo']); ?>
  <img src="<?php echo IMAGES_PATH; ?>/teo-kabakchiev.png" alt="teo-kabakchiev" class="teo-bg" />
  <div class="product-category-info__text">
    <h4 class="semibold title">
      <?php
      if ($args['title']) :
        echo $args['title'];
      endif;

      if ($args['cat']) :
        echo $args['cat'];
      endif;
      ?>
    </h4>
    <?php if ($args['description']) : ?>
      <p class="paragraph paragraph-l">
        <?php echo $args['description']; ?>
      </p>
    <?php endif; ?>
    <?php if ($args['cta_text']) : ?>
      <a href="<?php echo $args['cta_link'];?>" class="button button-secondary paragraph paragraph-l semibold">
        <?php echo $args['cta_text'];?>
      </a>
    <?php endif; ?>
  </div>
</div>