/* eslint-disable require-jsdoc */
import $ from 'jquery';
import Swiper from 'swiper';
import { Navigation, Thumbs } from 'swiper/modules';
Swiper.use([Navigation, Thumbs]);
/**
 * @class
 */
export default class BundleProducts {
  /**
   * BundleProducts
   * @param {object} el - DOM element.
   */   
  constructor( el ) {
    if (!el) {
      return;
    }

    
    this.triggeringElement = null;
    this.targetNode = $('#asnp-easy-product-bundle-modal');
    this.config = { childList: true, subtree: true };
    this.observer; // Глобален observer

    this.events();
  }
  
  /**
   * Instance events
   */   

  events() {
    this.bundleItemHandler();
    this.quickViewHandler();
  }

  bundleItemHandler() {
    // Callback функция
    const callback = (mutationsList, observer) => {
      for (const mutation of mutationsList) {
        if (mutation.type === 'childList') {
          this.handleModalLogic();
        }
      }
    };

    $('body').on('click', '.asnp-bundle-item', (event) => {
      this.triggeringElement = event.currentTarget;
  
      this.handleModalLogic();
  
      if (!this.observer) {
        this.observer = new MutationObserver(callback);
        this.observer.disconnect();
        this.observer.observe(this.targetNode[0], this.config);
      }
    });
  }

  handleModalLogic() {
    const modal = document.querySelector('#asnp-easy-product-bundle-modal .asnp-modal-mask');
    if (modal && modal.style.display !== 'none') {
      // const productId = parseInt($(triggeringElement).attr('data-product-id'), 10);
      // const productData = bundle_products_ids.find(item => item.id === productId);
      const triggeringName = $(this.triggeringElement).find('.asnp-product-name').text();
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
      if (this.observer) this.observer.disconnect();

      listVariations.each((index, el) => {
        const $el = $(el); // Запазваме текущия елемент като jQuery обект
        const variationName = $el.find('.asnp-post-grid-info h3').text();
        if (variationName === triggeringName) {
          $el.addClass('selected');
        } else {
          $el.removeClass('selected');
        }
      
        // Проверка за вариация чрез индекса
        const matchedVariation = variationIndexMap[variationName];
        if (matchedVariation) {
          let delivery_time_text = matchedVariation.delivery_time_text;
          let delivery_message = this.deliveryTimeTextFn(matchedVariation, delivery_time_text);
      
          $el.attr('data-id', matchedVariation.id);
          $el.find('.asnp-post-grid-info h3').attr('data-variation-option', matchedVariation.variation_option);
          $el.find('.stock span').text(delivery_message);
        }
      
        $el.on('click', () => {
          $(this.triggeringElement).attr('data-product-id', $el.attr('data-id'));
        });
      });

      // Start observer again
      if (this.observer) this.observer.observe(this.targetNode[0], this.config);
    }
  }

  deliveryTimeTextFn(matchedVariation, delivery_time_text) {
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

  checkIsVariation() {
    bundle_products_ids.forEach((product, index) => {
      // Намираме съответния <li> елемент по индекса
      let listItem = $(`#asnp-bundle-item-${index}`);
      listItem.attr('data-product-id', bundle_products_ids[index]['id']);
      // Проверяваме дали типът е "variation"
      if (product.type === "variation") {
          // Добавяме клас на съответния елемент
        listItem.addClass('is-variation');
      } else {
        this.removeAllEventsExceptChild(listItem, '.asnp-info-icon');
      }
    });
  }

  removeAllEventsExceptChild(selector, childSelector) {
    $(selector).each(function () {
      const parentElement = $(this);
      const childElement = parentElement.find(childSelector);
      const cleanParent = parentElement.clone(false);

      cleanParent.find(childSelector).replaceWith(childElement);

      parentElement.replaceWith(cleanParent);
    });
  }

  quickViewHandler() {
    let observerWindowLoad = new MutationObserver((mutationsList, observer) => {
      observerWindowLoad.disconnect();
      this.checkIsVariation();
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
        const observerCallback = (mutationsList, observer) => {
          for (const mutation of mutationsList) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
              // console.log($(mutation.target.children).find('.asnp-productInfo-name'));
              const modal = document.querySelector('#asnp-easy-product-bundle-quick-view .asnp-modal-mask');
              let quickViewProductTitle = $(mutation.target.children).find('.asnp-productInfo-name').length > 0 ? $(mutation.target.children).find('.asnp-productInfo-name').first().text()
              : '';
              if (modal && window.getComputedStyle(modal).display !== 'none') {
                $.each($('body').find('.asnp-bundle-item'), (key, value) => {
                  let itemName = $(value).find('.asnp-product-name').text();
                  if (itemName === quickViewProductTitle) {
                    // console.log(bundle_products_ids);
                    // console.log('Prod: ', bundle_products_ids.findIndex(x => x.id === parseInt($(value).attr('data-product-id'), 10)));
                    bundle_products_ids.findIndex( (elem, i) => {
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
                          $('.custom-stock').find('.stock span').text(this.deliveryTimeTextFn(foundVariation, deliveryTimeText));
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
}