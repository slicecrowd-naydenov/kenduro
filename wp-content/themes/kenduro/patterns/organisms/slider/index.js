/* eslint-disable prefer-template */
/* eslint-disable require-jsdoc */
/**
 * @class
 */
import $ from 'jquery';
// import Swiper from 'swiper/bundle';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
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
    this.$swiperBlock = this.$el.closest('.swiper-block');
    this.$prevButton = (this.$swiperBlock.length > 0) ? this.$swiperBlock.find('.swiper-button-prev')[0] : this.$el.find('.swiper-button-prev')[0];
    this.$nextButton = (this.$swiperBlock.length > 0) ? this.$swiperBlock.find('.swiper-button-next')[0] : this.$el.find('.swiper-button-next')[0];
    
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
      modules: [Navigation, Pagination, Autoplay],
      autoHeight: true,
      pagination: {
        el: this.$el.find('.swiper-pagination')[0],
        clickable: true
      },
      spaceBetween: this.$el.attr('data-space-between') ? this.$el.attr('data-space-between') : 0,
      slidesPerView: this.$el.attr('data-slider-per-view') ? this.$el.attr('data-slider-per-view') : 'auto',
      navigation: {
        nextEl: this.$nextButton,
        prevEl: this.$prevButton,
      },
      speed: 800,
      autoplay: {
        delay: 5000,
        pauseOnMouseEnter: true,
      },
      loop: true,
      breakpoints: {
        // // when window width is >= 320px
        320: {
          slidesPerView: this.$el.attr('data-slider-per-view-mobile') ? this.$el.attr('data-slider-per-view-mobile') : 'auto',
          // spaceBetween: 15
        },
        // // when window width is >= 575px
        // 575: {
        //   spaceBetween: 130
        // },
        // // when window width is >= 768px
        768: {
          slidesPerView: this.$el.attr('data-slider-per-view-tablet') ? this.$el.attr('data-slider-per-view-tablet') : 'auto'
        },
        992: {
          // spaceBetween: 0,      
          autoHeight: false
        },
        1200: {
          slidesPerView: this.$el.attr('data-slider-per-view') ? this.$el.attr('data-slider-per-view') : 'auto'
        }
      }
    });
  }
}