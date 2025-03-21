<?php

use Lean\Load;
/* Template Name: Home*/

get_header();

?>
<main id="primary">
  <h1 class="hidden-h1">Kenduro</h1>
  <?php 
    Load::organisms('homepage/hero-section/index');
    Load::organisms('information-list/index', [
      'class' => 'with-border',
      'list'  => [
        [
          'icon' => 'star', 
          'text' => 'Уникални продукти',
          'description' => 'Екипировка, която няма да намериш никъде другаде !'
        ],
        [
          'icon' => 'customer-support', 
          'text' => 'Лично отношение',
          'description' => 'Най-доброто обслужване на клиенти от всичките ни конкуренти, винаги може да разчиташ на нас !'
        ],
        [
          'icon' => 'return-policy', 
          'text' => '14-дневна политика за връщане',
          'description' => 'Не се притеснявай ако не си сигурен кой размер ти трябва. Поръчай ги всичките :)'
        ],
        [
          'icon' => 'payment', 
          'text' => 'Плащане при доставка',
          'description' => 'Първо провери дали ти харесва и чак тогава го плати ! Ние сме тук да създаваме приятели, а не клиенти.'
        ],
      ]
    ]);
    Load::organisms('homepage/popular-cats/index'); 
    Load::organisms('homepage/category-pills/index');
    Load::organisms('homepage/exclusive-partners/index');
    ?>
    <div class="container">
      <div class="row">
        <div class="col">
          <?php
            Load::molecules('product-category/product-category-info/index', [
              'title' => '<span class="highlighted">K</span>enduro е изработен от Teo',
              'class' => 'full-width-container',
              'description' => 'Тео Кабакчиев, световноизвестен хард ендуро състезател, ръководи Kenduro.com с непоколебима страст, гарантирайки нашия непоколебим ангажимент към услуги и качество от най-високо ниво.'
            ]);

            // echo do_shortcode('[products limit="12" columns="5" best_selling="true"]');
          ?>
        </div>
      </div>
    </div>
    
    <?php 
      Load::molecules('exclusive-brands/index');
      // Load::molecules('best-selling-products/index'); 
      ?>
      <div class="container">
        <div class="row">
          <div class="col">
            <?php echo do_shortcode('[recently_viewed_products]'); ?>
          </div>
        </div>
      </div>
</main>
<?php
get_footer();
