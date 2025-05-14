<?php 
$args = wp_parse_args($args, [
  'list' => 16,
  'class' => 'column-4'
]);

$itemNumbers = $args['list'];
?>

<div id="skeleton" class="<?php echo esc_attr( $args['class'] ); ?>">
  <ul class="skeleton-list">
    <?php for ($i = 0; $i < $itemNumbers; $i++): ?>
      <li class="skeleton-list__item">
        <div class="skeleton skeleton-image"></div>
        <div class="skeleton skeleton-price"></div>
        <div class="skeleton skeleton-text"></div>
        <div class="skeleton skeleton-text"></div>
      </li>
    <?php endfor; ?>
  </ul>
</div>