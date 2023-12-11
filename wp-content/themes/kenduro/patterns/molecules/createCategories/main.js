/* eslint-disable no-undef */
/* eslint-disable prefer-template */
/* eslint-disable require-jsdoc */
import $ from "jquery";
// import { request, API_URL } from '../../organisms/ApiRequest';
// import WooCommerce from '../wooRestApi';
import axios from "axios";

/**
 * @class
 */
export default class CreateCategories {
  /**
   * CreateCategories
   * @param {object} el - DOM element.
   */
  constructor(el) {
    if (!el) {
      return;
    }

    this.createMainCategoriesBtn = $("#createCategories");
    this.createChildCategoriesBtn = $("#createChildCategories");
    this.createSubChildCategoriesBtn = $("#createSubChildCategories");
    this.createFiltersBtn = $("#createFilters");

    this.events();
    // apiFetch( { path: '/wp/v2/posts' } ).then( ( posts ) => {
    //   console.log( posts );
    // } );
  }

  /**
   * Instance events
   */

  events() {
    this.onClickHandler();
    // this.handleHover();
  }

  createMainCategories() {
    return new Promise(async (resolve, reject) => {
      try {
        const response = await axios({
          method: "get",
          url: `${wpApiSettings.rest_url}ss-data/get-categories/64fffd472342af43b5f7a511`,
          headers: {
            'X-WP-Nonce': `${wpApiSettings.nonce}`, 
          }
        });
        console.log("response Main: ", response);
        resolve(response);
      } catch (error) {
        console.error("Get Categories ERROR: ", error);
        reject(error);
      }
    });
  }

  createChildCategories() {
    return new Promise(async (resolve, reject) => {
      try {
        const response = await axios({
          method: "get",
          url: `${wpApiSettings.rest_url}ss-data/get-categories/64fffd8181170b2bfd847cf7`,
          headers: {
            'X-WP-Nonce': `${wpApiSettings.nonce}`, 
          }
        });
        console.log("response Child: ", response);
        resolve(response);
      } catch (error) {
        console.error("Get Child Categories ERROR: ", error);
        reject(error);
      }
    });
  }

  createSubChildCategories() {
    return new Promise(async (resolve, reject) => {
      try {
        const response = await axios({
          method: "get",
          url: `${wpApiSettings.rest_url}ss-data/get-categories/64fffd8d547c1bc2b52021d6`,
          headers: {
            'X-WP-Nonce': `${wpApiSettings.nonce}`, 
          }
        });
        console.log("response Sub Child: ", response);
        resolve(response);
      } catch (error) {
        console.error("Get Sub Child Categories ERROR: ", error);
        reject(error);
      }
    });
  }

  createFilters() {
    return new Promise(async (resolve, reject) => {
      try {
        const response = await axios({
          method: "get",
          url: `${wpApiSettings.rest_url}ss-data/get-filters/6500569fa5f9be59c811b365`,
          headers: {
            'X-WP-Nonce': `${wpApiSettings.nonce}`, 
          }
          // url: `${wpApiSettings.rest_url}ss-data/get-products/6500569fa5f9be59c811b365/`, 
        });
        console.log("response Filtersss: ", response);
        resolve(response);
      } catch (error) {
        console.error("Get Filters ERROR: ", error);
        reject(error);
      }
    });
  }

  async onClickHandler() {
    this.createMainCategoriesBtn.on("click", async (e) => {
      e.preventDefault();
      try {
        await this.createMainCategories();
        await this.createChildCategories();
        await this.createSubChildCategories();
        console.log("All categories created successfully");
      } catch (error) {
        console.error("Error creating categories:", error);
      }
    });

    this.createFiltersBtn.on("click", async (e) => {
      e.preventDefault();
      try {
        await this.createFilters();
        console.log("All Filters");
      } catch (error) {
        console.error("Error creating Filters:", error);
      }
    });
  }

  //   <script>
  //   document.addEventListener('DOMContentLoaded', async function () {
  //     try {
  //       await createMainCategories();
  //       await createChildCategories();
  //       await createSubChildCategories();
  //       console.log('All categories created successfully');
  //     } catch (error) {
  //       console.error('Error creating categories:', error);
  //     }
  //   });
  // </script>

  // onClickHandler() {
  //   this.createMainCategoriesBtn.on('click', (e) => {
  //     e.preventDefault();
  //     // this.createMainCategories();
  //     Promise.all([
  //       this.createMainCategories(),
  //       this.createChildCategories(),
  //       this.createSubChildCategories(),
  //     ])
  //       .then((results) => {
  //         console.log('All categories created successfully:', results);
  //       })
  //       .catch((error) => {
  //         console.error('Error creating categories:', error);
  //       });
  //   });
  // }
}
