<?php
/**
 * The author template. Used when an author is queried.
 */

//Redirect author pages to the homepage with WordPress redirect function
wp_safe_redirect( get_home_url(), 301 );
exit;
//That's all folks
