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
            <h3>Добави мотора си</h3>
            <p class="paragraph paragraph-xl">И ние ще ти покажем само продуктите, които те интересуват</p>
          </div>
          <img src="<?php echo IMAGES_PATH; ?>/add_bike.png" />
        </div>
        <div id="compatibilities">
          <select id="brand-dropdown">
            <option value="">Избери марка</option>
            <?php get_all_bike_brands(); ?>
          </select>

          <select id="model-dropdown">
            <option value="">Избери модел</option>
          </select>

          <select id="year-dropdown">
            <option value="">Избери година</option>
          </select>

          <h5 id="selected-bike"></h5>
          <a href="#" id="see-all-parts" class="button button-primary-orange paragraph-l" target="_blank">Виж всички части</a>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

