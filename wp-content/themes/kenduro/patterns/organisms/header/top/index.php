<?php
use Lean\Load;
$page_name = strtolower(get_the_title());
?>
<div id="top-section">
  <p class="paragraph paragraph-m semibold">
    Call us at 0886 230 023 or <a href="#" class="chat-link">Chat with us</a>
  </p>
  <div>
    <!-- <p class="paragraph paragraph-m semibold">Some menu goes here</p>
    <p class="paragraph paragraph-m semibold lang-bar">Language bar</p> -->
    <?php
    if ($page_name !== 'cart') {
      Load::molecules('woo-header-cart-button/index');
    }
    ?>
  </div>
</div>