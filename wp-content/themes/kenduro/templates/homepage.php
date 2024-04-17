<?php

use Lean\Load;
/* Template Name: Home*/

get_header();
$product = wc_get_product(8608);
$woo_updated_product_date = $product->get_data()['date_modified'];
$woo_timestamp = $woo_updated_product_date->getTimestamp();

$timestamp = strtotime('2024-03-19T11:27:12.743000Z');
$ss_updated_product_date = new WC_DateTime(date('Y-m-d H:i:s', $timestamp), new DateTimeZone('UTC'));
$ss_timestamp = $ss_updated_product_date->getTimestamp();


pretty_dump($woo_updated_product_date);
pretty_dump($ss_updated_product_date);
?>
<main id="primary">
  <?php 
    Load::organisms('homepage/hero-section/index');
    Load::organisms('information-list/index', [
      'class' => 'with-border',
      'list'  => [
        ['icon' => 'star', 'text' => 'Уникални продукти'],
        ['icon' => 'customer-support', 'text' => 'Незабавна поддръжка на клиенти'],
        ['icon' => 'return-policy', 'text' => '14-дневна политика за връщане'],
        ['icon' => 'payment', 'text' => 'Плащане при доставка'],
      ]
    ]);
    Load::organisms('homepage/popular-cats/index'); 
    Load::organisms('homepage/category-pills/index');
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
</main>
<?php
get_footer();
