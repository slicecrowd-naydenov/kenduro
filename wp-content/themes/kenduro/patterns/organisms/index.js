/* eslint-disable max-len */
import $ from 'jquery';

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
};