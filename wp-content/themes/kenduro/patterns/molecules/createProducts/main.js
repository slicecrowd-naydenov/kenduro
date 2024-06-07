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
    this.updateProductsBtn = $('#updateProducts');
    this.createBrandsBtn = $('#createBrands');
    this.updateProductBtn = $('#updateProduct');
    this.updateProductVariationBtn = $('#updateProductVariation');
    this.productFieldsBtn = $('#productFields');
    this.filterFieldsBtn = $('#filterFields');
    this.filterValuesBtn = $('#filterValues');
    this.ssData;

    this.$total = null;
    this.$max_requests = 3;
    this.$err_count = 0;

    this.events();
  }
  
  /**
   * Instance events
   */   

  events() {
    this.onClickHandler();
  }

  // createProduct() {
  //   return new Promise(async (resolve, reject) => {
  //     try {
  //       const response = await axios({
  //         method: 'get',
  //         url: `${wpApiSettings.rest_url}ss-data/get-products/`+$(this.createProductsBtn).attr('data-products-id')
  //       });
  //       console.log('response Products: ', response);
  //       resolve(response);
  //     } catch (error) {
  //       console.error('Get Products ERROR: ', error);
  //       reject(error);
  //     }
  //   });
  // }

  updateProduct($limit = 2, $offset = 0, $total = null) {
    return new Promise(async (resolve, reject) => {
      try {
        const response = await axios({
          method: 'get',
          url: `${wpApiSettings.rest_url}ss-data/update-products/`+$limit+'/'+$offset
        });
        
        this.$err_count = 0;
        $total = response.data.total_items; // response.data.total
        $offset += $limit;
        // console.log('offset: ', $offset);
        // console.log('total: ', $total);
        // console.log('res: ', response);
        if ($offset >= $total) {
          return; // All products get
        }
        
        this.updateProduct($limit, $offset, $total);

        resolve(response);
      } catch (error) {
        console.error('Get Products ERROR: ', error);
        this.$err_count += 1;

        if (this.$err_count >= this.$max_requests) {
          return; // Stop
        }

        this.updateProduct($limit, $offset, $total); 

        reject(error);
      }
    });
  }
  

  // makeRequest($limit, $offset = 0, $total = null) {
  //   return new Promise(async (resolve, reject) => {
  //     try {
  //       const response = await axios({
  //         method: 'get',
  //         url: `${wpApiSettings.rest_url}ss-data/update-products/`+$(this.updateProductsBtn).attr('data-products-id')+'/update'
  //       });
  //       console.log('response Products: ', response);
  //       resolve(response);
  //     } catch (error) {
  //       console.error('Get Products ERROR: ', error);
  //       reject(error);
  //     }
  //   });
  // }

  createBrands() {
    return new Promise(async (resolve, reject) => {
      try {
        const response = await axios({
          method: 'get',
          url: `${wpApiSettings.rest_url}ss-data/get-brands/`+$(this.createBrandsBtn).attr('data-brands-id')
        });
        console.log('response Brands: ', response);
        resolve(response);
      } catch (error) {
        console.error('Get Products ERROR: ', error);
        reject(error);
      }
    });
  }

  onClickHandler() {
    // this.createProductsBtn.on('click', (e) => {
    //   e.preventDefault();
    //   this.createProduct();
    //   $.ajax({
    //     type: 'POST',
    //     url: ajaxurl, // This is WordPress AJAX URL
    //     data: {
    //       action: 'clear_woocommerce_transients' // Потвърдете съответния хук
    //     },
    //     success: function(response) {
    //       alert('Транзиентите са изтрити успешно.');
    //     }
    //   });
    // });

    this.updateProductsBtn.on('click', (e) => {
      e.preventDefault();
      var offset = this.updateProductsBtn.attr('data-offset');
      var limit = this.updateProductsBtn.attr('data-limit');

      this.updateProduct(parseInt(limit), parseInt(offset));
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

    this.createBrandsBtn.on('click', (e) => {
      e.preventDefault();
      this.createBrands();
      // $.ajax({
      //   type: 'POST',
      //   url: ajaxurl, // This is WordPress AJAX URL
      //   data: {
      //     action: 'clear_woocommerce_transients' // Потвърдете съответния хук
      //   },
      //   success: function(response) {
      //     alert('Транзиентите са изтрити успешно.');
      //   }
      // });
    });
  }
}