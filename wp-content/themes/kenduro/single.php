<?php
/**
 * The template for displaying all single posts
 */

get_header();

if ( have_posts() ) :
	/* Start the Loop */
	while ( have_posts() ) :
		the_post();

		/* Post content here */

	endwhile; // End of the loop.
endif;

get_footer();
