<?php
use Lean\Load;
?>

<footer id="footer">
  <div class="container">
    <div class="row top">
      <div class="col-md-4 col-12">
        <a href="<?php echo esc_url(get_site_url()); ?>/terms-and-conditions/#terms-delivery" class="paragraph paragraph-l">Доставка</a>
        </br>
        <a href="<?php echo esc_url(get_site_url()); ?>/terms-and-conditions/#terms-payment" class="paragraph paragraph-l">Плащания</a>
        </br>
        <a href="<?php echo esc_url(get_site_url()); ?>/terms-and-conditions/#terms-complaint" class="paragraph paragraph-l">Рекламация</a>
      </div>
      <div class="col-md-4 col-12">
        <p class="paragraph-l">Свържи се с нас</p>
        <p class="paragraph-m">
          Имейл :
          <a href="mailto:sales@kenduro.com">sales@kenduro.com</a>
        </p>
        <p class="paragraph-m">
          Телефон :
          <a href="tel:+359 886 230023">+359 886 230023</a>
        </p>
        <ul class="socials">
          <li>
            <a href="https://www.instagram.com/kenduro_shop/" target="_blank">
              <?php Load::atom('svg', ['name' => 'instagram']); ?>
            </a>
          </li>
          <li>
            <a href="https://www.facebook.com/kenduro.shop" target="_blank">
              <?php Load::atom('svg', ['name' => 'facebook']); ?>
            </a>
          </li>
          <!-- <li>
            <a href="#">
              <?php // Load::atom('svg', ['name' => 'tic-tok']); ?>
            </a>
          </li>
          <li>
            <a href="#">
              <?php // Load::atom('svg', ['name' => 'linkedin']); ?>
            </a>
          </li> -->
        </ul>
      </div>
      <div class="col-md-4 col-12 address-info">
        <p class="paragraph-m">Кендуро ООД</p>
        <ul>
          <li class="paragraph-m">Република България, Област Благоевград, Община Банско, гр. Банско, 2770, ул. „Пирин“ № 29</li>
          <li class="paragraph-m">ЕИК 207045135</li>
          <li class="paragraph-m">Телефон за връзка : <a href="tel:+359 886 230023">0886230023</a></li>
          <li class="paragraph-m">Адрес за кореспонденция : гр. Банско, 2700, ул. „Пирин“ № 29</li>
        </ul>
      </div>
    </div>
  </div>
  <hr>
  <div class="container">
    <div class="row bottom">
      <div class="col text-center">
        <a href="<?php echo esc_url(get_site_url()); ?>" rel="home" class="logo">
          <?php Load::atom('svg', ['name' => 'logo_light']); ?>
        </a>
        <div>
          <a href="<?php echo esc_url(get_site_url()); ?>/terms-and-conditions" class="paragraph paragraph-m" target="_blank">Общи Условия</a>
          <a href="<?php echo esc_url(get_site_url()); ?>/privacy-policy" class="paragraph paragraph-m" target="_blank">Лични Данни</a>
          <a href="<?php echo esc_url(get_site_url()); ?>/cookie-policy" class="paragraph paragraph-m" target="_blank">Бисквитки</a>
        </div>
      </div>
    </div>
  </div>
</footer>