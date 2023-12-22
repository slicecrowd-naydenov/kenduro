<!-- Modal -->
<div class="modal fade" id="deleteProductConfirmation" tabindex="-1" role="dialog" aria-labelledby="deleteProductConfirmationTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="img-wrapper">
          <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" alt="">
        </div>
        <div>
          <h3 class="semibold">Сигурен ли си ?</h3>
          <p class="paragraph paragraph-xl">Премахваш <b id="product_name"></b></p>
          <a href="#" class="button button-secondary paragraph paragraph-l semibold" id="cancelDeleteButton">Не, остави в количката</a>
          <a href="#" class="button button-primary paragraph paragraph-l semibold" id="confirmDeleteButton">Да, премахни</a>
        </div>
      </div>
    </div>
  </div>
</div>