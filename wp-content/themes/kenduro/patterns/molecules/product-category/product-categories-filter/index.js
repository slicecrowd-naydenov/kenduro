/* eslint-disable require-jsdoc */
import $ from 'jquery';
/**
 * @class
 */
export default class ProductCategoryFilter {
  /**
   * CreateProducts
   * @param {object} el - DOM element.
   */   
  constructor( el ) {
    if (!el) {
      return;
    }

    this.child_cat = $('#child_cat');
    this.yith_filter = $('.yith-wcan-filter');
    this.level_1_item = this.child_cat.find('.filter-item.level-0 .filter-item.level-1 .filter-item');

    this.events();
  }
  
  /**
   * Instance events
   */   

  events() {
    this.changeCategoryLabelView();
    this.filterDropdown();
    this.clickOutsideHandler();
  }

  changeCategoryLabelView() {
    if (this.level_1_item.hasClass('active')) {
      this.level_1_item.hide();
      this.level_1_item.parents('.filter-item.level-1').find('label').show();
    }
  }

  filterDropdown() {
    this.yith_filter.find('.filter-title').on('click', function() {
      var filterContent = $(this).siblings('.filter-content');
      $('.filter-title').removeClass('active');
      $('.filter-content').slideUp(200);
      if (!filterContent.is(':visible')) {
        $(this).toggleClass('active');
        filterContent.slideToggle(200);
      }
    });
  }

  clickOutsideHandler() {
    console.log('ima filter');
    $(window).on('click', function(e) {
      if (!$(e.target).is('.filter-title')) {
        $('.filter-content').slideUp();
      }
    });
  }
}