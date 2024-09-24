/* eslint-disable no-alert */
/* eslint-disable max-len */
import $ from 'jquery';

import { Tab } from 'bootstrap';
// import ShopFilter from './shop';
import Slider from './slider';
import MobileNavigation from './header/bottom/index';
// import MiddleHeader from './header/middle/index';
import SidebarFilter from './sidebar_filter/index';

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
  
  if ($('.filter-content-wrapper').length) {
    new SidebarFilter($('.filter-content-wrapper'));
  }

  if ($('body').hasClass('page-template-landing-event')) {
    // eslint-disable-next-line no-undef, new-cap
    Intercom('update', { 'hide_default_launcher': true });
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

  $('.add-coupon').on('click', function() {
    $(this).parents('.coupon-wrapper').addClass('added-coupon');
  });

  $('.dropdown-menu-sort').on('click', '.wpfLiLabel', function() {
    const selectedSortType = $(this).find('.wpfFilterTaxNameWrapper').text();
    $('.sort-by-title').text(selectedSortType);
  });

  const accordionItem = $('.accordion-item');
  const accordionOnSales = $('#accordionOnSales');

  $('.accordion-button').on('click', function() {
    accordionItem.removeClass('opened');
    $(this).parents('.accordion-item').addClass('opened');
  });

  if (accordionOnSales.length) {
    // const items = document.querySelectorAll('.accordion-item');

    const accordionOnSalesHeight = accordionOnSales.height(); // Общата височина на контейнера
    // console.log(accordionOnSalesHeight);

    const openItemHeight = accordionOnSalesHeight - 46 * (accordionItem.length - 1) - 3 * (accordionItem.length - 1);
    $('.accordion-item.opened').height(openItemHeight);

    var currentIndex = 2;
    var totalItems = accordionItem.length;

    accordionItem.on('click', function(e) {
      e.stopPropagation();
      accordionItem.height(46);
      $(this).height(openItemHeight);
    });

    $('.accordion-button').on('click', function() {
      if (!$(this).hasClass('collapsed')) {
        currentIndex = parseInt($(this).attr('data-current-index'), 10);
        // console.log('CURRENTINDEX:', currentIndex);
      }
    });
    
    setInterval(function() {
      var currentItem = $(`#accordion-item-${currentIndex}`).find('.accordion-button');

      if ($(`#accordion-item-${currentIndex}`).find('.accordion-button').hasClass('collapsed')) {
        currentItem.trigger('click');
      }
      
      // console.log('currentItem: ', currentItem);
      // console.log('currentIndex: ', currentIndex);
      // console.log('totalItems: ', totalItems);
      // console.log('=================');
      // eslint-disable-next-line no-plusplus
      currentIndex++;
      
      if (currentIndex > totalItems) {
        currentIndex = 1;
      }
    }, 5000);
  }


  // setTimeout(() => {
  //   var elements = $('.dropdown-menu-sort').find('.wpfDisplay');

  //   elements.each(function(element) {
  //     console.log(this.style.fontWeight);
  //     if ( this.style['fontWeight'] === 'bold' ) {
  //       this.style.color = 'blue';
  //     } else {
  //       this.style.color = 'green';
  //     }
  //     if ($(element).attr('style')) {
  //       console.log(element); // Тук можете да направите каквото ви е необходимо с елемента
  //     }
  //   });
  // }, 2000 );
  
  // $('body').addClass(myFunction());

  // var triggerEl = document.querySelector('#myTab a[href="#profile"]');
  // Tab.getInstance(triggerEl).show(); // Select tab by name

  // var triggerFirstTabEl = document.querySelector('#myTab li:first-child a');
  // Tab.getInstance(triggerFirstTabEl).show(); // Select first tab


};