/* eslint-disable prefer-template */
/* eslint-disable require-jsdoc */
/**
 * @class
 */
import $ from 'jquery';
import Swiper from 'swiper/bundle';
// import 'swiper/swiper-bundle.min.css';

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
      navigation: {
        nextEl: this.$el.find('.swiper-button-next')[0],
        prevEl: this.$el.find('.swiper-button-prev')[0],
      }
    });
  }
}