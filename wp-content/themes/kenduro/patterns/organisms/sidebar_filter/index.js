/* eslint-disable prefer-template */
/* eslint-disable require-jsdoc */
/**
 * @class
 */
import $ from 'jquery';

export default class SidebarFilter {
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

  showClearButton(url) {
    var params = new URLSearchParams(url);
    if (params.size >= 2) {
      $('.wpfFilterButtons').fadeIn(150);
    } else {
      $('.wpfFilterButtons').fadeOut(150);
    }     
  }

  handleAjaxSuccess(callback) {
    $(document).ajaxSuccess((event, xhr, settings) => {
      if (settings.url.includes('wpf_fid') || settings.url.includes('orderby')) {
        if (typeof callback === 'function') {
          callback(event, xhr, settings);
        }
      }
    });
  }

  hideSkeleton() {
    $('#ajax-products').css('min-height', '360px');
    
    if ($('#ajax-products').find('.products li').length < 16) {
      $('#load-more-products').addClass('hide');
    }

    $('#skeleton').addClass('hide');
  }

  initializeSlider() {
    $('.filter-sidebar').find('.active').each(function() {
      const activeCat = $( this ).text();
  
      $(this).closest('.product-cat-filter').next().text(activeCat);
    });
  
    $('.cat-head').on('click', function() {
      $(this).toggleClass('active-cat'); 
      $(this).next().slideToggle();
    });
    
    // if ($('.wpfMainWrapper')[0].clientHeight === 0) {
    //   $('.cat-head.filters, .wpfClearButton').hide();
    // }

    const allCats = $('.all-cats');
    $('.product-cat-filter').each(function() {
      if ($(this).children().length === 0) {
        $(this).prev().hide();
      }
    });

    allCats.each(function(index) {
      allCats.addClass('active');
      if (index === 0) {
        if (allCats.nextAll().hasClass('active')) {
          allCats.removeClass('active');
        }
      } else if (index === 1) {
        $('p.active-cat:nth-of-type(1)').trigger('click');
        allCats.removeClass('active');
        if (!$(this).siblings().hasClass('active')) {
          $(this).addClass('active');
        }
        $(this).find('a').attr('href', $($('li.active')[0]).find('a').attr('href'));
      } else if (index === 2) {
        $('p.active-cat:nth-of-type(1)').trigger('click');
        $('p.active-cat:nth-of-type(2)').trigger('click');
        allCats.removeClass('active');
        if (!$(this).siblings().hasClass('active')) {
          $(this).addClass('active');
        }
        $(this).find('a').attr('href', $($('li.active')[1]).find('a').attr('href'));
      }
    });

    var getFIlterURL = window.location.search;
    this.showClearButton(getFIlterURL);

    $('.filter-sidebar').find('.wpfMainWrapper').on('click', () => {
      this.handleAjaxSuccess(() => {
        this.hideSkeleton();
        var getFIlterURL = $('.filter-sidebar').find('.wpfMainWrapper').attr('data-hide-url');
        // eslint-disable-next-line no-undefined
        if (getFIlterURL !== undefined) {
          this.showClearButton(getFIlterURL);
        }
      });
    });
    
    const self = this;
    $('.dropdown-menu-sort').on('click', '.wpfLiLabel', function() {
      const selectedSortType = $(this).find('.wpfFilterTaxNameWrapper').text();
      $('.sort-by-title').text(selectedSortType);
      self.handleAjaxSuccess(() => {
        self.hideSkeleton();
      });
    });

    if ($(window).innerWidth() < 1200) {
      $('.wpfLiLabel, .wpfClearButton').on('click', function () {
        setTimeout(() => {
          $(this).closest('.modal-content').find('.close').trigger('click');
        }, 1000);
      });
    }
  }
}