<?php 
  $products = wc_get_products(array(
    'limit' => -1
  ));

  //get all prices from this category
  $all_prices = array();

  foreach ($products as $product) {
    if ($product->get_category_ids()[0] !== 48) { // Ако категорията е различна от Разни (id: 48);
      if ($product->is_type( 'variable' )) {
        $variations = $product->get_available_variations();
  
        foreach ( $variations as $key => $value ) {
          // pretty_dump($value);
          $all_prices[] = $value['display_price'];
        }
  
      } else {
        $all_prices[] = (float)$product->get_price();
      }
    }
  }

  //Get minimum & maximum value from the price array
  $min_price = min($all_prices);
  $max_price = max($all_prices);

  // pretty_dump($min_price);
  // pretty_dump($max_price);
  // pretty_dump($all_prices);
  
  $pretty_prices = implode( ", ", $all_prices );
  $unique_val = implode(", ",array_unique(explode(", ", $pretty_prices)));
  
  // pretty_dump($unique_val);
  
?>
<div class="filter-price">
  <div class="filter-type" data-filter-type="filter_price">Филтър по цена</div>
  <div 
    id="slider-range" 
    data-all-prices="<?php echo $unique_val; ?>" 
    data-min-price="<?php echo $min_price; ?>"
    data-max-price="<?php echo $max_price; ?>"
  ></div>
  <div class="filter-price__input-wrapper">
    <input type="text" id="amount-min" class="filter-price__input">
    <input type="text" id="amount-max" class="filter-price__input">
  </div>
</div>
