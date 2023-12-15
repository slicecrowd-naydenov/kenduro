/* eslint-disable require-jsdoc */
//Import
import $ from 'jquery';
// import 'swiper';
const axios = require('axios');

/**
 * @class
 */

export default class ShopFilter {
  /**
   * ShopFilter
   * @param {object} el - DOM element.
   */
  constructor() {
    this.amountMin = $('#amount-min');
    this.amountMax = $('#amount-max');
    this.priceFilter = $('#slider-range');
    this.shopProducts = $('#shop-products');
    this.priceFilterMinValue = Number(this.priceFilter.attr('data-min-price'));
    this.priceFilterMaxValue = Number(this.priceFilter.attr('data-max-price'));
    this.urlParams = {};
    if (window.location.search) {
      const url = decodeURIComponent(window.location.search).replace('?', '');
      const urlArray = url.split('&');
      for (let i = 0; i < urlArray.length; i++) {
        const element = urlArray[i].split('=');
        this.urlParams[element[0]] = element[1];
      }
    }
    this.events();
  }

  toggleFilterValue(filters, value) {
    const filtersArray = filters === '' || !filters ? [] : filters.toLowerCase().split(',');
    if (filtersArray.includes(value)) {
      // remove
      const index = filtersArray.indexOf(value);
      if (index > -1) {
        filtersArray.splice(index, 1);
      }
    } else {
      // add
      filtersArray.push(value);
    }
    
    return filtersArray.join(',');
  }

  events() {
    this.filterClickHandler();
    this.filterPriceChange();  
  }
  
  filterClickHandler() {
    $('#filter').on('click', '.woocommerce-widget-layered-nav-list__item a', (e) => {
      this.shopProducts.addClass('loading');
      e.preventDefault();
      const currentTarget = $(e.currentTarget);
      const wrapper = currentTarget.closest('ul');
      const linkWrapper = currentTarget.parent();
      const filterType = wrapper.prev().attr('data-filter-type');
      const filterValue = currentTarget.attr('data-category');
      const toggleFilterValue = this.toggleFilterValue(this.urlParams[filterType], filterValue);

      if ((toggleFilterValue.length === 0 || filterValue === '') || filterValue === 'all') {
        delete this.urlParams[filterType];
        linkWrapper.siblings().removeClass('chosen woocommerce-widget-layered-nav-list__item--chosen');
      } else {
        this.urlParams[filterType] = toggleFilterValue;
        currentTarget.parents('ul').find('li:first-of-type').removeClass('chosen woocommerce-widget-layered-nav-list__item--chosen');
      }

      if (linkWrapper.hasClass('chosen')) {
        linkWrapper.removeClass('chosen woocommerce-widget-layered-nav-list__item--chosen');
      } else {
        linkWrapper.addClass('chosen woocommerce-widget-layered-nav-list__item--chosen');
      }

      // if (filterValue === 'all') {
      //   delete this.urlParams[filterType];
      //   currentTarget.parent().siblings().removeClass('chosen woocommerce-widget-layered-nav-list__item--chosen')
      // } else {
      //   wrapper.find('li:first-child').removeClass('chosen woocommerce-widget-layered-nav-list__item--chosen')
      // }

      this.filter(this.urlParams);
    });
  }

  filterPriceChange() {
    this.priceFilter.on({
      slidechange: (_event, ui) => { 
        this.shopProducts.addClass('loading');
        this.filterPriceHandler(ui.values[0], ui.values[1]); 
      }
    });
  }

  filterPriceHandler(min, max) {
    const filterType = this.priceFilter.prev().attr('data-filter-type');
    if (min <= this.priceFilterMinValue && max >= this.priceFilterMaxValue) {
      delete this.urlParams[filterType];
    } else {
      this.urlParams[filterType] = `${min }-${ max}`;
    }
    this.filter(this.urlParams);
  }

  filter(params) {
    if (this.controller) {
      this.controller.abort();
    }
    this.controller = new AbortController();
    const newParams = Object.keys(params).map((key) => `${key}=${params[key]}`);
    const newUrl = window.location.origin + window.location.pathname;
    const searchParams = Object.keys(params).length === 0 ? newUrl : '?';
    window.history.replaceState({}, null, searchParams + newParams.join('&'));
    // window.history.pushState({}, document.title, "/" + "my-new-url.html");

    axios({
      method: 'post',
      // eslint-disable-next-line no-undef
      url: `${wpApiSettings.rest_url}ce/filter`,
      data: JSON.stringify(params),
      signal: this.controller.signal,
      headers: {
        'content-type': 'application/json; charset=UTF-8'
      }
    }).then((response) => {
      var responseData = response.data;
      if (axios.isCancel(response)) {
        console.log('isCancel');
      } else {
        this.shopProducts.html(responseData.html);
      }
      // Fade in elements
      // this.fadeInNewProducts();
      this.shopProducts.removeClass('loading');
    }).catch(() => {
      // Fade in elements
      // this.fadeInNewProducts();
      this.shopProducts.removeClass('loading');
      // console.log('error: ', error);
    });
  }

  // fadeInNewProducts() {
  //   var fadeEl = gsap.utils.toArray('.wc-block-grid__product.fade-in');

  //   fadeEl.forEach((el) => {

  //     const delay = el.dataset.delay; // set data-delay="1" to some element for delay 1 second
  //     const isDelay = delay ? delay : 0;

  //     gsap.to(el, { 
  //       autoAlpha: 1,
  //       delay: isDelay,
  //       duration: 0.5,
  //       scrollTrigger: {
  //         trigger: el,
  //         start: 'top bottom-=20%',
  //         end: 'top bottom-=20%'
  //       }
  //     });
  //   });
  // }
}