<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

use Lean\Load;

defined( 'ABSPATH' ) || exit;

global $wp_query, $wp;
$on_sale = isset($_GET['on-sale']);
$is_set_bike_compatibility = check_is_set_bike_compatibility();
$bikeCompatibility = '';
$query_vars = $wp_query->query_vars;
$isSetCompatibility = isset($_COOKIE['brand']) && isset($_COOKIE['model']) && isset($_COOKIE['year']);
$excluded_categories = ['body-equipment', 'navigations', 'bikes']; // exclude categories where we are showing bike compatibility button

if ($is_set_bike_compatibility !== '') {
	$bikeCompatibility = $_COOKIE['brand'] . ' ' . $_COOKIE['model'] . ' ' . $_COOKIE['year'];
}

$get_brand = isset($query_vars['pa_brand']) ? $query_vars['pa_brand'] : null;
$get_product_cat = isset($query_vars['product_cat']) ? $query_vars['product_cat'] : null;
$product_cat_ID = 0;
$product_cat_slug = '';

$is_brand_page = $get_brand !== null ? 'brand_page' : 'cat_page';

if ($get_product_cat !== null) {
	$product_cat_slug = sanitize_title($get_product_cat);
	$cat = get_term_by('slug', $product_cat_slug, 'product_cat');
	$product_cat_ID = $cat->term_id;
}

$parent_IDS = array();
$current_cat = get_term_by('id', $product_cat_ID, 'product_cat');
$current_cat_ID =  null;

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

$promo_link = esc_url(home_url( $wp->request ).'?on-sale');
$promo_checked = '';

if ($on_sale) {

	$wccs_products = new WCCS_Products();
	$promo_products = $wccs_products->get_discounted_products();
	$ids_placeholder = implode(',', array_map('intval', $promo_products));

	// pretty_dump($current_cat);
	$products_args = array(
		'post_type'     => 'product', // we want to get products
		'post__in'  => $promo_products,
		'tax_query'     => array(
			array(
				'taxonomy' => 'product_cat', // the product taxonomy
				'field'    => 'term_id', // we want to use the term_id not slug
				'terms'    => $product_cat_ID, // here we enter the ID of the current term *this is where the magic happens*
			),
		),
	);

	$products_on_sale = new WP_Query( $products_args );
	$promo_link = esc_url(home_url( $wp->request ));
	$promo_checked = "checked";
} else {
	$ids_placeholder = '';
}

$terms_args = array(
	'taxonomy'     => 'product_cat',
	'hide_empty'   => 1,
	'hierarchical' => 1,
	'parent'			 => 0
);

$taxonomies = get_terms( $terms_args );

$list_categories = function($taxonomies, $temp_arr) use ($parent_IDS, $get_brand, &$list_categories, $get_product_cat) {
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

			$see_all_cat_link = esc_url(get_site_url());
			
			if ($get_brand === null) {
				$term_link = esc_url(get_site_url().'/product-category\/'.$tax->slug);
				$see_all_cat_link = esc_url(get_site_url().'/shop');
			} else {
				$term_link = esc_url(get_site_url().'/brand\/'.$get_brand.'/?product_cat='.$tax->slug);
				$see_all_cat_link = esc_url(get_site_url().'/brand\/'.$get_brand);
				$product_args['tax_query'][] = array(
					'taxonomy' => 'pa_brand',
					'field'    => 'slug',
					'terms'    => $get_brand,
					'operator' => 'IN',
				);
			}

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
				'parent'			 => $next_category
			);
			
			$taxonomies = get_terms( $terms_args );

			$list_categories($taxonomies, $temp_arr);
		} else {
			echo implode('', $temp_arr);
		}
	}
};

$classes = '';

