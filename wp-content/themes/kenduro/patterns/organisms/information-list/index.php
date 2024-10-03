<?php

use Lean\Load;

$args = wp_parse_args($args);
$class = isset($args['class']) ? $args['class'] : '';
?>

<div class="information-list-section <?php echo esc_attr($class); ?>">
  <?php if ($class === 'with-border') : ?>
    <div class="container">
      <div class="row">
        <div class="col">
        <?php endif; ?>
        <ul class="information-list">
          <?php foreach ($args['list'] as $arg) : ?>
            <li class="information-list__item">
              <?php Load::atom('svg', ['name' => $arg['icon']]); ?>
              <p class="paragraph tetriary text"><?php echo $arg['text']; ?></p>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php if ($class === 'with-border') : ?>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>