/* eslint-disable no-undef */
/* eslint-disable require-jsdoc */
import $ from 'jquery';
import axios from 'axios';
import 'select2';

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

    this.body = $('body');
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
    this.checkBikeCookies();
  }

  initSelectMenus() {
    // this.brandDropdown.selectmenu();
    // this.modelDropdown.selectmenu();
    // this.yearDropdown.selectmenu();
    this.brandDropdown.select2({
      placeholder: "Избери",
      // allowClear: true,
      dropdownParent: $('#compatibilities')
    });
    this.modelDropdown.select2({
      placeholder: "Избери",
      // allowClear: true,
      dropdownParent: $('#compatibilities')
    });
    this.yearDropdown.select2({
      placeholder: "Избери",
      // allowClear: true,
      dropdownParent: $('#compatibilities')
    });
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
    this.brandDropdown.on('change', (e) => {
      this.modelDropdown.prop('disabled', true);
      this.yearDropdown.prop('disabled', true);
      this.seeAllParts.addClass('disable');
      // $('#model-dropdown').siblings('.select2').addClass('disable');
      // $('#year-dropdown-button').addClass('disable');
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
          // $('#model-dropdown').siblings('.select2').removeClass('disable');
          this.modelDropdown.prop('disabled', false);
          this.modelDropdown.html(`<option value="">Избери</option>${response.data}`);
          // this.yearDropdown.html('');
          // this.yearDropdown.html('<option value="">Избери</option>');
          // console.log('response.data: ', response.data);
          // this.modelDropdown.trigger('change');
          // this.yearDropdown.trigger('change');
          // this.modelDropdown.selectmenu('refresh');
          // this.yearDropdown.selectmenu('refresh');
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
    });
  }

  onModelChange() {
    this.modelDropdown.on('change', (e) => {
      this.yearDropdown.prop('disabled', true);
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
          // $('#year-dropdown-button').removeClass('disable');
          this.yearDropdown.prop('disabled', false);

          // Реинициализация на Select2, ако е необходимо
          this.yearDropdown.html(`<option value="">Избери</option>${response.data}`);
          // this.yearDropdown.trigger('change'); // Уведомява Select2 за новите опции
          // this.yearDropdown.selectmenu('refresh');
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
    });
  }

  onYearChange() {
    this.yearDropdown.on('change', (e) => {
      const brandVal = this.brandDropdown.val();
      const modelVal = this.modelDropdown.val();
      const yearVal = this.yearDropdown.val();
      const currentDomain = window.location.origin;
      const href = `${currentDomain}/bike-compatibility?wpf_filter_compability=all|${brandVal}-all|${brandVal}-${modelVal}-${yearVal}`;
      // console.log('onYearChange: ', href);

      this.seeAllParts
        .removeClass('disable')
        .attr('href', href);
        
      this.setCookie('brand', brandVal, 3650);
      this.setCookie('model', modelVal, 3650);
      this.setCookie('year', yearVal, 3650);
      this.setCookie('modelOptions', this.modelDropdown.html(), 3650);
      this.setCookie('yearOptions', this.yearDropdown.html(), 3650);
      this.setCookie('bikeCompatibility', `all|${brandVal}-all|${brandVal}-${modelVal}-${yearVal}`, 3650); 
    });
  }

  checkBikeCookies() {
    const brand = this.getCookie('brand');
    const model = this.getCookie('model');
    const modelOptions = this.getCookie('modelOptions');
    const year = this.getCookie('year');
    const yearOptions = this.getCookie('yearOptions');

    if ((brand && model && year) !== null) {  
      this.brandDropdown.val(brand).trigger('change.select2');
      this.modelDropdown.html(modelOptions).val(model).trigger('change.select2');
      this.yearDropdown.html(yearOptions).val(year).trigger('change.select2');
      const currentDomain = window.location.origin;

      const href = `${currentDomain}/bike-compatibility?wpf_filter_compability=all|${brand}-all|${brand}-${model}-${year}`; 
      this.seeAllParts
        .removeClass('disable')
        .attr('href', href);
      $('.show-bike-compatibility').attr('href', href);

      // this.brandDropdown.selectmenu('refresh');
      // this.modelDropdown.selectmenu('refresh');
      // this.yearDropdown.selectmenu('refresh');
    } else {
      if (this.body.hasClass('page-template-bike-compatibility')) {
        this.compatibilityModal.modal('show');
      } 
    }
  }

  bikeModalEvents() {
    this.compatibilityModal.on('show.bs.modal', () => {
      this.body.addClass('overflow-hidden'); 
      this.checkBikeCookies();
    });
    
    this.compatibilityModal.on('hidden.bs.modal', () => {
      this.body.removeClass('overflow-hidden');
      this.checkBikeCookies();
    });
  }
}