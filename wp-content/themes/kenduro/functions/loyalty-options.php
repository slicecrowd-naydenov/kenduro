<?php

add_action('woocommerce_after_cart', 'add_points_to_checkout');

function add_points_to_checkout() {
    if (!is_user_logged_in()) return;

    $user_id = get_current_user_id();
    $user_points = (int) get_field('user_points', 'user_' . $user_id);

    if ($user_points <= 0) return;

    ?>
    <div id="custom_points_section" style="margin:15px 0;">
      <h3>Използвай точки за отстъпка</h3>
      <p>Налични точки: <strong id="user_points_display"><?= $user_points ?></strong> (1 точка = 1 лв)</p>
      <div style="margin-top:10px;">
        <input type="number" id="used_points_value" min="1" max="<?= $user_points ?>" />
        <button type="button" class="" id="apply_points_btn">Използвай</button>
        <div id="points_message" style="margin-top:10px;"></div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('apply_points_btn');
        btn.addEventListener('click', function () {
          const value = document.getElementById('used_points_value').value;
          const messageBox = document.getElementById('points_message');

          btn.disabled = true;
          btn.innerText = 'Обработка...';

          const currentPointsEl = document.getElementById('user_points_display');
          const used = parseInt(document.getElementById('used_points_value').value);
          const current = parseInt(currentPointsEl.textContent);
          const remaining = current - used;
          currentPointsEl.textContent = remaining >= 0 ? remaining : 0;

          const couponCode = 'points_' + used;
          const couponField = document.getElementById('coupon_code');
          const applyButton = document.querySelector('button[name="apply_coupon"]');

          if (couponField && applyButton) {
            couponField.value = couponCode;
            applyButton.click(); // тригва WooCommerce логиката
          }

          fetch(ajaxurl, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
              action: 'apply_loyalty_points',
              points: value,
              security: '<?php echo wp_create_nonce('apply_points_nonce'); ?>'
            })
          })
          .then(res => res.json())
          .then(data => {
            console.log('AJAX Response:', data); // ← това ще ти помогне да видиш реалния JSON
            btn.disabled = false;
            btn.innerText = 'Използвай';
            messageBox.innerHTML = data.message;
            if (data.success) {
              jQuery(document.body).trigger('update_checkout');
              // Актуализирай визуално точките
   

              if (remaining <= 0) {
                document.getElementById('custom_points_section').style.display = 'none';
              }

              // Деактивирай инпута, за да не използват още веднъж
              document.getElementById('used_points_value').disabled = true;
              btn.disabled = true;
            }
          });
        });
      });
  </script>
  <?php
}
