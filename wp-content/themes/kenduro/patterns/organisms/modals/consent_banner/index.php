<?php
  // if (!isset($_COOKIE['consentGranted'])) {
  //   $class = 'show';
  //   $display = 'block';
  //   $ariaHidden = 'false';
  // } else {
  //   $class = '';
  //   $display = 'none';
  //   $ariaHidden = 'true';
  // }
?>

<div class="modal fade" id="consentBanner" tabindex="-1" role="dialog" aria-labelledby="consentBannerTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div>
          <h5>Използваме бисквитки, няма kak ... </h5>
          <p class="paragraph paragraph-l">За да осигурим на-добрите изживявания, ние използваме технологии като \'бисквитки\' за съхранение и/или достъп до информация за устройството. Оставаш си анонимен, не се притеснявай 😀
          </p>
          <div class="content-footer">
            <button class="button button-primary-orange paragraph paragraph-l semibold acceptCookies">
              <span>Приемане</span>
            </button>
            <button class="button button-secondary paragraph paragraph-l semibold" id="showOptions">
              <span>Настройки</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="consentBannerOptions" tabindex="-1" role="dialog" aria-labelledby="consentBannerOptionsTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div>
          <h5>Статистики</h5>
          <p class="paragraph paragraph-l">Искам да ви помогна да направите този сайт по-добър, така че ще ви предоставя анонимни данни за използването на този сайт от мен.
          </p>
          </br>
          <h5>Персонализиране</h5>
          <p class="paragraph paragraph-l">Искам да имам най-доброто изживяване на този сайт, така че се съгласявам да запазя избора си, да препоръчвам неща, които може да харесам, и да модифицирам сайта по мой вкус
          </p>
          </br>
          <h5>Маркетинг</h5>
          <p class="paragraph paragraph-l">Искам да виждам реклами с вашите оферти, купони и изключителни оферти, а не произволни реклами от други рекламодатели.
          </p>
          <div class="content-footer">
            <button class="button button-secondary paragraph paragraph-l semibold acceptCookies">
              <span>Съгласен</span>
            </button>
            <button class="button button-primary-orange paragraph paragraph-l semibold" id="hideOptions">
              <span>Назад</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>