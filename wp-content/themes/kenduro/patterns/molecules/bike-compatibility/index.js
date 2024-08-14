/* eslint-disable no-undef */
/* eslint-disable require-jsdoc */
import $ from 'jquery';
import axios from 'axios';
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

    this.events();
  }
  
  /**
   * Instance events
   */   

  events() {
    this.onBrandChange();
    this.onModelChange();
    this.onYearChange();
  }

  onBrandChange() {
    this.brandDropdown.on('change', (e) => {
      this.seeAllParts.removeClass('show');
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
          this.modelDropdown.html(`<option value="">Избери модел</option>${response.data}`);
          this.yearDropdown.html('<option value="">Избери година</option>');
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
      
      // $.ajax({
      //   url: ajaxurl, // WordPress global variable for AJAX URL - admin-ajax.php
      //   type: 'POST',
      //   data: {
      //     action: 'get_models_by_brand',
      //     brand: selectedBrand
      //   },
      //   success: (response) => {
      //     this.modelDropdown.html(`<option value="">Избери модел</option>${response}`);
      //     this.yearDropdown.html('<option value="">Избери година</option>');
      //   }
      // });
    });
  }

  onModelChange() {
    this.modelDropdown.on('change', (e) => {
      this.seeAllParts.removeClass('show');
      // var selectedModel = $(this).val();
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
          this.yearDropdown.html(`<option value="">Избери година</option>${response.data}`);
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
    
      // $.ajax({
      //   url: ajaxurl,
      //   type: 'POST',
      //   data: {
      //     action: 'get_years_by_model',
      //     model: selectedModel
      //   },
      //   success: (response) => {
      //     this.yearDropdown.html(`<option value="">Избери година</option>${response}`);
      //   }
      // });
    });
  }

  onYearChange() {
    this.yearDropdown.on('change', () => {
      const brandVal = this.brandDropdown.val();
      const modelVal = this.modelDropdown.val();
      const yearVal = this.yearDropdown.val();
      const href = `http://kenduro.test/shop?wpf_filter_compability=${brandVal}-${modelVal}-${yearVal}`;
      this.seeAllParts
        .addClass('show')
        .attr('href', href);
    });
  }
}