<?php
/* Template Name: Bike compatibility */
use Lean\Load;


$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

// Парсирай URL-то
$url_parts = parse_url($current_url);
$query_params = [];
if (isset($url_parts['query'])) {
  parse_str($url_parts['query'], $query_params); // Разделя query string на масив
}

// Проверка дали "on-sale" съществува
if (array_key_exists('on-sale', $query_params)) {
  // Премахваме "on-sale", ако съществува
  unset($query_params['on-sale']);
} else {
  // Добавяме "on-sale", ако не съществува
  $query_params['on-sale'] = '';
}

// Генерираме новия query string
$new_query = http_build_query($query_params);

// Сглобяваме новия URL
$new_url = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'];
if (!empty($new_query)) {
  $new_url .= '?' . $new_query;
}

$on_sale = isset($_GET['on-sale']);
$promo_checked = '';

// if we are in on-sale page
if ($on_sale) {
  $promo_checked = 'checked';
  // $promo_link = esc_url(home_url( $wp->request ));
	$wccs_products = new WCCS_Products();
  $promo_products = $wccs_products->get_discounted_products();
	$promo_products_ids = implode(',', array_map('intval', $promo_products));
} else {
	$promo_products_ids = '';
}


get_header();

// $on_sale = isset($_GET['on-sale']);
// $promo_checked = '';
// $promo_link = esc_url(home_url( $wp->request ).'?on-sale');

// if ($on_sale) {
//   $promo_checked = 'checked';
//   $promo_link = esc_url(home_url( $wp->request ));
// 	$wccs_products = new WCCS_Products();
//   $promo_products = $wccs_products->get_discounted_products();
// 	$ids_placeholder = implode(',', array_map('intval', $promo_products));
// } else {
// 	$ids_placeholder = '';
// }
$is_set_bike_compatibility = check_is_set_bike_compatibility();
$bikeCompatibility = '';
$get_product_cat = isset($_GET['wpf_filter_cat_1']) ? $_GET['wpf_filter_cat_1'] : '';

$current_cat = get_term_by('id', $get_product_cat, 'product_cat');
$parent_IDS = array();

if ($current_cat) {
	$parent_IDS[] = $current_cat->term_id;
	$parent_cat = $current_cat->parent !== 0 ? get_term_by('id', $current_cat->parent, 'product_cat') : null;

	while ($parent_cat !== null) {
		$parent_IDS[] = $parent_cat->term_id;
		$parent_cat = $parent_cat->parent !== 0 ? get_term_by('id', $parent_cat->parent, 'product_cat') : null;
	}
}

$cat_ids = [];
if ($is_set_bike_compatibility !== '') {
  $filter_value = sanitize_text_field($is_set_bike_compatibility);
	$bikeCompatibility = $_COOKIE['brand'] . ' ' . $_COOKIE['model'] . ' ' . $_COOKIE['year'];
  $slugs = explode('|', strtolower($filter_value));

  $args = [
    'post_type'      => 'product',
    'posts_per_page' => -1, // Взимаме всички продукти
    'fields'         => 'ids', // Само ID-та
    'tax_query'      => array(
      array(
        'taxonomy'   => 'pa_compability',
        'field'      => 'slug',
        'terms'      => $slugs,
        'operator'   => 'IN', 
      )
    ),
  ];

  $query = new WP_Query($args);

  if ($query->have_posts()) {
    $product_ids = $query->posts; // ID-тата на продуктите
    // $categories = [];
    foreach ($product_ids as $product_id) {
      // $product_cats = wp_get_post_terms($product_id, 'product_cat', ['fields' => 'names']);
      $product_cat_ids = wp_get_post_terms($product_id, 'product_cat', ['fields' => 'ids']);
      $cat_ids = array_merge($cat_ids, $product_cat_ids); // Обединяваме всички ID-та
      // $categories[$product_id] = $product_cats;
    }
    $cat_ids = array_unique($cat_ids);

    $terms_args = array(
      'taxonomy'     => 'product_cat',
      'hide_empty'   => 1,
      'hierarchical' => 1,
      'include'      => $cat_ids,
      'parent'			 => 0
    );
    
    // Извличане на термините
    $taxonomies = get_terms($terms_args);
  }

  wp_reset_postdata();
}





