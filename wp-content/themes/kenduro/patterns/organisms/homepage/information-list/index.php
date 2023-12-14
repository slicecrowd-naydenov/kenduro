<?php 
  use Lean\Load; 

  $infoArray = [
    ['icon' => 'star', 'text' => 'Unique Products'],
    ['icon' => 'customer-support', 'text' => 'Immediate Customer Support'],
    ['icon' => 'return-policy', 'text' => '14-day Return Policy'],
    ['icon' => 'payment', 'text' => 'Pay on Delivery'],
  ];
?>

<div class="information-list-section">
  <div class="container">
    <div class="row">
      <div class="col">
        <ul class="information-list">
          <?php foreach ($infoArray as $info) : ?>
          <li class="information-list__item">
            <?php Load::atom('svg', ['name' => $info['icon']]); ?>
            <p class="paragraph paragraph-l semibold tetriary"><?php echo $info['text']; ?></p>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>