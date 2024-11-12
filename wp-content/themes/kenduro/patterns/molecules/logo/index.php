<?php
if (has_custom_logo()) {
  the_custom_logo();
} else {
?>
  <a href="<?php echo esc_url(get_site_url()); ?>" rel="home" class="logo" aria-label="Kenduro logo">Kenduro</a>
<?php } ?>