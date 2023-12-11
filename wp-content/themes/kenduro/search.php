<?php
/**
 * The template for displaying search results pages
 */

get_header();

if ( have_posts() ) :
	/* Start the Loop */
	while ( have_posts() ) :
		the_post();

		/* Search content here */

	endwhile; // End of the loop.
endif;

get_footer();
