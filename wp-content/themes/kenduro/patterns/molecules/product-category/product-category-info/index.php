<?php
$args = wp_parse_args($args, [
  'title' => null,
  'description' => null,
  'cat'   => null,
  'cta_text'   => null,
  'cta_link'   => '#',
]);
?>
<div class="product-category-info">
  <div class="product-category-info__text">
    <p class="paragraph paragraph-l">
      <?php
      if ($args['title']) :
        echo $args['title'];
      endif;

      if ($args['cat']) :
        echo $args['cat'];
      endif;
      ?>
    </p>
    <?php if ($args['description']) : ?>
      <p class="paragraph paragraph-m text-center tetriary">
        <?php echo $args['description']; ?>
      </p>
    <?php endif; ?>
  </div>
  <?php if ($args['cta_text']) : ?>
    <a href="<?php echo $args['cta_link'];?>" class="button button-secondary paragraph paragraph-m semibold">
      <?php echo $args['cta_text'];?>
    </a>
  <?php endif; ?>
</div>