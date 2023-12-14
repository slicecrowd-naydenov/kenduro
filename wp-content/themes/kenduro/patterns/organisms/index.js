/* eslint-disable max-len */
import $ from 'jquery';

import { Tab } from 'bootstrap';
import ShopFilter from './shop';
import Slider from './slider';

export default () => {
  const $body = $('body');

  if ($body.hasClass('woocommerce-shop')) {
    new ShopFilter();
  }

  $('[data-slider]').each((index, el) => {
    new Slider(el);
  });

  var triggerTabList = [].slice.call(document.querySelectorAll('#pills-tab a'));
  triggerTabList.forEach(function (triggerEl) {
    var tabTrigger = new Tab(triggerEl);

    triggerEl.addEventListener('click', function (event) {
      event.preventDefault();
      tabTrigger.show();
    });
  });

  // var triggerEl = document.querySelector('#myTab a[href="#profile"]');
  // Tab.getInstance(triggerEl).show(); // Select tab by name

  // var triggerFirstTabEl = document.querySelector('#myTab li:first-child a');
  // Tab.getInstance(triggerFirstTabEl).show(); // Select first tab


};