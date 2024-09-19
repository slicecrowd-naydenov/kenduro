<?php
/* Template Name: Landing event*/
use Lean\Load;

get_header();
$available_seats = 25;
$sign_in_url = "#";
?>
<div id="landing-event">
  <div class="header">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="wrapper">
            <p class="paragraph paragraph-l">гр. Банско, 26ти Октомври</p>
            <img src="<?php echo IMAGES_PATH; ?>/landing-event/landing-logo.png" alt="landing logo" class="landing-logo">
            <a href="<?php echo esc_url($sign_in_url); ?>" class="button button-primary-orange paragraph paragraph-m">Запиши се сега</a>
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
        <h1 class="h1 bold">TRSS Trial Shool</h1>
        <h3 class="h3 bold"> Банско, 26ти Октомври </h3>
        <div class="available-seats">
          <p class="paragraph paragraph-l">Свободни места : <b><?php echo $available_seats; ?></b></p>
          <a href="<?php echo esc_url($sign_in_url); ?>" class="button button-primary-orange paragraph paragraph-l">Запиши се сега !</a>
        </div>
        <p class="paragraph paragraph-m tax">Цена за участие : 90лв</p>
      </div>
    </div>

    <div class="assistants">
      <p class="paragraph paragraph-l">Със съдействието на</p>
      <?php Load::molecules('logo/index'); ?>
    </div>

    <div class="content-section">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="wrapper">
              <div>
                <h2 class="h2 bold">Какво представлява траял </br>училичещо ?</h2>
                <p class="paragraph paragraph-l">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer congue auctor ex, a elementum elit lacinia sed. Ut nunc eros, euismod vitae rhoncus ac, lobortis eget erat. Curabitur volutpat urna sed eros viverra aliquam. Aenean eu augue magna. Sed aliquet dui sit amet ipsum pulvinar, id mollis nisl vulputate. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Suspendisse molestie, velit non varius semper, felis neque pulvinar arcu, ut facilisis enim tortor a tortor. Sed et rhoncus nulla. Ut a volutpat quam. Suspendisse convallis mi turpis, sit amet porttitor augue facilisis quis.</p>
              </div>
              <img src="<?php echo IMAGES_PATH; ?>/landing-event/frames.jpg" alt="frames" class="frames">
            </div>
            <div class="wrapper">
              <div>
                <h2 class="h2 bold">За кого е подходящо ?</h2>
                <p class="paragraph paragraph-l">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer congue auctor ex, a elementum elit lacinia sed. Ut nunc eros, euismod vitae rhoncus ac, lobortis eget erat. Curabitur volutpat urna sed eros viverra aliquam. Aenean eu augue magna. Sed aliquet dui sit amet ipsum pulvinar, id mollis nisl vulputate. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Suspendisse molestie, velit non varius semper, felis neque pulvinar arcu, ut facilisis enim tortor a tortor. Sed et rhoncus nulla. Ut a volutpat quam. Suspendisse convallis mi turpis, sit amet porttitor augue facilisis quis.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="banner-section">
      <h3 class="h3 bold">Остават само <?php echo $available_seats; ?> места</h3>
      <a href="<?php echo esc_url($sign_in_url); ?>" class="button button-primary-orange paragraph paragraph-l">Запиши се сега !</a>
    </div>

    <div class="schedule">
      <div class="container">
        <div class="row">
          <div class="col">
          <h2 class="h2 bold">Каква е програмата на 26ти Октомври ?</h2>
          <p class="paragraph paragraph-l"><b class="hours">10:30 - 11:00 </b> Участниците трябва да са пристигнали и започва регистрация</p>
          <hr>
          <p class="paragraph paragraph-l"><b class="hours">11:00 - 14:00 </b> Демострация от сертифициран траял инструктор</p>
          <hr>
          <p class="paragraph paragraph-l"><b class="hours">14:00 - 15:30 </b> Почивка и обяд, който е включен в билета. Участниците ще могат да тестват различни TRSS модели</p>
          <hr>
          <p class="paragraph paragraph-l"><b class="hours">15:30 </b> В края на събитието всички участници получават сертификат за завършен курс, грамота и тениска</p>
          <hr>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <div class="specifications">
              <h2 class="h2 bold">Каква е цената ?</h2>
              <p class="paragraph paragraph-xl">Цената за участие е 90лв. В цената е включен и обяд - в Банско сме, няма да са калмари ...</p>
              <p class="paragraph paragraph-xl">В цената не е включен наем на траял мотор, ако такъв ви е необходим.</p>
            </div>
          </div>
          <div class="col-sm-12 col-md-6">
            <div class="specifications">
              <h2 class="h2 bold">Какви мотори могат да участват ?</h2>
              <p class="paragraph paragraph-xl">За предпочитане е участниците да са с траял мотор, НО всеки с ендуро или кросов мотор също ще може да участва. Ще предоставим 5 TRRS мотора под наем за желаещите - трябва предварително да заявят, че искат да наемат мотор!  Цената за наемане на траял мотор е 100лв + 100лв депозит (200лв общо)</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <h2 class="h2 bold">Къде ще се проведе ?</h2>
            <p class="paragraph paragraph-xl">Събитието ще се проведе на трасе, което е изградено ексклузивно за траял събитието.</p>
            <p class="paragraph paragraph-xl">Локацията е гр.Банско, Казармите - където се провежда EnduroCross състезанието от Three Mountains Hard Enduro Bansko</p>
            <br>
            <a href="#" class="button button-primary-blue paragraph paragraph-m">Виж в Google Maps</a>
            <br>
            <br>
            <img src="<?php echo IMAGES_PATH; ?>/landing-event/google-maps.jpg" alt="google maps">
            <br>
            <br>
            <h2 class="h2 bold">Кои са TRRS ?</h2>
            <p class="paragraph paragraph-xl">TRRS става реалност благодарение на инициативата и усилията на четиримата си основатели. Жорди Тарес, известният състезател по траял, който е седемкратен световен шампион. Рикардо Новел, бизнесмен от Барселона, който видял в TRRS възможност да продължи своя план за подкрепа на изграждането на стабилна и иновативна индустриална база в Барселона. Марк Араньо, който има голям опит в бизнеса с мотори и Жозеп Борел, бизнесмен от Барселона.</p>
            <p class="paragraph paragraph-xl">TRRS е официално създадена през 2013 година, и тогава започва производството на първия си траял модел в три работни обема (250, 280 и 300 куб. см) в края на 2014 година, както и разработването на нови модели през 2015 година.</p>
            <p class="paragraph paragraph-xl">Производствените съоръжения са разположени в провинция Барселона, както и научноизследователските, развойните и иновационните дейности. В спортен план компанията предвижда постепенно участие в тази област, свързано с консолидацията на бизнеса.</p>
            <br>
            <a href="#" class="button button-primary-blue paragraph paragraph-m">Виж в Google Maps</a>
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
            <p class="paragraph paragraph-xl">Разгледайте някои от предишните TRRS събития в Европа.</p>
          </div>
        </div>
      </div>
      <div class="wrapper">

      </div>
    </div>
    
    <div class="banner-section">
      <h1 class="h1 bold" style="margin: 0">Остават само <?php echo $available_seats; ?> места</h1>
      <h3 class="h3 bold">Банско, 26ти Октомври</h3>
      <a href="<?php echo esc_url($sign_in_url); ?>" class="button button-primary-orange paragraph paragraph-l">Запиши се сега !</a>
    </div>
    
    <div class="assistants">
      <p class="paragraph paragraph-l">Със съдействието на</p>
      <?php Load::molecules('logo/index'); ?>
    </div>
  </main>
</div>
<?php
// pretty_dump(is_page_template('templates/landing-event.php'));
get_footer();
