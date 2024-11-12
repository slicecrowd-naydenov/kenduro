<?php
/* Template Name: On sale filter */
use Lean\Load;

get_header();
?>

<?php
global $wpdb;
$wccs_products = new WCCS_Products();

$parent_IDS = array();
// $promo_products = get_option('wdr_on_sale_list')['list']; // Discounted products provided from Discount rules pugin
// $promo_products = $promo_products = array(9374 , 9372 , 9370 );
$promo_products = $wccs_products->get_discounted_products();
$selected_category_id = isset($_GET['category']) ? intval($_GET['category']) : 0;
$current_cat = $selected_category_id ? get_term_by('ID', $selected_category_id, 'product_cat') : null;
$current_cat_ID =  null;

if ( !empty($promo_products) ) {
  
  // Преобразуване на ID-та в низ за SQL заявката
  $ids_placeholder = implode(',', array_map('intval', $promo_products));

  // SQL заявка за извличане на категориите на продуктите
  $query = "
    SELECT DISTINCT t.term_id, t.name, tt.parent
    FROM {$wpdb->prefix}term_taxonomy tt
    INNER JOIN {$wpdb->prefix}terms t ON t.term_id = tt.term_id
    INNER JOIN {$wpdb->prefix}term_relationships tr ON tr.term_taxonomy_id = tt.term_taxonomy_id
    WHERE tt.taxonomy = 'product_cat' AND tr.object_id IN ($ids_placeholder)
  ";

  // Изпълнение на заявката
  $results = $wpdb->get_results( $query );

  // Инициализиране на масиви за категориите
  $categories = array();
  $main_categories = array();
  $main_categories_arr = array();
  $sub_categories_arr = array();
  // Създаване на асоциативни масиви за категориите
  foreach ( $results as $category ) {
    if ( $category->parent == 0 ) {
      // pretty_dump();
      $main_categories[$category->term_id] = $category->name;
      $main_categories_arr[] = get_term_by('ID', $category->term_id, 'product_cat');
    } elseif ( $category->parent > 0 && isset($main_categories[$category->parent]) ) {
      $sub_categories_arr[] = $category->term_id;
    } else {
      $sub_categories_arr[] = $category->term_id;
    }
  }
} else {
  // echo 'No product IDs provided.';
}



if ($current_cat) {
	$parent_IDS[] = $current_cat->term_id;
	$parent_cat = $current_cat->parent !== 0 ? get_term_by('id', $current_cat->parent, 'product_cat') : null;

	while ($parent_cat !== null) {
		$parent_IDS[] = $parent_cat->term_id;
		$parent_cat = $parent_cat->parent !== 0 ? get_term_by('id', $parent_cat->parent, 'product_cat') : null;
	}
}

if ($current_cat_ID !== null) {
	do {
		$parent_IDS[] = $current_cat_ID;
		$temp_cat = get_term_by('id', $current_cat_ID, 'product_cat');
		$current_cat_ID = null;
		if ($temp_cat) {	
			if ($temp_cat->parent === 0) {
				$current_cat_ID = $temp_cat->term_id;
			} else {
				$current_cat_ID = $temp_cat->parent;
			}
		} 

	} while ($current_cat_ID !== null);
}

$list_categories = function($taxonomies, $temp_arr) use ($parent_IDS, &$list_categories, $sub_categories_arr) {
	if ( !empty( $taxonomies ) || !is_wp_error( $taxonomies ) ) {
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

      $term_link = esc_url('?category='.$tax->term_id);
      $see_all_cat_link = esc_url(get_site_url().'/promotions');
			

			if (!$added_all) {
				$cat_html .= '<li class="all-cats"><a href="'.$see_all_cat_link.'" class="paragraph paragraph-l">Всички</a></li>';
				$added_all = true;
			}
		
			$q = new WP_Query( $product_args );
		
			if ($q->post_count > 0) {
				
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
			wp_reset_postdata();
		}
		$cat_html .= '</ul>';
		$temp_arr[] = $cat_html;
		if (isset($next_category)) {

			$terms_args = array(
				'taxonomy'     => 'product_cat',
				'hide_empty'   => 1,
				'hierarchical' => 1,
				'parent'			 => $next_category,
        'include'      => $sub_categories_arr
			);
			
			$taxonomies = get_terms( $terms_args );

			$list_categories($taxonomies, $temp_arr);
		} else {
			echo implode('', $temp_arr);
		}
	}
};







