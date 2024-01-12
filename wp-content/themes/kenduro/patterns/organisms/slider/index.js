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
      autoHeight: true,
      pagination: {
        el: this.$el.find('.swiper-pagination')[0],
        clickable: true
      },
      navigation: {
        nextEl: this.$el.find('.swiper-button-next')[0],
        prevEl: this.$el.find('.swiper-button-prev')[0],
      },
      breakpoints: {
        // when window width is >= 320px
        320: {
          spaceBetween: 15
        },
        // when window width is >= 575px
        575: {
          spaceBetween: 130
        },
        // when window width is >= 768px
        768: {
          spaceBetween: 30,      
          autoHeight: false
        }
      }
    });
  }
}