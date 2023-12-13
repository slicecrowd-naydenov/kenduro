<?php

use Lean\Load;
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');
/* Template Name: Home*/

get_header();
// $arrow_down = file_get_contents(ICON_PATH . '/arrow_down.svg');
// pretty_dump(json_encode(body));
// $cart_items = WC()->cart->get_cart();

// $product_ids = [];

// // pretty_dump($cart_items);
// foreach ($cart_items as $cart_item_key => $cart_item) {
//   $product = $cart_item['data'];
//   $field_id = array();
//   $meta_fields = get_field("meta_data", $cart_item['product_id']);
//   if ($product->is_type('variation')) {
//     $variation_id = $product->get_id();
//     $field_id = get_post_meta($variation_id, '_my_product_variation_id', true);
//   } else {
//     foreach ($meta_fields as $meta_field) {
//       if ($meta_field['key'] === 'product_variation_id') {
//         $array = json_decode($meta_field['value'], true);
//         $string_without_brackets = implode('', $array);
//         $field_id = $string_without_brackets;
//       }
//     }



// foreach ($asdf as $key => $h) {
//   if ($key != 0) {
//     unset($asdf[$key]);
//     pretty_dump($h['handle']);
//   } else {
//     pretty_dump($h['handle']);
//   }
// }



// function custom_upload_image($image_url) {
//   // $media_id = media_sideload_image($image_url, 3365, 'desc', 'id');
//   $media_id = media_sideload_image($image_url, 0, 'Image title');

//   if (!is_wp_error($media_id)) {
//       return $media_id;
//   }

//   return false;
// }

// $ggg = custom_upload_image('https://sportal365images.com/process/smp-images-production/sportal.bg/07082022/1aa114ef-c221-45eb-af70-23a95c0b6281.jpeg?operations=crop(0:18:2048:1170),fit(968:545)&format=webp');

// set_post_thumbnail(3365, $ggg);

// custom_upload_image('https://sportal365images.com/process/smp-images-production/sportal.bg/29082023/eadbfc03-45b6-415c-980d-61f1f60d546d.jpg?operations=crop(0:0:711:400),fit(968:545)&format=webp');

// media_sideload_image('https://cdn.files.smartsuite.com/security=p:eyJjYWxsIjogWyJyZWFkIiwgImNvbnZlcnQiXSwgImV4cGlyeSI6IDE3MDA2NjA0OTguMTA1ODE5LCAiaGFuZGxlIjogImgzbEdHQWlSWHFxYXJUSW9QYzU3In0=,s:aba8b8e794863727090c82c7fc4acd29330cd97b83d9ce88135f946c90d1b2b0/h3lGGAiRXqqarTIoPc57', 0, 'Image titleeee', 'src');

// $id = 'h3lGGAiRXqqarTIoPc57';


// $finalUrl = 'https://cdn.files.smartsuite.com/AEHrSDUikTDqTbYuRTesYz/resize=height:947,width:1920,fit:max/security=policy:eyJjYWxsIjogWyJyZWFkIiwgImNvbnZlcnQiLCAicGljayIsICJzdG9yZSJdLCAiZXhwaXJ5IjogMTcwMDczOTU5Mi45NjQyNTZ9,signature:b22fd4217467edd4f8cf09aaa996dc1b8010110eb84f94d70bdb4d2a9a0d065c/gTJJQKGsQxa7kMAAj1jm';
// $tmp = download_url( $finalUrl );

// $file_array = array(
//   'name' => basename( $finalUrl ).'.png',
//   'tmp_name' => $tmp
// );
// $imageId = media_handle_sideload($file_array, 0);

// pretty_dump($imageId);



// echo getFileURL('OgIUZG22Q6eE0i5BscNi');
// $url = getFileURL('gTJJQKGsQxa7kMAAj1jm');
// $tmp = download_url( $url );

