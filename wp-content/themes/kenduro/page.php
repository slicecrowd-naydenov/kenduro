<?php

/**
 * The template for displaying all pages
 */

get_header();
$url = $_SERVER['REDIRECT_URL'];
$is_dsk = $url === '/dsk/' || $url === '/dskbuy' || $url === '/dsksend';
$dsk_classes_cols = $is_dsk ? 'col-xl-8 offset-xl-2' : '';

$dsk_classes = '';
switch ($url) {
	case '/dsk/':
		$dsk_classes = 'step-1';
		break;

	case '/dskbuy':
		$dsk_classes = 'step-2';
		break;

	case '/dsksend':
		$dsk_classes = 'step-3';
		break;

	default:
		# code...
		break;
}

if ($is_dsk) :
?>
	<div class="dsk-page <?php echo esc_attr($dsk_classes); ?>" id="primary">
	<?php endif; ?>

	<div class="container">
		<div class="row">
			<div class="col <?php echo esc_attr($dsk_classes_cols); ?>">
				<?php
				if (have_posts()) :
					/* Start the Loop */
					while (have_posts()) :
						the_post();

						if ($is_dsk) : ?>
								<ul class="dsk-steps">
									<li class="dsk-steps__item finance-calculator">
										<span class="circle"></span>
										<p class="paragraph paragraph-l">Финансови условия</p>
									</li>
									<li class="dsk-steps__item private-data">
										<span class="circle"></span>
										<p class="paragraph paragraph-l">Лични Данни</p>
									</li>
									<li class="dsk-steps__item request-sent">
										<span class="circle"></span>
										<p class="paragraph paragraph-l">Успешно изпратена заявка</p>
									</li>
								</ul>
							<?php
						endif;

						if ($url === '/dsksend') :
							?>
								<div class="dsk-sent">
								<?php
							endif;

							the_content();

							if ($url === '/dsksend') :
							?>
							<a href="<?php echo esc_attr(get_site_url()); ?>/shop" class="button button-primary-orange paragraph paragraph-m semibold">
								<span>Върни се към Kenduro</span>
							</a>
							</div>
				<?php endif;
						/* Page content here */

						endwhile; // End of the loop.
					endif;
				?>

			</div>
		</div>
	</div>
	<?php
	if ($is_dsk) :
	?>
	</div>
<?php endif;
get_footer();
