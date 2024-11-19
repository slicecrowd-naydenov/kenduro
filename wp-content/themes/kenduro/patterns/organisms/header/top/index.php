<?php
use Lean\Load;
$page_name = strtolower(get_the_title());
$isSetCompatibility = isset($_COOKIE['brand']) && isset($_COOKIE['model']) && isset($_COOKIE['year']);

$filterCompability = '';
if ($isSetCompatibility) {
  $filterCompability = $_COOKIE['brand'] . ' ' . $_COOKIE['model'] . ' ' . $_COOKIE['year'];
  $filterButtonClass = 'has-set-bike';
  $filterButtonText = 'Покажи продуктите за ';
  $filterButtonIconName = 'arrow_orange';
} else {
  $filterButtonClass = 'not-set-bike';
  $filterButtonText = 'Добави мотора си';
  $filterButtonIconName = 'plus';
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
            <?php if (!$isSetCompatibility) : ?>
            <span>Покажи само продукти за :</span>
            <?php endif; ?>
            <!-- Button trigger modal -->
            <button type="button" class="button button-primary-orange paragraph-m" data-toggle="modal" data-target="#compatibilityModal">
              <?php 
                Load::atom('svg', ['name' => $filterButtonIconName]); 
                echo $filterButtonText;
                if ($filterCompability !== '') {
                  echo strtoupper(remove_hyphen_after_first_and_before_last_word($filterCompability));
                }
              ?>
            </button>
            <?php 
              if ($isSetCompatibility) : 
                Load::atom('svg', ['name' => 'edit', 'class' => 'edit-bike']); 
              endif; 
            ?>
          </div>
          <!-- <p class="paragraph paragraph-m semibold">Some menu goes here</p>
          <p class="paragraph paragraph-m semibold lang-bar">Language bar</p> -->
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