$list_categories = function($taxonomies, $temp_arr) use ($parent_IDS, &$list_categories, $is_set_bike_compatibility, $cat_ids) {
	if ( !empty( $taxonomies ) || $taxonomies !== null ) {
		$cat_html = '<p class="paragraph paragraph-xl semibold cat-head active-cat">Основни Категории</p><ul class="product-cat-filter">';
		$added_all = false;
		foreach ($taxonomies as $tax) {
			$term_link = esc_url(get_site_url());
			$active_class = '';
			$product_args = array(
				'post_type' => 'product',
				'posts_per_page' => 1,
				'tax_query' => array(
					'relation' => 'AND',
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => $tax->slug,
						'operator' => 'IN',
					)
				),
			);

			$see_all_cat_link = esc_url(get_site_url());
			
      $term_link = esc_url(get_site_url().'/my-bike?wpf_filter_compability='.$is_set_bike_compatibility.'&wpf_filter_cat_1='.$tax->term_id);
      $see_all_cat_link = esc_url(get_site_url().'/my-bike?wpf_filter_compability='.$is_set_bike_compatibility);


			if (!$added_all) {
				$cat_html .= '<li class="all-cats"><a href="'.$see_all_cat_link.'" class="paragraph paragraph-l">Всички</a></li>';
				$added_all = true;
			}
		
			$q = new WP_Query( $product_args );
		
			if ($q->post_count > 0) {
				if (in_array($tax->term_id, $cat_ids)) {
          if (in_array($tax->term_id, $parent_IDS)) {
            $next_category = $tax->term_id;
            // $tax_name = '<b class="active">'.$tax->name.'</b>';
            $active_class = 'active';
          } else {
            // $tax_name = $tax->name;
            $active_class = '';
          }
          $cat_html .= '<li class="'.$active_class.'"><a href="'.$term_link.'" class="paragraph paragraph-l">'.$tax->name.'</a></li>';
        }
			}
			wp_reset_postdata();
		}
		$cat_html .= '</ul>';
		$temp_arr[] = $cat_html;
		if (isset($next_category)) {

			$terms_args = array(
				'taxonomy'     => 'product_cat',
				'hide_empty'   => 1,
				'hierarchical' => 1,
				'parent'			 => $next_category
			);
			
			$taxonomies = get_terms( $terms_args );

			$list_categories($taxonomies, $temp_arr);
		} else {
			echo implode('', $temp_arr);
		}
	}
};
// pretty_dump($get_product_cat);
?>

<div class="brands" id="primary">
  <div class="container">
    <div class="row">
      <div class="col">
        <h4 class="page-title semibold">
          Всички продукти за 
          <div class="button button-primary-grey paragraph semibold edit-selected-bike" data-toggle="modal" data-target="#compatibilityModal" data-url="my-bike">
            <?php 
              echo strtoupper(remove_hyphen_after_first_and_before_last_word($bikeCompatibility));
              Load::atom('svg', ['name' => 'edit_icon']); 
            ?>
          </div> 
        </h4>
        <h1 class="hidden-h1">Всички продукти за</h1>

        <div class="filter-content-wrapper">
          <div class="products-wrapper">
            <div class="dropdown sort-by-dropdown">
              <button class="btn btn-secondary dropdown-toggle sort-by" type="button" id="dropdownSortMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Сортирай по:
                <strong class="sort-by-title">Подразбиране</strong>
              </button>

              <label class="checkbox promo-products-filter">
                <input type="checkbox" <?php echo esc_attr($promo_checked); ?>>
                <span class="optional"></span> 
                <a href="<?php echo esc_url($new_url); ?>">Промо продукти</a>
              </label>

              <div class="dropdown-menu dropdown-menu-sort" aria-labelledby="dropdownSortMenuButton">
                <?php echo do_shortcode('[wpf-filters id=4]'); ?>
              </div>
            </div>
            <?php
              echo do_shortcode('[products limit="16" columns="4" paginate="true" ids="'.$promo_products_ids.'"]');
            ?>
          </div>

          <?php  if (wp_is_mobile()) { ?>
					<div class="mobile-wrapper filter-sidebar">
						<div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Категории
              </button>
              <ul class="nav nav-pills product-categories-view dropdown-menu" role="tablist" aria-labelledby="dropdownMenuButton">
                <?php 
                  if ($taxonomies !== null) {
                    $list_categories($taxonomies, array());
                  }
                ?>
              </ul>
						</div>

							<?php
							output_filter_modal($get_product_cat, $promo_checked, $new_url);
						?>
					</div>

					<?php } else { ?>

					<div class="filter-sidebar">
						<?php
              if ($taxonomies !== null) {
                $list_categories($taxonomies, array());
              }
						?>
						<p class="paragraph paragraph-xl semibold cat-head active-cat filters">Филтри</p>
						<?php echo do_shortcode('[wpf-filters id=2]'); ?>	
					</div>
					<?php
					}

				?>

        </div>

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

</div>


<?php
get_footer();