/* eslint-disable no-alert */
/* eslint-disable max-len */
import $ from 'jquery';
import axios from 'axios';
import Swiper from 'swiper';
import { Navigation, Thumbs } from 'swiper/modules';
Swiper.use([Navigation, Thumbs]);

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

  if (!document.cookie.includes('consentGranted=')) {
    consentBanner.modal('show');
  }


  $('.acceptCookies').on('click', () => {
  //   document.cookie = "consent=true; path=/";
    setCookie('consentGranted', 'true', 365);
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
  };

  $('#filterModal').on('show.bs.modal', function(event) {
    let modalBody = $(this).find('.modal-body');
    if (!modalBody.find('.show-cat-bike-compatibility').length) {
      let elementToClone = $('.show-cat-bike-compatibility');
      if (elementToClone.length) { // Уверяваме се, че елементът съществува
        let clonedElement = elementToClone.clone(true);
        modalBody.append(clonedElement);
      }
    }
  });

  let triggeringElement = null;

  const targetNode = document.querySelector('#asnp-easy-product-bundle-modal'); 
  const config = { childList: true, subtree: true };
  let observer; // Глобален observer

  // Callback функция
  const callback = function (mutationsList, observer) {
    for (const mutation of mutationsList) {
      if (mutation.type === 'childList') {
        handleModalLogic();
      }
    }
  };

  function handleModalLogic() {
    const modal = document.querySelector('#asnp-easy-product-bundle-modal .asnp-modal-mask');
    if (modal && modal.style.display !== 'none') {
      // const productId = parseInt($(triggeringElement).attr('data-product-id'), 10);
      // const productData = bundle_products_ids.find(item => item.id === productId);
      const triggeringName = $(triggeringElement).find('.asnp-product-name').text();
      const listVariations = $('.asnp-post-grid-wrapper');

  
      // Създай индекс за бързо търсене на вариации
      const variationIndexMap = {};
      bundle_products_ids.forEach(product => {
        if (product.variations) {
          product.variations.forEach(variation => {
            variationIndexMap[variation.name] = variation;
          });
        }
      });

      // Stop observer temporarry
      if (observer) observer.disconnect();

      listVariations.each(function () {
        const variationName = $(this).find('.asnp-post-grid-info h3').text();
  
        if (variationName === triggeringName) {
          $(this).addClass('selected');
        } else {
          $(this).removeClass('selected');
        }
  
        // Проверка за вариация чрез индекса
        const matchedVariation = variationIndexMap[variationName];
        if (matchedVariation) {
          let delivery_time_text = matchedVariation.delivery_time_text;
          let delivery_message = deliveryTimeTextFn(matchedVariation, delivery_time_text);

          $(this).attr('data-id', matchedVariation.id);
          $(this).find('.stock span').text(delivery_message);
        }

        $(this).on('click', () => {
          $(triggeringElement).attr('data-product-id', $(this).attr('data-id'));
        })
      });

      // Start observer again
      if (observer) observer.observe(targetNode, config);
    }
  }

  function deliveryTimeTextFn(matchedVariation, delivery_time_text) {
    let delivery_message;

    if (matchedVariation.quantity > 0) {
      delivery_message = "Може да бъде доставено утре!";
    } else {
      switch (delivery_time_text) {
        case "В момента няма наличност":
          delivery_message = "В момента няма наличност";
          break;
        case "Ще се свържем с вас":
          delivery_message = "Наличност : ще се свържем с вас";
          break;
        case "1 Ден (утре)":
          delivery_message = "Може да бъде доставено утре!";
          break;
        default:
          delivery_message = "Доставка " + delivery_time_text;
      }
    }

    return delivery_message;
  }
  

  $('body').on('click', '.asnp-bundle-item', function (event) {
    triggeringElement = this;

    handleModalLogic();

    if (!observer) {
      observer = new MutationObserver(callback);
      observer.disconnect();
      observer.observe(targetNode, config);
    }
  });

  // console.log(bundle_products_ids); // Проверка в конзолата
  function checkIsVariation() {
    bundle_products_ids.forEach(function (product, index) {
      // Намираме съответния <li> елемент по индекса
      let listItem = $(`#asnp-bundle-item-${index}`);
      listItem.attr('data-product-id', bundle_products_ids[index]['id']);
      // Проверяваме дали типът е "variation"
      if (product.type === "variation") {
          // Добавяме клас на съответния елемент
        listItem.addClass('is-variation');
      } else {
        removeAllEventsExceptChild(listItem, '.asnp-info-icon');
      }
    });
  }

  function removeAllEventsExceptChild(selector, childSelector) {
    $(selector).each(function () {
      const parentElement = $(this);
      const childElement = parentElement.find(childSelector);
      const cleanParent = parentElement.clone(false);

      cleanParent.find(childSelector).replaceWith(childElement);

      parentElement.replaceWith(cleanParent);
    });
  }

  if ($('#asnp_easy_product_bundle').length) {
    let observerWindowLoad = new MutationObserver(function (mutationsList, observer) {
      observerWindowLoad.disconnect();
      checkIsVariation();
    });
  
    const target = document.querySelector('#asnp_easy_product_bundle'); 
  
    // Стартираме наблюдение на тялото за промени
    observerWindowLoad.observe(target, {
      childList: true,
      subtree: true
    });

    let loadQuickViewTimeout;
    clearTimeout(loadQuickViewTimeout);
    loadQuickViewTimeout = setTimeout(() => {
      const targetNodeQuickView = document.querySelector('#asnp-easy-product-bundle-quick-view .asnp-modal-mask');
    
        // Конфигурация на наблюдателя
        const observerConfig = {
          attributes: true,  // Наблюдавай промени в атрибутите
          attributeFilter: ['style'] // Следи само за промени в стиловете
        };
      
        // Callback функция
        const observerCallback = function (mutationsList, observer) {
          for (const mutation of mutationsList) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
              // console.log($(mutation.target.children).find('.asnp-productInfo-name'));
              const modal = document.querySelector('#asnp-easy-product-bundle-quick-view .asnp-modal-mask');
              let quickViewProductTitle = $(mutation.target.children).find('.asnp-productInfo-name').length > 0 ? $(mutation.target.children).find('.asnp-productInfo-name').first().text()
              : '';
              if (modal && window.getComputedStyle(modal).display !== 'none') {
                $.each($('body').find('.asnp-bundle-item'), function(key, value) {
                  let itemName = $(value).find('.asnp-product-name').text();
                  if (itemName === quickViewProductTitle) {
                    // console.log(bundle_products_ids);
                    // console.log('Prod: ', bundle_products_ids.findIndex(x => x.id === parseInt($(value).attr('data-product-id'), 10)));
                    bundle_products_ids.findIndex(function (elem, i) {
                      let deliveryTimeText = "";
                      let targetId = parseInt($(value).attr('data-product-id'), 10);
                      
                      // console.log(elem.variation_prod_ids.includes(targetId));
                      if (elem.id === targetId || elem.variation_prod_ids.includes(targetId)) {
                        $('.asnp-quickView-image img').before(`
                          <div class="swiper swiper-main">
                            <div class="swiper-wrapper">
                              ${elem.gallery_urls
                                .map(
                                  (url) =>
                                    `<div class="swiper-slide">
                                      <img src="${url}" alt="Image">
                                    </div>`
                                )
                                .join('')}
                            </div>
                            <div class="swiper-nav">
                              <div class="swiper-button-prev"></div>
                              <div class="swiper-button-next"></div>
                            </div>
                          </div>
                          <div class="swiper swiper-thumbs">
                            <div class="swiper-wrapper">
                            ${elem.gallery_urls
                              .map(
                                (url) =>
                                  `<div class="swiper-slide">
                                    <img src="${url}" alt="Image">
                                  </div>`
                              )
                              .join('')}
                              </div>
                            </div>
                        `);
  
                        var swiperThumbs = new Swiper(".swiper-thumbs", {
                          slidesPerView: 1,
                          freeMode: true,
                          watchSlidesProgress: true
                        });
                        var swiper2 = new Swiper(".swiper-main", {
                          navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                          },
                          thumbs: {
                            swiper: swiperThumbs,
                          }
                        });
                        // deliveryTimeText = elem.delivery_time_text;
                        // console.log('Simple: ', elem, deliveryTimeTextFn(elem, deliveryTimeText));
                        const foundVariation = elem.variations.find(variation => variation.id === targetId);
                        if (foundVariation) {
                          deliveryTimeText = foundVariation.delivery_time_text;
                          // console.log('custom-stock: ', );
                          $('.custom-stock').find('.stock span').text(deliveryTimeTextFn(foundVariation, deliveryTimeText));
                        }
                      }
                    });
                  }
                });
              }
            }
          }
        };
      
        // Инициализация на наблюдателя
        const observer2 = new MutationObserver(observerCallback);
        observer2.observe(targetNodeQuickView, observerConfig);
    }, 3000);
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