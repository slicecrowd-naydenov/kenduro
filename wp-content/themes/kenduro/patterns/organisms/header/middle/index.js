/* eslint-disable require-jsdoc */
import $ from 'jquery';
/**
 * @class
 */
export default class MiddleHeader {
  /**
   * MiddleHeader
   * @param {object} el - DOM element.
   */   
  constructor( el ) {
    if (!el) {
      return;
    }

    this.search = $(el).find('.search');

    this.events();
  }
  
  /**
   * Instance events
   */   

  events() {
    this.onClickHandler();
  }

  onClickHandler() {
    this.search.on('click' , function(e) {
      e.preventDefault();
      e.stopPropagation();
      $('.yith-ajaxsearchform-container').fadeToggle();
    });
  }
}