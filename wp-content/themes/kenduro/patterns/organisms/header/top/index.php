<?php
use Lean\Load;
$page_name = strtolower(get_the_title());
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
          <div class="bike-compatibility-button">
            <div class="bike-icon"><?php Load::atom('svg', ['name' => 'bike']); ?></div>
            <span>Покажи само продукти за :</span>
            <!-- Button trigger modal -->
            <button type="button" class="button button-primary-orange paragraph-m" data-toggle="modal" data-target="#compatibilityModal">
              <?php Load::atom('svg', ['name' => 'plus']); ?>
              Добави мотора си
            </button>
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