/* eslint-disable prefer-template */
/* eslint-disable require-jsdoc */
/**
 * @class
 */
import $ from 'jquery';
import Swiper from 'swiper/bundle';
export default class Slider {
  /**
   * Slider
   * @param {object} el - DOM element.
   */   
  constructor( el ) {
    if (!el) {
      return;
    }

    this.$el = $(el);
    this.swiper;

    this.events();
  }

  /**
   * Instance events
   */   

  events() {
    this.initializeSlider();
  }

  initializeSlider() {
    this.swiper = new Swiper(this.$el[0], {
      pagination: {
        el: this.$el.find('.swiper-pagination')[0],
        clickable: true
      },
    });
  }
}