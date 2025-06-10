<?php
use Lean\Load;

/**
 * The template for displaying all single posts
 */

get_header();
$selected_ids = null;

if (have_posts()) {
	while (have_posts()) {

?>

	<div id="primary" class="factory-riders">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="single-content-wrapper">
						<div class="featured-image">
							<?php the_post_thumbnail(); ?>
						</div>
						<div class="content-wrapper woocommerce-checkout">
							<div class="content" style="width: auto; flex: inherit;">
								<div class="content-nav">
									<div class="post-category">
										<a href="<?php echo esc_attr(get_site_url().'/factory-riders'); ?>" class="post-category__main">Обратно към нашите Factory Riders</a>
									</div>
									<div class="share-box">
										<p class="paragraph paragraph-l">Сподели:</p>
										<!-- AddToAny BEGIN -->
											<?php $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
										
											<div class="a2a_kit a2a_kit_size_16 addtoany_list" data-a2a-url="<?php esc_attr_e($actual_link); ?>">
												<a class="a2a_button_facebook"></a>
												<a class="a2a_button_copy_link"></a>
											</div>
											<script async src="https://static.addtoany.com/menu/page.js"></script>
											<!-- AddToAny END -->

										<?php // echo do_shortcode('[addtoany]');?>
									</div>
								</div>

								<h1 class="bold"><?php the_title(); ?></h1>
								<?php
								the_post();
								the_content();
								?>
							</div>
						</div>
						<?php
							Load::molecules('product-category/product-category-info/index', [
								'title' => '<span class="highlighted">K</span>enduro е изработен от Teo',
								'class' => 'full-width-container',
								'description' => 'Тео Кабакчиев, световноизвестен хард ендуро състезател, ръководи Kenduro.com с непоколебима страст, гарантирайки нашия непоколебим ангажимент към услуги и качество от най-високо ниво.'
							]);

							?>
					</div>
				</div>
			</div>
		</div>
		<?php Load::molecules('best-selling-products/index');  ?>
		
	</div>
<?php
	}
}
get_footer();
