/* eslint-disable require-jsdoc */
import $ from 'jquery';
import axios from 'axios';
/**
 * @class
 */
export default class CreateProducts {
  /**
   * CreateProducts
   * @param {object} el - DOM element.
   */   
  constructor( el ) {
    if (!el) {
      return;
    }

    this.createProductsBtn = $('#createProducts');
    this.updateProductBtn = $('#updateProduct');
    this.updateProductVariationBtn = $('#updateProductVariation');
    this.productFieldsBtn = $('#productFields');
    this.filterFieldsBtn = $('#filterFields');
    this.filterValuesBtn = $('#filterValues');
    this.ssData;

    this.events();
  }
  
  /**
   * Instance events
   */   

  events() {
    this.onClickHandler();
  }

  createProduct() {
    return new Promise(async (resolve, reject) => {
      try {
        const response = await axios({
          method: 'get',
          url: `${wpApiSettings.rest_url}ss-data/get-products/`+$(this.createProductsBtn).attr('data-products-id')
        });
        console.log('response Products: ', response);
        resolve(response);
      } catch (error) {
        console.error('Get Products ERROR: ', error);
        reject(error);
      }
    });
  }

  onClickHandler() {
    this.createProductsBtn.on('click', (e) => {
      e.preventDefault();
      this.createProduct();
      $.ajax({
        type: 'POST',
        url: ajaxurl, // This is WordPress AJAX URL
        data: {
          action: 'clear_woocommerce_transients' // Потвърдете съответния хук
        },
        success: function(response) {
          alert('Транзиентите са изтрити успешно.');
        }
      });
    });
  }
}