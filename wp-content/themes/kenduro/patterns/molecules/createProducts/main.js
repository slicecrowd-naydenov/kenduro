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
    // this.handleHover();
  }

  createProduct() {
    return new Promise(async (resolve, reject) => {
      try {
        const response = await axios({
          method: 'get',
          url: `${wpApiSettings.rest_url}ss-data/get-products/64e75a98b9212caa8746ef1b/`
        });
        console.log('response Products: ', response);
        resolve(response);
      } catch (error) {
        console.error('Get Products ERROR: ', error);
        reject(error);
      }
    });
  }

  updateProduct() {
    return new Promise(async (resolve, reject) => {
      try {
        const response = await axios({
          method: 'get',
          url: `${wpApiSettings.rest_url}ss-data/get-products/64fffa49372b0c1543d60c35/64fffa49372b0c1543d60c3e`
        });
        console.log('response Products: ', response);
        resolve(response);
      } catch (error) {
        console.error('Get Products ERROR: ', error);
        reject(error);
      }
    });
  }

  updateVariationProduct() {
    return new Promise(async (resolve, reject) => {
      try {
        const response = await axios({
          method: 'get',
          url: `${wpApiSettings.rest_url}ss-data/get-products/651f9c5af5b14e0d99b3e73c/652797ed93d2f48642ca6d10`
        });
        console.log('response Products: ', response);
        resolve(response);
      } catch (error) {
        console.error('Get Products ERROR: ', error);
        reject(error);
      }
    });
  }

  productFields() {
    return new Promise(async (resolve, reject) => {
      try {
        const response = await axios({
          method: 'get',
          url: `${wpApiSettings.rest_url}ss-data/get-column-fields/64fffa49372b0c1543d60c35`
        });
        console.log('response Products fields: ', response);
        resolve(response);
      } catch (error) {
        console.error('Get Products fields ERROR: ', error);
        reject(error);
      }
    });
  }

  filterFields() {
    return new Promise(async (resolve, reject) => {
      try {
        const response = await axios({
          method: 'get',
          url: `${wpApiSettings.rest_url}ss-data/get-column-fields/6500569fa5f9be59c811b365`
        });
        console.log('response Products fields: ', response);
        resolve(response);
      } catch (error) {
        console.error('Get Products fields ERROR: ', error);
        reject(error);
      }
    });
  }

  filterValues() {
    return new Promise(async (resolve, reject) => { 
      try {
        const response = await axios({
          method: 'get',
          url: `${wpApiSettings.rest_url}ss-data/get-column-fields/6500603b38119da8144a91b2`
        });
        console.log('response Products fields: ', response);
        resolve(response);
      } catch (error) {
        console.error('Get Products fields ERROR: ', error);
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
        url: ajaxurl, // Това е WordPress AJAX URL
        data: {
            action: 'clear_woocommerce_transients' // Потвърдете съответния хук
        },
        success: function(response) {
            alert('Транзиентите са изтрити успешно.');
        }
      });
    });

    this.productFieldsBtn.on('click', (e) => {
      e.preventDefault();
      this.productFields();
    });

    this.filterFieldsBtn.on('click', (e) => {
      e.preventDefault();
      this.filterFields();
    });

    this.filterValuesBtn.on('click', (e) => {
      e.preventDefault();
      this.filterValues();
    });
    
    this.updateProductBtn.on('click', (e) => {
      e.preventDefault();
      this.updateProduct();
    });

    this.updateProductVariationBtn.on('click', (e) => {
      e.preventDefault();
      this.updateVariationProduct();
    });
  }
}