// $promo_products = get_option('wdr_on_sale_list')['list'];   
$promo_product_ids = implode(',', $promo_products);
    // Масив с ID-та на продуктите
    // $product_ids = array(9374 , 9372);
    
  // Проверка дали има ID-та
  

  
  $selected_category_id = isset($_GET['category']) ? intval($_GET['category']) : 0;
  
  if ( $selected_category_id ) {
  
    // Преобразуване на ID-та в низ за SQL заявката
    $ids_placeholder = implode(',', array_map('intval', $promo_products));
  
    // SQL заявка за извличане на ID-та на продуктите в избраната категория
    $query = "
        SELECT DISTINCT tr.object_id
        FROM {$wpdb->prefix}term_relationships tr
        INNER JOIN {$wpdb->prefix}term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        WHERE tt.taxonomy = 'product_cat' AND tt.term_id = $selected_category_id AND tr.object_id IN ($ids_placeholder)
    ";
  
    // Изпълнение на заявката
    $filtered_product_ids = $wpdb->get_col( $query );
  
    // Ако има резултати, актуализиране на масива с ID-та
    if ( !empty($filtered_product_ids) ) {
      $promo_products = $filtered_product_ids;
      $promo_product_ids = implode(',', $promo_products);

    } else {
        echo 'No products found in the selected category.';
    }
  }



?>

<div class="on-sale" id="primary">
  <div class="container">
    <div class="row">
      <div class="col">
        <h3>Промоции</h3>
        <?php
          Load::molecules('product-category/product-category-info/index', [
            'title' => 'Black Friday KENDURO намаления за Ноември',
            'class' => 'discount-container',
            // 'description' => 'Разгледайте детайлно нашите намалени продукти.',
            // 'cat' => 'намалени продукти',
            // 'cat_img_inner' => $cat_inner_image_url
          ]);
        ?>
				<div class="filter-content-wrapper">
          <div class="products-wrapper">
            <div class="dropdown sort-by-dropdown">
              <button class="btn btn-secondary dropdown-toggle sort-by" type="button" id="dropdownSortMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Сортирай по:
                <strong class="sort-by-title">Подразбиране</strong>
              </button>
              <div class="dropdown-menu dropdown-menu-sort" aria-labelledby="dropdownSortMenuButton">
                <?php echo do_shortcode('[wpf-filters id=4]'); ?>
              </div>
            </div>
            <?php echo do_shortcode('[products ids="'.$promo_product_ids.'" limit="12" columns="4" paginate="true"]'); ?>
          </div> 
          <?php  if (wp_is_mobile()) { ?>
          <div class="mobile-wrapper filter-sidebar">
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Категории
              </button>
              <ul class="nav nav-pills product-categories-view dropdown-menu" role="tablist" aria-labelledby="dropdownMenuButton">
                <?php 
                $list_categories($main_categories_arr, array());
                ?>
              </ul>
            </div>

              <!-- // Load::molecules('product-category/product-categories-view/index'); 
              // output_filter_modal(); -->
            <!-- Button trigger modal -->
            <button type="button" class="button filter-modal" data-toggle="modal" data-target="#filterModal">
              Филтри
            </button>
        
            <!-- Modal -->
            <div class="modal fade mobile-modal" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Филтри</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <?php Load::atom('svg', ['name' => 'close']); ?>
                    </button>
                  </div>
                  <div class="modal-body">
                    <?php echo do_shortcode('[wpf-filters id=2]'); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php } else { ?>
          <div class="filter-sidebar">
            <?php $list_categories($main_categories_arr, array()); ?>
            <p class="paragraph paragraph-xl semibold cat-head active-cat filters">Филтри</p>
            <?php echo do_shortcode('[wpf-filters id=2]'); ?>

          </div> 
          
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();