// $file_array = array(
//   'name' => basename( $url ).'.png',
//   'tmp_name' => $tmp
// );
// $imageId = media_handle_sideload($file_array, 0);


// pretty_dump(getFileURL('h3lGGAiRXqqarTIoPc57'));





// global $product_variations;
// $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);
//   $set_regular_price = get_column_field_id('set_regular_price', $product_variations_fields);

// $product_variations_fields = fetch_column_fields($ss_ids['product_variations']);
// pretty_dump($product_variations_fields);
// $me = wp_get_current_user();
// $user = get_user_by('id', 2);
// // pretty_dump($me);
// // pretty_dump($user);



// // $user = wp_get_current_user();
// if ( in_array( 'administrator', (array) $me->roles ) ) {
//   pretty_dump('is admin');
//   //The user has the "author" role
// } else {
//   pretty_dump('is not admin');

// }

// pretty_dump(current_user_can( 'administrator' ));
// $current_user = wp_get_current_user();
// // pretty_dump($current_user);
// if (!$current_user || !is_user_logged_in() || !in_array('administrator', (array) $current_user->roles)) {
//   pretty_dump('NOT ADMIN');
// } else {
//   pretty_dump('ADMIN');

// }

// pretty_dump(get_post(3073));
// pretty_dump(get_field('testtt', 2933));

//   }
// }

// $body = array(
//   'appId' => '653b9adc14af2fdba838b57d',
//   'body' => array(
//     "s54c900dfc" => array(
//       "654a14bf4844ad473dab7951",
//       "654a14bf4844ad473dab7953",
//       "654a14bfc2bbd6580d02e1e7"
//     ),
//   )
// );

// $asd = fetch_column_fields('64fffa372bef62e52b350219');
// $product_id_slug = get_column_field_id('wp_order_id', $asd);
// $sales_records = get_external_api_response('64fffa372bef62e52b350219', null);

// pretty_dump($sales_records);
// global $ss_ids;
// $product_variations_fields = post_column_fields('651f9c5af5b14e0d99b3e73c');  
// pretty_dump($product_variations_fields);

if( ini_get('allow_url_fopen') ) {
    die('allow_url_fopen is enabled. file_get_contents should work well');
} else {
    die('allow_url_fopen is disabled. file_get_contents would not work');
}


?>
<main>
  <?php Load::organisms('homepage/index'); ?>

  <div class="container">
    <div class="row">
      <div class="col">
        <div class="popular-categories">
          <div class="popular-categories__header">
            <p class="paragraph paragraph-xl semibold primary">Popular Categories</p>
            <a href="#" class="paragraph paragraph-m semibold primary">
              Browse All Products
              <?php // echo $arrow_down; ?>
            </a>
          </div>
          <hr>
          <?php
          echo do_shortcode('[product_categories ids="1874, 1878" columns="5"]');
          ?>
        </div>
        <?php
        Load::molecules('product-category/product-categories-filter/index');
        echo do_shortcode("[products]");

        Load::molecules('product-category/product-category-info/index', [
          'title' => 'Join our Community',
          'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam sit amet nulla eu lacus pellentesque sodales in ut felis. Morbi consectetur rhoncus leo, quis efficitur sem sodales efficitur.',
          'cta_text' => 'Join Community'
        ]);
        ?>


        <a href="#" id="createProducts">create Products</a>
        </br>
        <!-- <a href="#" id="updateProduct">update Product</a> -->
        <!-- </br> -->
        <!-- <a href="#" id="updateProductVariation">update Variation Product</a> -->
        <!-- </br> -->
        <a href="#" id="createCategories">create Categories</a>
        </br>
        <a href="#" id="productFields">Product fields</a>
        </br>
        <a href="#" id="filterFields">Filter fields</a>
        </br>
        <a href="#" id="filterValues">Filter values</a>
        </br>
        <a href="#" id="createFilters">create Filters</a>
        </br>
      </div>
    </div>
  </div>
</main>
<?php
get_footer();
