<?php
use Lean\Load;
$page_name = strtolower(get_the_title());
$is_set_bike_compatibility = check_is_set_bike_compatibility();

$filterCompability = '';
if ($is_set_bike_compatibility !== '') {
  $filterCompability = $_COOKIE['brand'] . ' ' . $_COOKIE['model'] . ' ' . $_COOKIE['year'];
  $filterButtonClass = 'has-set-bike';
} else {
  $filterButtonClass = 'not-set-bike';
}

?>
<div id="top-section">
  <div class="container">
    <div class="row">
      <div class="col">
        <p class="paragraph paragraph-m semibold">
          Обадете ни се на 0886 230 023 или ни <a href="mailto:sales@kenduro.com" class="chat-link">пишете</a>
        </p>
      </div>
      <div class="col-auto">
        <div class="header-btns-wrapper">
          <div class="bike-compatibility-button <?php esc_attr_e($filterButtonClass); ?>">
            <div class="bike-icon"><?php Load::atom('svg', ['name' => 'bike']); ?></div>
            <?php if ($is_set_bike_compatibility !== '') { ?>
              <a href="" class="show-bike-compatibility button button-primary-orange paragraph-m">Покажи продуктите за: <?php echo strtoupper(remove_hyphen_after_first_and_before_last_word($filterCompability)); ?>
                <?php Load::atom('svg', ['name' => 'arrow_orange']); ?>
              </a>
              <span class="edit-bike-model" data-toggle="modal" data-target="#compatibilityModal" data-url="my-bike"><?php Load::atom('svg', ['name' => 'edit', 'class' => 'edit-bike']); ?></span>
            <?php } else { ?>
              <span>Покажи всички продукти за :</span>
              <!-- Button trigger modal -->
              <button type="button" class="button button-primary-orange paragraph-m" data-toggle="modal" data-target="#compatibilityModal" data-url="my-bike">
                <?php 
                  Load::atom('svg', ['name' => 'plus']); 
                  echo 'Добави мотора си';
                ?>
              </button>
            <?php } ?>
          </div>
          <?php
          if ($page_name !== 'cart') {
            Load::molecules('woo-header-cart-button/index');
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>