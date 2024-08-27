<!-- Modal -->
<div class="modal fade" id="compatibilityModal" tabindex="-1" role="dialog" aria-labelledby="compatibilityModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      <div class="modal-body">
        <div class="modal-head">
          <div>
            <h3 class="bold">Добави мотора си</h3>
            <p class="paragraph paragraph-xl">И ние ще ти покажем само продуктите, които те интересуват</p>
          </div>
          <img src="<?php echo IMAGES_PATH; ?>/add_bike.png" />
        </div>
        <div id="compatibilities">
          <div class="compatibilities-dropdown">
            <label for="brand" class="paragraph paragraph-l">Марка</label>
            <select name="brand" id="brand-dropdown">
              <option value="">Избери</option>
              <?php get_all_bike_brands(); ?>
            </select>
          </div>
          <div class="compatibilities-dropdown">
            <label for="model" class="paragraph paragraph-l">Модел</label>
            <select name="model" id="model-dropdown">
              <option value="">Избери</option>
            </select>
          </div>
          <div class="compatibilities-dropdown">
            <label for="year" class="paragraph paragraph-l">Година</label>
            <select name="year" id="year-dropdown">
              <option value="">Избери</option>
            </select>
          </div>
        </div>
        <a href="#" id="see-all-parts" class="button button-primary-orange paragraph-l text-center disable" target="_blank">Покажи ми продуктите за моя мотор</a>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

