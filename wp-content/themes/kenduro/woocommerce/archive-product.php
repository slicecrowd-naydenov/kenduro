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

global $wp_query;
$query_vars = $wp_query->query_vars;

$get_brand = isset($query_vars['pa_brand']) ? $query_vars['pa_brand'] : null;
$get_product_cat = isset($query_vars['product_cat']) ? $query_vars['product_cat'] : null;
$product_cat_ID = 0;

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
	$term_logo_id = $meta_fields['exclusive_logo'][0];
	$term_banner_id = $meta_fields['exclusive_banner'][0];
	$brand_description = $meta_fields['brand_description'][0];
	$term_logo = wp_get_attachment_url($term_logo_id);
	$term_banner = wp_get_attachment_url($term_banner_id);
	$classes = $is_exclusive ? 'exclusive' : 'no-exclusive';
}

function output_filter_modal() {
	if (wp_is_mobile()) {
		?>
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
						<?php
							Load::molecules('product-category/product-categories-filter/index');
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	} else {
		Load::molecules('product-category/product-categories-filter/index');
	}
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
				<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
					<!-- .woocommerce-products-header__title -->
					<h4 class="page-title semibold <?php echo esc_attr($classes); ?>">
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
						<?php endif;?>
					</h4>
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
						// Load::molecules('product-category/product-categories-view/index');
					}
				}
			} else {
				// Brand Tax page
				?>

				<div class="brand-info <?php echo esc_attr($classes); ?>">
					<div class="brand-info__image">
						<div class="brand-info__logo">
							<img src="<?php echo esc_attr($term_logo)?>" />
						</div>
						<img src="<?php echo esc_attr($term_banner)?>" />
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
					<?php  if (wp_is_mobile()) { ?>
					<div class="mobile-wrapper filter-sidebar">
						<div class="dropdown">
						<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
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
							output_filter_modal();
						?>
					</div>

					<?php } else { ?>

					<div class="filter-sidebar">
						<?php
							$list_categories($taxonomies, array());
						?>
						<p class="paragraph paragraph-xl semibold cat-head active-cat filters">Филтри</p>
						<?php echo do_shortcode('[wpf-filters id=1]'); ?>
	
					</div>
					<?php
					}
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

				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
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
