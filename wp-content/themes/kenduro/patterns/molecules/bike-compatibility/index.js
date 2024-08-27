/* eslint-disable no-undef */
/* eslint-disable require-jsdoc */
import $ from 'jquery';
import axios from 'axios';
import 'jquery-ui/ui/widgets/selectmenu';

/**
 * @class
 */
export default class Compatibilities {
  /**
   * Compatibilities
   * @param {object} el - DOM element.
   */   
  constructor( el ) {
    if (!el) {
      return;
    }

    this.brandDropdown = $('#brand-dropdown');
    this.modelDropdown = $('#model-dropdown');
    this.yearDropdown = $('#year-dropdown');
    this.seeAllParts = $('#see-all-parts');
    this.compatibilityModal = jQuery('#compatibilityModal');

    this.events();
  }
  
  /**
   * Instance events
   */   

  events() {
    this.initSelectMenus();
    this.bikeModalEvents();
    this.onBrandChange();
    this.onModelChange();
    this.onYearChange();
  }

  initSelectMenus() {
    this.brandDropdown.selectmenu();
    this.modelDropdown.selectmenu();
    this.yearDropdown.selectmenu();
  }

  setCookie(name, value, days) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = `expires=${date.toUTCString()}`;
    document.cookie = `${name}=${value};${expires};path=/`;
  }

  getCookie(name) {
    const nameEQ = `${name}=`;
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) === ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(nameEQ) === 0) {
        return c.substring(nameEQ.length, c.length);
      }
    }
    return null;
  }

  onBrandChange() {
    this.brandDropdown.selectmenu({
      open: function() {
        $('.ui-menu-item-wrapper').removeClass('selected');
        $('.ui-state-active').addClass('selected');
      },
      change: (e) => {
        this.seeAllParts.addClass('disable');
        $('#model-dropdown-button').addClass('disable');
        $('#year-dropdown-button').addClass('disable');
        var selectedBrand = $(e.target).val();


        axios({
          method: 'post',
          url: ajaxurl,
          data: new URLSearchParams({
            action: 'get_models_by_brand',
            brand: selectedBrand
          })
        })
          .then((response) => {
            $('#model-dropdown-button').removeClass('disable');
            this.modelDropdown.html(`<option value="">Избери</option>${response.data}`);
            this.yearDropdown.html('<option value="">Избери</option>');
            this.modelDropdown.selectmenu('refresh');
            this.yearDropdown.selectmenu('refresh');
          })
          .catch((error) => {
            if (error.response) {
              // The request was made and the server responded with a status code
              // that falls out of the range of 2xx
              console.log(error.response.data);
              console.log(error.response.status);
              console.log(error.response.headers);
            } else if (error.request) {
              // The request was made but no response was received
              console.log(error.request);
            } else {
              // Something happened in setting up the request that triggered an Error
              console.log('Error', error.message);
            }
            console.log(error.config);
          });
      }
    });
  }

  onModelChange() {
    this.modelDropdown.selectmenu({
      open: function() {
        $('.ui-menu-item-wrapper').removeClass('selected');
        $('.ui-state-active').addClass('selected');
      },
      change: (e) => {
        $('#year-dropdown-button').addClass('disable');
        this.seeAllParts.addClass('disable');
        var selectedModel = $(e.target).val();

        axios({
          method: 'post',
          url: ajaxurl,
          data: new URLSearchParams({
            action: 'get_years_by_model',
            model: selectedModel
          })
        })
          .then((response) => {
            $('#year-dropdown-button').removeClass('disable');
            this.yearDropdown.html(`<option value="">Избери</option>${response.data}`);
            this.yearDropdown.selectmenu('refresh');
          })
          .catch((error) => {
            if (error.response) {
              // The request was made and the server responded with a status code
              // that falls out of the range of 2xx
              console.log(error.response.data);
              console.log(error.response.status);
              console.log(error.response.headers);
            } else if (error.request) {
              // The request was made but no response was received
              console.log(error.request);
            } else {
              // Something happened in setting up the request that triggered an Error
              console.log('Error', error.message);
            }
            console.log(error.config);
          });
      }
    });
  }

  onYearChange() {
    this.yearDropdown.selectmenu({
      open: function() {
        $('.ui-menu-item-wrapper').removeClass('selected');
        $('.ui-state-active').addClass('selected');
      },
      change: () => {
        const brandVal = this.brandDropdown.val();
        const modelVal = this.modelDropdown.val();
        const yearVal = this.yearDropdown.val();
        const href = `http://kenduro.test/shop?wpf_filter_compability=${brandVal}-${modelVal}-${yearVal}`;
        this.seeAllParts
          .removeClass('disable')
          .attr('href', href);

        this.setCookie('brand', brandVal, 3650);
        this.setCookie('model', modelVal, 3650);
        this.setCookie('year', yearVal, 3650);
        this.setCookie('modelOptions', this.modelDropdown.html(), 3650);
        this.setCookie('yearOptions', this.yearDropdown.html(), 3650);
      }
    });
  }

  checkBikeCookies() {
    const brand = this.getCookie('brand');
    const model = this.getCookie('model');
    const modelOptions = this.getCookie('modelOptions');
    const year = this.getCookie('year');
    const yearOptions = this.getCookie('yearOptions');

    if ((brand && model && year) !== null) {  
      this.brandDropdown.val(brand);
      this.modelDropdown.html(modelOptions).val(model);
      this.yearDropdown.html(yearOptions).val(year);
      const href = `http://kenduro.test/shop?wpf_filter_compability=${brand}-${model}-${year}`;
      this.seeAllParts
        .removeClass('disable')
        .attr('href', href);

      this.brandDropdown.selectmenu('refresh');
      this.modelDropdown.selectmenu('refresh');
      this.yearDropdown.selectmenu('refresh');
    }
  }

  bikeModalEvents() {
    this.compatibilityModal.on('show.bs.modal', () => {
      this.checkBikeCookies();
    });

    this.compatibilityModal.on('hidden.bs.modal', () => {
      this.checkBikeCookies();
    });
  }
}