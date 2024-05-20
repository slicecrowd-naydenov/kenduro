<?php

use Lean\Load;

/**
 * The template for displaying archive pages.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */

get_header();
?>
<div id="blog">
	<div class="blog-hero">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="wrapper woocommerce-checkout">
						<div class="left">
							<h1>Кендуро Блог</h1>
							<p class="paragraph paragraph-xl">Бъди информиран за всичко в ендурото</p>
						</div>
						<div class="right woocommerce">
							<?php echo do_shortcode('[contact-form-7 id="817a8d2" title="Newssletter"]'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	if (have_posts()) : ?>

		<!-- <h1 class="archive-title"><?php // echo single_cat_title('', false); 
																		?>:</h1> -->
		<div class="container">
			<div class="row">
				<div class="col">
					<ul class="blog-post-list">

						<?php $count = 1;
						while (have_posts()) : the_post(); ?>
							<li class="blog-post-list__item item<?php echo $count; ?>">
								<a href="<?php echo esc_attr(the_permalink()); ?>">
									<?php
									if (has_post_thumbnail()) {
									?>
										<div class="thumb">
											<?php the_post_thumbnail('medium_large'); ?>
										</div>
									<?php
									}

									echo '<p class="paragraph paragraph-xl semibold post-title">' . get_the_title() . '</p>';
									// Извеждане на описание
									echo '<p class="paragraph paragraph-l post-excerpt">' . get_the_excerpt() . '</p>';
									?>
									<span class="learn-more">
										Виж повече
										<?php Load::atom('svg', ['name' => 'arrow_orange']); ?>
									</span>
								</a>
							</li>
						<?php $count++;
						endwhile; ?>
					</ul>
				</div>
			</div>
		</div>

	<?php endif; ?>
</div>
<?php
get_footer();
