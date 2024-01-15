/* eslint-disable prefer-template */
/* eslint-disable require-jsdoc */
/**
 * @class
 */
import $ from 'jquery';
// import 'swiper/swiper-bundle.min.css';

export default class MobileNavigation {
  /**
   * Slider
   * @param {object} el - DOM element.
   */   
  constructor( el ) {
    if (!el) {
      return;
    }

    this.$el = $(el);
    this.primaryNav = $('.primary-navigation');

    
    this.events();
  }

  /**
   * Instance events
   */   

  events() {
    if ($(window).innerWidth() < 768) {
      this.menuToggle();
      this.closeMenu();
      this.showSubMenu();
      this.closeSubMenu();
    }
  }

  menuToggle() {
    this.$el.on('click', () => {
      // this.primaryNav.toggleClass('opened');
    });
  }

  closeMenu() {
    $('.mobile-nav__close').on('click', () => {
      this.$el.trigger('click');
    });
  }

  showSubMenu() {
    $('.cat-name').on('click', function() {
      $(this).siblings('.sub-menu').toggleClass('visible-menu');
    });

    $('.sub-menu__item-link').on('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).siblings('.sub-sub-menu').toggleClass('visible-menu');
    });
  }

  closeSubMenu() {
    $('.sub-menu-head-mobile__close').on('click', function() {
      $(this).parents('.sub-menu').removeClass('visible-menu');
    });

    $('.sub-sub-menu-head-mobile__close').on('click', function() {
      $(this).parents('.sub-sub-menu').removeClass('visible-menu');
    });
  }
  
}