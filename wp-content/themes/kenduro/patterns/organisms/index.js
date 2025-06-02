/* eslint-disable no-alert */
/* eslint-disable max-len */
import $ from 'jquery';
import axios from 'axios';

import { Tab } from 'bootstrap/js/dist/tab';
import { Collapse } from 'bootstrap/js/dist/collapse';
// import ShopFilter from './shop';
import Slider from './slider';
import MobileNavigation from './header/bottom/index';
// import MiddleHeader from './header/middle/index';
import SidebarFilter from './sidebar_filter/index';
import Compatibilities from './modals/bike-compatibility';

export default () => {
  // const $body = $('body');

  // if ($body.hasClass('woocommerce-shop')) {
  //   new ShopFilter();
  // }
  if (Compatibilities) {
    new Compatibilities(document.getElementById('compatibilities'));
  }

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

  function setCookie(name, value, days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    var expires = "expires=" + date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
  }

  var consentBanner = $('#consentBanner');
  var consentBannerOptions = $('#consentBannerOptions');

  if (!localStorage.getItem('consentGranted')) {
    consentBanner.modal('show');
  }


  $('.acceptCookies').on('click', () => {
  //   document.cookie = "consent=true; path=/";
    localStorage.setItem('consentGranted', 'true');
    consentBanner.modal('hide');
    consentBannerOptions.modal('hide');

    // gtag('consent', 'update', {
    //   'ad_storage': 'granted',
    //   'analytics_storage': 'granted',
    //   'ad_user_data': 'granted',
    //   'ad_personalization': 'granted'
    // });
  });

  $('#showOptions').on('click', (e) => {
    e.preventDefault();
    consentBanner.modal('hide');
    consentBannerOptions.modal('show');
  });

  $('#hideOptions').on('click', (e) => {
    e.preventDefault();
    consentBannerOptions.modal('hide');
    consentBanner.modal('show');
  });

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

    $('#pills-tab').find('.nav-link:not(#pills-all-tab)').on('click', function() {
    // var categorySlug = $(this).attr('id').replace('pills-', '').replace('-tab', '');
    var categoryId = $(this).data('category-id');

    // Провери дали вече не са заредени продуктите
    if ($('#products-' + categoryId).find('.products').children().length >= 1) {
      return;
    }

    axios({
      method: 'post',
      url: ajaxurl,
      data: new URLSearchParams({
        action: 'load_products',
        category_id: categoryId
      })
    })
      .then((response) => {
        $('#products-' + categoryId).html(response.data);
      })
      .catch((error) => {
        if (error.response) {
          // The request was made and the server responded with a status code
          // that falls out of the range of 2xx
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
        } else if (error.request) {
          // The request was made but no response was received
          console.log(error.request);
        } else {
          // Something happened in setting up the request that triggered an Error
          console.log('Error', error.message);
        }
        console.log(error.config);
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

  window.onload = function() {
    let additionalTaxTimeout;
    clearTimeout(additionalTaxTimeout);
    additionalTaxTimeout = setTimeout(() => {
      if (!window.Intercom) {
        // Създаваме <script> таг и го зареждаме динамично
        var intercomScript = document.createElement('script');
        intercomScript.type = 'text/javascript';
        intercomScript.async = true;
        intercomScript.src = 'https://widget.intercom.io/widget/xtb4h29q';
        var firstScript = document.getElementsByTagName('script')[0];
        firstScript.parentNode.insertBefore(intercomScript, firstScript);

        intercomScript.onload = function() {
          window.Intercom('boot', {
            app_id: 'xtb4h29q'
          });
          // window.Intercom('show');
        };
      } else {
        window.Intercom('show');
      }
    }, 7500);

    if (typeof woocommerce_single_product_id !== 'undefined') {
      var viewed = JSON.parse(localStorage.getItem("recently_viewed")) || [];
  
      var currentId = parseInt(woocommerce_single_product_id);
      // console.log('currentId: ', currentId);
      // Премахни го, ако вече съществува
      viewed = viewed.filter(function(id) {
        return id !== currentId;
      });
  
      // Добави най-отпред
      viewed.push(currentId);
  
      // Ограничаваме до 15
      if (viewed.length > 15) {
        viewed.shift();
      }
  
      localStorage.setItem("recently_viewed", JSON.stringify(viewed));
    }

    if ($('.recently-viewed-products').length) {
      // console.log('woocommerce_single_product_id: ', woocommerce_single_product_id);
      let viewed = JSON.parse(localStorage.getItem("recently_viewed")) || [];

      if (viewed.length) {
        axios({
          method: 'post',
          url: ajaxurl,
          data: new URLSearchParams({
            action: 'get_recently_viewed_products',
            ids: viewed.reverse().join(',')
          })
        })
        .then((response) => {
          $('.recently-viewed-products').html(response.data);
        })
        .catch((error) => {
          console.error('AJAX error:', error);
        });
      }
      // axios({
      //   method: 'get', 
      //   url: ajaxurl + '?action=get_recently_viewed_products'
      // })
      // .then((response) => {
      //   $('.recently-viewed-products').html(response.data);
      // })
      // .catch((error) => {
      //   console.error('AJAX error:', error);
      // });

    }
  };

  // $('#filterModal').on('show.bs.modal', function(event) {
  //   let modalBody = $(this).find('.modal-body');
  //   if (!modalBody.find('.show-cat-bike-compatibility').length) {
  //     let elementToClone = $('.show-cat-bike-compatibility');
  //     if (elementToClone.length) { // Уверяваме се, че елементът съществува
  //       let clonedElement = elementToClone.clone(true);
  //       modalBody.append(clonedElement);
  //     }
  //   }
  // });

  $('.category-description').find('.read-more').on('click', function() {
    $('.category-description__box').toggleClass('expanded').css('height', function() {
        return $(this).hasClass('expanded') ? $(this).prop('scrollHeight') + 'px' : '300px';
    });
    $(this).text($(this).text() === 'Прочети още' ? 'Скрий' : 'Прочети още');
});

  

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