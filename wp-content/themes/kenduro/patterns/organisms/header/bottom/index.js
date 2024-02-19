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
    if ($(window).innerWidth() < 992) {
      this.menuToggle();
      this.closeMenu();
      this.showSubMenu();
      this.closeSubMenu();
    } else {
      this.menuToggleDesktop();
    }
  }

  menuToggleDesktop() {
    $('.cat-name.menu-item-has-children').on('mouseenter', function() {
      $('#primary').addClass('showed-menu');
    });

    $('.cat-name.menu-item-has-children').on('mouseleave', function() {
      $('#primary').removeClass('showed-menu');
    });
  }

  menuToggle() {
    this.$el.on('click', () => {
      $('body').toggleClass('fixed-position blur-content');
    });
  }

  closeMenu() {
    $('.mobile-nav__close').on('click', () => {
      this.$el.trigger('click');
    });
  }

  showSubMenu() {
    $('.cat-name.menu-item-has-children').on('click', function() {
      if (!$('.primary-navigation').hasClass('sub-menu-showed')) {
        const catName = $(this).find('> a').text();
        $(this).find('.sub-menu').addClass('visible-menu');
        $('.primary-navigation').addClass('sub-menu-showed');
        $('.sub-menu-head-mobile__cat').text(catName);
        $('.sub-menu-head-mobile__cat').attr('data-cat', catName);
      }
    });
    
    $('.sub-menu__item').on('click', function() {
      // if ($(this).find('> a').siblings('.sub-sub-menu').length > 0) {
      //   e.preventDefault();
      //   e.stopPropagation();
      // }
      const catName = $(this).find('> a').text();
      $(this).find('> a').siblings('.sub-sub-menu').addClass('visible-menu');
      $('.primary-navigation').addClass('sub-sub-menu-showed');
      $('.sub-menu-head-mobile__cat').text(catName);
    });
  }

  closeSubMenu() {
    $('.sub-menu-head-mobile__close').on('click', function() {
      if ($('.primary-navigation').hasClass('sub-sub-menu-showed')) {
        $('.primary-navigation').removeClass('sub-sub-menu-showed'); 
        $('.sub-sub-menu').removeClass('visible-menu');
        $('.sub-menu-head-mobile__cat').text($('.sub-menu-head-mobile__cat').attr('data-cat'));
      } else {
        $('.primary-navigation').removeClass('sub-menu-showed'); 
        $('.sub-menu').removeClass('visible-menu');
      }
    });
    // $('.sub-menu-head-mobile__close').on('click', function() {
    //   $(this).parents('.sub-menu').removeClass('visible-menu');
    // });
  }
  
}