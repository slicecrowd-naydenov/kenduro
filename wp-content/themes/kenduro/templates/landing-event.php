<?php
/* Template Name: Landing event*/
use Lean\Load;

get_header();
$available_seats = 13;
$sign_in_url = "https://form.smartsuite.com/sd0y91s2/EFmNkyr8RR";
$google_maps = "https://maps.app.goo.gl/AudCjg56yczwihxB7";
$images = range(1, 10);
?>
<div id="landing-event">
  <div class="header">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="wrapper">
            <p class="paragraph paragraph-l destination">гр. Банско, 26ти Октомври</p>
            <img src="<?php echo IMAGES_PATH; ?>/landing-event/landing-logo.png" alt="landing logo" class="landing-logo">
            <a href="<?php echo esc_url($sign_in_url); ?>" target="_blank" class="button button-primary-orange paragraph paragraph-m">Запиши се сега</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <main>
    <div class="hero-section">
      <div class="video-section">
        <iframe src="https://player.vimeo.com/video/1010929226?h=f4e8b3179a&amp;autoplay=1&amp;muted=1&amp;controls=0&amp;loop=1&amp;badge=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="TRRS background"></iframe>
      </div>
      <script src="https://player.vimeo.com/api/player.js"></script>
      <div class="wrapper">
        <h1 class="h1 bold event-title">TRRS Trial Shool</h1>
        <h3 class="h3 bold destination"> Банско, 26ти Октомври </h3>
        <div class="available-seats">
          <p class="paragraph paragraph-l text">Свободни места : <b><?php echo $available_seats; ?></b></p>
          <a href="<?php echo esc_url($sign_in_url); ?>" target="_blank" class="button button-primary-orange paragraph paragraph-l text">Запиши се сега !</a>
        </div>
        <p class="paragraph paragraph-m tax">Цена за участие : 80лв</p>
      </div>
    </div>

    <div class="assistants">
      <p class="paragraph paragraph-l">Със съдействието на</p>
      <a href="<?php echo esc_url(get_site_url()); ?>" rel="home" class="logo" target="_blank">
        <?php Load::atom('svg', ['name' => 'logo']); ?>
      </a>
    </div>

    <div class="content-section">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="wrapper">
              <div>
                <h2 class="h2 bold">Какво представлява траял </br>училището ?</h2>
                <p class="paragraph paragraph-xxl">Училището ще бъде водено от сертифициран Траял учител, който ще бъде изпратен специално от TRRS. По време на училището, учителят ще запознае участниците с основни траял техники и ще им покаже как да ги изпълняват правилно. В последствие той ще им покаже и как да тренират правилно, за да развиват техниката си на мотора и защо траял карането е важно, ако искат да се развиват като състезатели без значение от дисциплината, в която карат.</p>
              </div>
              <img src="<?php echo IMAGES_PATH; ?>/landing-event/frames.jpg" alt="frames" class="frames">
            </div>
            <div class="wrapper">
              <div>
                <h2 class="h2 bold">За кого е подходящо ?</h2>
                <p class="paragraph paragraph-xxl">Училището е подходящо за всеки любител на траяла, ендурото или мотокроса, който иска да усъвършенства своята техниката. Траял карането дава основите, без които прогресът става изключително труден и почти невъзможен. Траял карането е най-техничният мотоциклетен спорт и това го прави много подходящ за хард ендуро състезателите. Траялът развива супер много баланса, усещането на съединителя и газта и правилната ни стойка върху мотора. Целта на траяла е да усъвършенстваме цялостното движение и поведение на мотора с минимална човешка енергия и усилие. Ползите са, че когато научиш конкретна траял техника, след това много лесно и бързо тази техника може да се пренесе към ендуро карането и да ви бъде от полза.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="banner-section">
      <h1 class="h1 bold" style="margin: 0">Остават само <?php echo $available_seats; ?> места</h1>
      <a href="<?php echo esc_url($sign_in_url); ?>" target="_blank" class="button button-primary-orange paragraph paragraph-xxl">Запиши се сега !</a>
    </div>

    <div class="schedule">
      <div class="container">
        <div class="row">
          <div class="col">
          <h2 class="h2 bold">Каква е програмата на 26ти Октомври ?</h2>
          <p class="paragraph paragraph-xxl"><b class="hours">10:30 - 11:00 </b> Участниците трябва да са пристигнали и започва регистрация</p>
          <hr>
          <p class="paragraph paragraph-xxl"><b class="hours">11:00 - 14:00 </b> Демострация от сертифициран траял инструктор</p>
          <hr>
          <p class="paragraph paragraph-xxl"><b class="hours">14:00 - 15:30 </b> Почивка и обяд, който е включен в билета. Участниците ще могат да тестват различни TRSS модели</p>
          <hr>
          <p class="paragraph paragraph-xxl"><b class="hours">15:30 </b> В края на събитието всички участници получават сертификат за завършен курс, грамота и тениска</p>
          <hr>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <div class="specifications">
              <h2 class="h2 bold">Каква е цената ?</h2>
              <p class="paragraph paragraph-xxl">Цената за участие е 80лв. В цената е включен и обяд - в Банско сме, няма да са калмари ...</p>
              <p class="paragraph paragraph-xxl">В цената не е включен наем на траял мотор, ако такъв ви е необходим.</p>
            </div>
          </div>
          <div class="col-sm-12 col-md-6">
            <div class="specifications">
              <h2 class="h2 bold">Какви мотори могат да участват ?</h2>
              <p class="paragraph paragraph-xxl">За предпочитане е участниците да са с траял мотор, НО всеки с ендуро или кросов мотор също ще може да участва. Ще предоставим 5 TRRS мотора под наем за желаещите - трябва предварително да заявят, че искат да наемат мотор!  Цената за наемане на траял мотор е 100лв + 100лв депозит (200лв общо)</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <h2 class="h2 bold">Къде ще се проведе ?</h2>
            <p class="paragraph paragraph-xxl">Събитието ще се проведе на трасе, което е изградено ексклузивно за траял събитието.</p>
            <p class="paragraph paragraph-xxl">Локацията е гр.Банско, Казармите - където се провежда EnduroCross състезанието от Three Mountains Hard Enduro Bansko</p>
            <br>
            <a href="<?php echo esc_url($google_maps); ?>" target="_blank" class="button button-primary-blue paragraph paragraph-m">Виж в Google Maps</a>
            <br>
            <br>
            <img src="<?php echo IMAGES_PATH; ?>/landing-event/google-maps.jpg" alt="google maps">
            <br>
            <br>
            <h2 class="h2 bold">Кои са TRRS ?</h2>
            <p class="paragraph paragraph-xxl">TRRS става реалност благодарение на инициативата и усилията на четиримата си основатели. Жорди Тарес, известният състезател по траял, който е седемкратен световен шампион. Рикардо Новел, бизнесмен от Барселона, който видял в TRRS възможност да продължи своя план за подкрепа на изграждането на стабилна и иновативна индустриална база в Барселона. Марк Араньо, който има голям опит в бизнеса с мотори и Жозеп Борел, бизнесмен от Барселона.</p>
            <p class="paragraph paragraph-xxl">TRRS е официално създадена през 2013 година, и тогава започва производството на първия си траял модел в три работни обема (250, 280 и 300 куб. см) в края на 2014 година, както и разработването на нови модели през 2015 година.</p>
            <p class="paragraph paragraph-xxl">Производствените съоръжения са разположени в провинция Барселона, както и научноизследователските, развойните и иновационните дейности. В спортен план компанията предвижда постепенно участие в тази област, свързано с консолидацията на бизнеса.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="gallery">
      <div class="container">
        <div class="row">
          <div class="col">
            <hr>
            <h2 class="h2 bold">Галерия</h2>
            <p class="paragraph paragraph-xxl">Разгледайте някои от предишните TRRS събития в Европа.</p>
          </div>
        </div>
      </div>
      <div class="swiper-block">
        <div class="swiper" data-slider>
          <!-- Additional required wrapper -->
          <div class="swiper-wrapper">
            <!-- Slides -->
            <?php foreach ($images as $image) : ?>
              <div class="swiper-slide">
                <img src="<?php echo IMAGES_PATH; ?>/landing-event/slider/<?php echo $image; ?>.jpg" alt="slide-<?php echo $image; ?>">
              </div>
            <?php endforeach; ?>
          </div>

          <!-- If we need navigation buttons -->
        </div>
        <div class="siwper-navigation">
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>
      </div>
    </div>
    
    <div class="banner-section">
      <h1 class="h1 bold" style="margin: 0">Остават само <?php echo $available_seats; ?> места</h1>
      <h3 class="h3 bold">Банско, 26ти Октомври</h3>
      <a href="<?php echo esc_url($sign_in_url); ?>" target="_blank" class="button button-primary-orange paragraph paragraph-xxl">Запиши се сега !</a>
    </div>
    
    <div class="assistants">
      <p class="paragraph paragraph-l">Със съдействието на</p>
      <a href="<?php echo esc_url(get_site_url()); ?>" rel="home" class="logo" target="_blank">
        <?php Load::atom('svg', ['name' => 'logo']); ?>
      </a>
    </div>
  </main>
</div>
<?php
// pretty_dump(is_page_template('templates/landing-event.php'));
get_footer();
