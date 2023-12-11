/* eslint-disable require-jsdoc */
//Import
import $ from 'jquery';
import 'jquery-ui/ui/widgets/slider';


/**
 * @class
 */

export default class FilterPrice {
  /**
   * FilterPrice
   * @param {object} el - DOM element.
   */
  constructor(el) {
    if (!el) {
      return;
    }
    this.el = $(el);
    this.amountMin = $('#amount-min');
    this.amountMax = $('#amount-max');
    this.values = this.el.attr('data-all-prices').split(', ').map(Number).sort((a, b) => { 
      return a - b; 
    });
    this.urlParams = {};
    this.priceArr = {};
    if (window.location.search) {
      const url = decodeURIComponent(window.location.search).replace('?', '');
      const urlArray = url.split('&');
      for (let i = 0; i < urlArray.length; i++) {
        const element = urlArray[i].split('=');
        this.urlParams[element[0]] = element[1];
      }
    }
    
    if (this.urlParams['filter_price']) {
      this.priceArr = this.urlParams['filter_price'].split('-');
    }

    this.minPrice = Number(this.el.attr('data-min-price'));
    this.maxPrice = Number(this.el.attr('data-max-price'));
    this.priceArrMin = this.priceArr[0] ? Number(this.priceArr[0]) : Number(this.el.attr('data-min-price'));
    this.priceArrMax = this.priceArr[1] ? Number(this.priceArr[1]) : Number(this.el.attr('data-max-price'));

    this.events();
  }

  events() {
    this.initSlider();
    // this.amountMinHandle();
    // this.amountMaxHandle(); 
  }


  initSlider() {
    this.el.slider({
      range: true,
      min: this.minPrice,
      max: this.maxPrice,
      // stepValues: this.values,
      step: 0.01,
      animation: 'slow',
      values: [this.priceArrMin, this.priceArrMax],
      slide: (event, ui) => {
        // let valueMin = this.findNearest(ui.values[0]);
        // let valueMax = this.findNearest(ui.values[1]);
        // this.amountMin.val(valueMin);
        // this.amountMax.val(valueMax);
        // console.log(ui);
        this.amountMin.val(ui.values[0]);
        this.amountMax.val(ui.values[1]);
      },
      change: () => {
      },
      stop: () => {
        this.amountMin.trigger('change');
        this.amountMax.trigger('change');           
      },
    });

    this.amountMin.val(this.priceArrMin);
    this.amountMax.val(this.priceArrMax);
  }

  amountMinHandle() {
    this.amountMin.on('input', () => {
      console.log(this.amountMin.val());
      // use parseFloat, parseInt or Number 
      this.amountMin.val(this.amountMin.val().replace(/[^0-9.]/g, ''));
      
      const minVal = parseFloat(this.amountMin.val());
      const maxVal = parseFloat(this.amountMax.val());

      if (this.amountMin.val() === '' || minVal < this.minPrice) {
        this.amountMin.val(this.minPrice);
        this.el.slider('values', 0, this.minPrice);
      } else if (minVal < maxVal) {
        this.el.slider('values', 0, minVal);
      } else {
        this.amountMin.val(maxVal);
        this.el.slider('values', 0, maxVal);
      } 
    });
  }

  amountMaxHandle() {
    this.amountMax.on('input', () => {
      this.amountMax.val(this.amountMax.val().replace(/[^0-9.]/g, ''));
      // console.log(this.amountMax.val(this.amountMax.val().replace(/[^0-9.]/g, '')););

      const minVal = parseFloat(this.amountMin.val());
      const maxVal = parseFloat(this.amountMax.val());
      if (maxVal > this.maxPrice) {
        this.amountMax.val(this.maxPrice);
        this.el.slider('values', 1, this.maxPrice);
      } else if (maxVal > minVal) {
        this.el.slider('values', 1, maxVal);
      } else {
        this.amountMax.val(minVal);
        this.el.slider('values', 1, minVal);
      }
    });
  }
}