if ( $get_brand !== null ) {
	$cur_term = get_term_by('slug', $get_brand, 'pa_brand');
	$term_id = $cur_term->term_id;
	$meta_fields = get_term_meta($term_id);
	$is_exclusive = isset($meta_fields['exclusive_brand']) && $meta_fields['exclusive_brand'][0];
	$term_logo_id = isset($meta_fields['exclusive_logo'][0]) ? $meta_fields['exclusive_logo'][0] : '';
	$term_banner_id = isset($meta_fields['exclusive_banner'][0]) ? $meta_fields['exclusive_banner'][0] : '';
	$brand_description = isset($meta_fields['brand_description'][0]) ? $meta_fields['brand_description'][0] : '';
	$term_logo = $term_logo_id != 0 ? wp_get_attachment_url($term_logo_id) : IMAGES_PATH.'/no-logo.jpg';
	$term_banner = wp_get_attachment_url($term_banner_id);
	$classes = $is_exclusive ? 'exclusive' : 'no-exclusive';
}

function get_product_ids_by_keyword( $keyword ) {
	global $wpdb;

	$query = $wpdb->prepare(
		"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'product' AND post_status = 'publish' AND post_title LIKE %s", '%' . $wpdb->esc_like( $keyword ) . '%'
	);

	$product_ids = $wpdb->get_col( $query );

	return $product_ids;  // Връщаме масив с ID-тата на продуктите
}

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10
 */
