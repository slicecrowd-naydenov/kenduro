<?php 
  use Lean\Load;
  if (!is_page_template('templates/landing-event.php') ) {
    Load::organism('footer/index');
    Load::organisms('modals/consent_banner/index');
  }
  wp_footer(); 
?>

<!--Start of Tawk.to Script-->
<!-- <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/65f84698cc1376635adbd434/1hp8t7gvr';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End of Tawk.to Script-->

</body>
</html>
