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

  updatePrevNextPaginateHrefs() {
    let currentUrl = window.location.href;
    let url = new URL(currentUrl);
    let filterContentWrapper = $('.filter-content-wrapper')
    // console.log(url.searchParams);

    // Премахване на параметъра product-page
    if (url.searchParams.has('product-page')) {
      url.searchParams.delete('product-page');
      history.replaceState(null, '', url.toString());
    }

    // Проверяваме дали URL съдържа "page/"
    let isPaged = currentUrl.includes('/page/');

    // Извличаме базовия URL и параметрите
    let baseUrl = currentUrl.split('?')[0];
    let queryParams = currentUrl.includes('?') ? '?' + currentUrl.split('?')[1] : '';

    // Извличаме текущата страница
    let currentPage = 1;
    if (isPaged) {
      let match = baseUrl.match(/\/page\/(\d+)/);
      if (match) {
          currentPage = parseInt(match[1]);
      }
      // Премахваме "/page/X" от базовия URL
      baseUrl = baseUrl.replace(/\/page\/\d+/, '');
    }

    // Генерираме линкове за "Предишна" и "Следваща" страница
    let nextPage = currentPage + 1;
    let prevPage = currentPage - 1;

    let nextPageUrl = baseUrl + '/page/' + nextPage + queryParams;
    let prevPageUrl = currentPage > 1 ? baseUrl + '/page/' + prevPage + queryParams : '#';

    // Актуализираме линковете в DOM
    filterContentWrapper.find('.next-page-link').attr('href', nextPageUrl);
    if (currentPage > 1) {
      filterContentWrapper.find('.prev-page-link').attr('href', prevPageUrl);
    } else {
      filterContentWrapper.find('.prev-page-link').attr('href', '#'); // Ако няма предишна страница
    }
  }

  handleAjaxSuccess(callback) {
    $(document).ajaxSuccess((event, xhr, settings) => {
      if (
        (settings.url.includes('wp-admin/admin-ajax.php') && settings.data.includes('action=filtersFrontend')) ||
        settings.url.includes('wpf_fid=1')
      ) {
        this.updatePrevNextPaginateHrefs();

        if (typeof callback === 'function') {
          callback(event, xhr, settings);
        }
      }
    });
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
      self.handleAjaxSuccess();
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