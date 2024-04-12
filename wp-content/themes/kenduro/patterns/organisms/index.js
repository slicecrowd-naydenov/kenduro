/* eslint-disable max-len */
import $ from 'jquery';

import { Tab } from 'bootstrap';
// import ShopFilter from './shop';
import Slider from './slider';
import MobileNavigation from './header/bottom/index';
// import MiddleHeader from './header/middle/index';

export default () => {
  // const $body = $('body');

  // if ($body.hasClass('woocommerce-shop')) {
  //   new ShopFilter();
  // }

  $('[data-slider]').each((index, el) => {
    new Slider(el);
  });
  
  if (MobileNavigation) {
    new MobileNavigation(document.getElementById('site-navigation-menu-toggle'));
  }

  // if (MiddleHeader) {
  //   new MiddleHeader(document.getElementById('middle-section'));
  // }

  if ($('#pills-tab').length) {
    var triggerTabList = [].slice.call(document.querySelectorAll('#pills-tab a'));
    triggerTabList.forEach(function (triggerEl) {
      var tabTrigger = new Tab(triggerEl);
  
      triggerEl.addEventListener('click', function (event) {
        event.preventDefault();
        tabTrigger.show();
      });
    });
  }

  $('button[data-bs-toggle="pill"]').on('click', function() {
    const selectedPill = $(this).text();
    $('#dropdownMenuButton').text(selectedPill);
  });

  if ($('.product-gallery-section').length) {
    setTimeout(() => {
      const wooProductGallery = $('.woocommerce-product-gallery').width();
      $('.product-gallery-section').find('.onsale').css('left', `calc(${wooProductGallery}px - 30px)`);
    }, 500);
  }

  $('.filter-sidebar').find('.active').each(function() {
    const activeCat = $( this ).text();

    $(this).closest('.product-cat-filter').next().text(activeCat);
  });

  $('.cat-head').on('click', function() {
    $(this).toggleClass('active-cat'); 
    $(this).next().slideToggle();
  });

  // $('body').addClass(myFunction());

  // var triggerEl = document.querySelector('#myTab a[href="#profile"]');
  // Tab.getInstance(triggerEl).show(); // Select tab by name

  // var triggerFirstTabEl = document.querySelector('#myTab li:first-child a');
  // Tab.getInstance(triggerFirstTabEl).show(); // Select first tab


};