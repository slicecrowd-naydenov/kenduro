<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package storefront
 */

get_header();

if(have_posts()) : ?>

	<h1 class="archive-title"><?php echo single_cat_title( '', false ); ?>:</h1>

<?php while(have_posts()) : the_post(); ?>

	<h2 class="post-title">
		<a href="<?php echo esc_attr(the_permalink()); ?>"><?php the_title(); ?></a>
	</h2>
	<br />
	<!-- <div class="post-content"><?php // the_excerpt(); ?></div> -->

<?php endwhile; ?>

<?php endif;

get_footer();
