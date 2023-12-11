<?php

use Lean\Load;

$args = wp_parse_args($args);
$filters = array();
$url_attr = array();
// global $paged;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

foreach ($args as $key => $value) {
  $result = $value;
  if ($value === '') {
    continue;
  }

  if ($key === 'filter_cat') {
    $catArr = explode(',', $value);
    $filteredCatArr = array();

    for ($i = 0; $i < count($catArr); $i++) {
      if ($catArr[$i] !== '') {
        $filteredCatArr[] = $catArr[$i];
      }
    }

    if (count($filteredCatArr) === 0) {
      continue;
    }

    $result = implode(',', $filteredCatArr);
  }

  if ($key === 'filter_price') {
    $priceArr = explode('-', $value);
    $filteredPriceArr = array();

    for ($i = 0; $i < count($priceArr); $i++) {
      if ($priceArr[$i] !== '' && (count($filteredPriceArr) < 2)) {
        $filteredPriceArr[] = $priceArr[$i];
      }
    }

    if (count($filteredPriceArr) === 1) {
      // check if is number
      if (!is_numeric($filteredPriceArr[0])) {
        continue;
      }
    } else if (count($filteredPriceArr) === 2) {
      if (!is_numeric($filteredPriceArr[0]) || !is_numeric($filteredPriceArr[1])) {
        continue;
      }

      if ($filteredPriceArr[0] > $filteredPriceArr[1]) {
        continue;
      }
    } else {
      continue;
    }

    $result = implode('-', $filteredPriceArr);
  }

  $filters[$key] = $result;
}

$loop_args = [
  'post_type' => 'product',
  // 'posts_per_page' => -1,
  'posts_per_page' => 3,
  'paged' => $paged,
  'tax_query' => array(
    array(
      'taxonomy' => 'product_cat',
      'field'    => 'slug',
      'terms'    => array('various'),
      'operator' => 'NOT IN',
    )
  )
];
// pretty_dump(count($filters));

if (count($filters) > 0) {
  $url_attr = $filters;
  unset(
    $url_attr['filter_cat'],
    $url_attr['filter_price']
  );

  if (isset($filters['filter_cat'])) {
    $catFilterArray = array();
    $catArray = explode(',', $filters['filter_cat']);

    for ($i = 0; $i < count($catArray); $i++) {
      if ($catArray[$i] !== '') {
        $catFilterArray[] = $catArray[$i];
      }
    }

    $loop_args['tax_query'] = array(
      array(
        'taxonomy' => 'product_cat',
        'field'    => 'slug',
        'terms'    => $catFilterArray,
        'operator' => 'IN',
      )
    );
  }
}

$loop = new WP_Query($loop_args);
if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();

    global $product;

    $price = $product->get_price_html();
    $id = $product->get_id();
    $title = $product->get_title();
    $permalink = $product->get_permalink();
    $image = $product->get_image();

    $data = $product->get_data();
    $matchPriceNotVariableProduct = isset($filters['filter_price']) ? false : true;
    $matchAttrNotVariableProduct = $url_attr ? false : true;
    $priceArrayNotVariableProduct = isset($filters['filter_price']) ? explode('-', $filters['filter_price']) : null;
    $attr = $data['attributes'];
    $attrMockup = array();

    foreach ($attr as $attrKey => $attrValue) {
      $attributes = wc_get_product_terms($id, $attrKey, array('fields' => 'slugs'));
      $filter_key = str_replace('pa_', 'filter_', $attrKey);
      $attrMockup[$filter_key] = '';
      foreach ($attributes as $attributesKey => $attributesValue) {
        $recievedValue = str_replace(' ', '-', mb_strtolower($attributesValue));
        $attrMockup[$filter_key] = urlencode($recievedValue);
        if (isset($filters[$filter_key])) {
          $explodeValue = explode(',', str_replace(', ', ',', $filters[$filter_key]));
          if ($filters[$filter_key] && in_array($recievedValue, $explodeValue)) {
            $matchAttrNotVariableProduct = true;
          }
        }
      }
    }

    if ($filters) {
      $product_price = floatval((string)$data['price']);

      if ($priceArrayNotVariableProduct === null) {
        $matchPriceNotVariableProduct = true;
      } else {
        if ($priceArrayNotVariableProduct[1] === null) {
          $matchPriceNotVariableProduct = $product_price >= $priceArrayNotVariableProduct[0];
        } else {
          $matchPriceNotVariableProduct = ($product_price >= $priceArrayNotVariableProduct[0] && $product_price <= $priceArrayNotVariableProduct[1]);
        }
      }
    }
    // foreach ($filters['filter_cat'] as $cat) {
    //   pretty_dump($cat);
    // }

    $haveMatch = $matchAttrNotVariableProduct && $matchPriceNotVariableProduct;
    if ($haveMatch) {
      Load::molecules('shop/product', [
        'permalink'      => $permalink,
        'image_url'      => $product->get_image('shop-feature', array('class' => 'wc-block-grid__product-image')),
        'price'          => $price,
        'attr'           => $attrMockup,
        'id'             => $id,
        'title'          => $title
      ]);
    }

  endwhile;

  // $total_pages = $loop->max_num_pages;

  // if ($total_pages > 1) {

  //   $current_page = max(1, get_query_var('paged'));

  //   echo paginate_links(array(
  //     'base' => get_pagenum_link(1) . '%_%',
  //     'format' => 'page/%#%',
  //     'current' => $paged,
  //     'total' => $total_pages,
  //     'prev_text'    => __('« prev'),
  //     'next_text'    => __('next »'),
  //   ));
  // }

  custom_pagination( $loop->max_num_pages, "", $paged );  


endif;
wp_reset_postdata();

  // pretty_dump($loop);