// do_action( 'woocommerce_shop_loop_header' );
?>
<div class="container">
	<div class="row">
		<div class="col">
			<?php
			if (is_product_category()) :
				if (category_has_parent() && $get_brand === null) :
					woocommerce_breadcrumb();
				endif;
			endif;

			if ( $get_brand !== null ) { ?>
				<div class="custom-breadcrumb">
					<a href="<?php echo esc_attr(get_site_url().'/brands')?>" class="paragraph paragraph-l">Производители</a>
					<span>/</span>
				</div>
			<?php } ?>
			<header>
				<?php 
				if (apply_filters('woocommerce_show_page_title', true)) : ?>
					<!-- .woocommerce-products-header__title -->
					<h1 class="page-title semibold h4 <?php echo esc_attr($classes); ?>">
						<?php 
							if ($get_brand !== null) {
								echo $cur_term->name;
							} else {
								woocommerce_page_title(); 
							}
						
						if ($get_brand !== null && $is_exclusive) : ?>
							<p class="paragraph paragraph-m regular exclusive-banner">
								<?php Load::atom('svg', ['name' => 'star-filled']); ?>
								Ексклузивен партньор
							</p>
						<?php endif; ?>
					</h1>
				<?php endif; ?>

				<?php
				/**
				 * Hook: woocommerce_archive_description.
				 *
				 * @hooked woocommerce_taxonomy_archive_description - 10
				 * @hooked woocommerce_product_archive_description - 10
				 */
				do_action('woocommerce_archive_description');
				?>
			</header>
			<?php
			$ancestors = get_ancestors(get_queried_object_id(), 'product_cat');

			if ($ancestors) {
				$outermost_parent_id = end($ancestors);
			} else {
				$outermost_parent_id = get_queried_object_id();
			}
			$cat_inner_image_url = get_field('inner_cat_thumbnail', 'product_cat_' . $outermost_parent_id);

			if ( $get_brand === null ) {
				if (is_product_category()) {
					Load::molecules('product-category/product-category-info/index', [
						'title' => '',
						'class' => 'full-container',
						'description' => 'Разгледайте наличните ни продукти и ако ви е необходимо нещо друго - обадете ни се !',
						'cat' => single_term_title('', false),
						'cat_img_inner' => $cat_inner_image_url
					]);
				} else {
					if (!is_search()) {
						Load::molecules('product-category/product-category-info/index', [
							'title' => 'Всички продукти',
							'class' => 'full-container',
							'description' => 'Разгледайте наличните ни продукти и ако ви е необходимо нещо друго - обадете ни се !',
							'cat' => single_term_title('', false),
							'cat_img_inner' => $cat_inner_image_url
						]);
					}
				}
			} else {
				// Brand Tax page
				$banner_srcset = wp_get_attachment_image_srcset($term_banner_id);
				$banner_sizes = wp_get_attachment_image_sizes($term_banner_id);
				$banner_metadata = wp_get_attachment_metadata($term_banner_id);
				$banner_width = isset($banner_metadata['width']) ? $banner_metadata['width'] : 0;
				$banner_height = isset($banner_metadata['height']) ? $banner_metadata['height'] : 0;

				
				$logo_metadata = wp_get_attachment_metadata($term_logo_id);
				$logo_width = isset($logo_metadata['width']) ? $logo_metadata['width'] : 'auto';
				$logo_height = isset($logo_metadata['height']) ? $logo_metadata['height'] : 'auto';
				?>

				<div class="brand-info <?php echo esc_attr($classes); ?>">
					<div class="brand-info__image">
						<div class="brand-info__logo">
							<img 
								src="<?php echo esc_attr($term_logo)?>" 
								width="<?php echo esc_attr($logo_width); ?>"
    						height="<?php echo esc_attr($logo_height); ?>" 
								alt="<?php echo esc_attr(strtolower(woocommerce_page_title() ?? '')); ?>" 
							/>
						</div>
						<?php 
						if ($term_banner) : ?>
						<img 
							src="<?php echo esc_attr($term_banner)?>" 
							alt="banner"
							srcset="<?php echo esc_attr($banner_srcset); ?>" 
    					sizes="
								(max-width: 456px) 500px,
								(max-width: 768px) 768px,
								(max-width: 1024px) 1024px,
								1400px"
							width="<?php echo esc_attr($banner_width); ?>"
    					height="<?php echo esc_attr($banner_height); ?>"
						/>
						<?php endif; ?>
					</div>
					<div>
						<div class="brand-info__description collapse paragraph paragraph-l" id="collapseSummary">
							<?php 
							echo $brand_description; ?>
						</div>
						<a class="collapsed paragraph paragraph-l" data-toggle="collapse" href="#collapseSummary" aria-expanded="false" aria-controls="collapseSummary"></a>
					</div>
				</div>
				<?php // Load::molecules('product-category/product-categories-view/index'); 


			}

			if ( woocommerce_product_loop() ) {

				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked woocommerce_output_all_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
				?>
					<div class="filter-content-wrapper <?php echo esc_attr($is_brand_page); ?>">
						<div class="products-wrapper">
							<div class="dropdown sort-by-dropdown">
								<button class="btn btn-secondary dropdown-toggle sort-by" type="button" id="dropdownSortMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Сортирай по:
									<strong class="sort-by-title">Подразбиране</strong>
								</button>
								<?php if ($get_product_cat !== null || $get_brand !== null) : ?>
									<label class="checkbox promo-products-filter">
										<input type="checkbox" <?php echo esc_attr($promo_checked); ?>>
										<span class="optional"></span> 
										<a href="<?php echo $promo_link; ?>">Промо продукти</a>
									</label>
								<?php endif; ?>
								<?php 
								if (
									$is_set_bike_compatibility !== '' &&
									!in_array($get_product_cat, $excluded_categories)
								) : 
									$URL = $_SERVER['REDIRECT_URL'] ?? $_SERVER['REQUEST_URI'] ?? '';
								?>
									<a href="<?php echo $URL .'?wpf_filter_compability='.$is_set_bike_compatibility; ?>" class="button button-primary-orange paragraph-m show-cat-bike-compatibility">
										<?php 
											echo 'Покажи продуктите за ';
											echo strtoupper(remove_hyphen_after_first_and_before_last_word($bikeCompatibility));
											Load::atom('svg', ['name' => 'arrow_orange']); 
										?>
									</a>
								<?php endif; 
								if (
									$is_set_bike_compatibility === '' &&
									!in_array($get_product_cat, $excluded_categories)
								) : ?>
									<button class="button button-primary-orange paragraph-m show-cat-bike-compatibility" data-toggle="modal" data-target="#compatibilityModal" data-url="product-cat">
										<?php 
											echo 'Филтрирай за мотор';
											Load::atom('svg', ['name' => 'arrow_orange']); 
										?>
									</button>
								<?php endif; ?>

								<div class="dropdown-menu dropdown-menu-sort" aria-labelledby="dropdownSortMenuButton">
									<?php echo do_shortcode('[wpf-filters id=4]'); ?>
								</div>
							</div>
							<?php
							// if ($on_sale) {
								// pretty_dump($products_on_sale);
								// $limitProducts = wp_is_mobile() ? 6 : 32;
								$limitProducts = 32;

								if (is_search()) {
									woocommerce_product_loop_start();

									if ( wc_get_loop_prop( 'total' ) ) {
										while ( have_posts() ) {
											the_post();
					
											/**
											 * Hook: woocommerce_shop_loop.
											 */
											do_action( 'woocommerce_shop_loop' );
					
											wc_get_template_part( 'content', 'product' );
										}
									}
					
									woocommerce_product_loop_end();
								} else {
									if ($get_brand) {
										$cur_cat_on_brand_page = isset($_GET['product_cat']) ? $_GET['product_cat'] : '';

										echo do_shortcode('[products attribute="brand" category="'.$cur_cat_on_brand_page.'" terms="'.$get_brand.'" limit="'.$limitProducts.'" columns="4" paginate="true"]');
									} else {

										$keyword_string = isset($_GET['ywcas_filter']) ? get_product_ids_by_keyword( sanitize_text_field($_GET['ywcas_filter']) ) : '';
										$ywcas_filter_ids = isset($_GET['ywcas_filter']) ? implode(',', array_map('intval', $keyword_string)) : $ids_placeholder; 
										
										// $keyword_string = get_product_ids_by_keyword( sanitize_text_field($_GET['ywcas_filter']) );
										// pretty_dump(get_product_ids_by_keyword(('KTM EXC-F 250 2017')));
										// if ( $products_on_sale->have_posts() ) {
										echo do_shortcode('[products category="'.$product_cat_slug.'" limit="'.$limitProducts.'" columns="4" paginate="true" ids="'.$ywcas_filter_ids.'"]');
											// while ( $products_on_sale->have_posts() ) : $products_on_sale->the_post();
				
											// // pretty_dump(get_the_ID());
											// /**
											//  * Hook: woocommerce_shop_loop.
											//  */
											// do_action( 'woocommerce_shop_loop' );
				
											// wc_get_template_part( 'content', 'product' );
				
											// endwhile; // end of the loop.
										// } else {
										// 	do_action( 'woocommerce_no_products_found' );
										// }
									}
								}
							// } else {
								// if ($get_brand) {
								// 	echo do_shortcode('[products attribute="brand" terms="'.$get_brand.'" limit="16" columns="4" paginate="true"]');

								// } else {	
								// 	pretty_dump('NO Sale product cart page');

								// 	echo do_shortcode('[products category="'.$product_cat_slug.'" limit="16" columns="4" paginate="true" ids="'.array().'"]');
								// }
								/**
								 * Hook: woocommerce_after_shop_loop.
								 *
								 * @hooked woocommerce_pagination - 10
								 */
							// }

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
							$list_categories($taxonomies, array());
							?>
						</ul>
						</div>

							<?php
							// Load::molecules('product-category/product-categories-view/index'); 
							output_filter_modal($get_product_cat, $promo_checked, $promo_link);
						?>
					</div>

					<?php } else { ?>

					<div class="filter-sidebar">
						<?php
							$list_categories($taxonomies, array());
						?>
						<p class="paragraph paragraph-xl semibold cat-head active-cat filters">Филтри</p>
						<?php echo do_shortcode('[wpf-filters id=2]'); ?>	
					</div>
					<?php
					}

				?>
				<!-- END of .filter-content-wrapper -->
	
	</div>
					<?php
				do_action( 'woocommerce_after_shop_loop' );
			} else {
				/**
				 * Hook: woocommerce_no_products_found.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			}
			?>

			<?php
									if (is_product_category()) :
										Load::molecules('category-description/index');
									endif;

						// echo do_shortcode('[wrvp_recently_viewed_products number_of_products_in_row="4" posts_per_page="4"]');
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
						// echo do_shortcode('[recently_viewed_products]');

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );