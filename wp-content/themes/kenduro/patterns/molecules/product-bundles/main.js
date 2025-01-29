// /* eslint-disable require-jsdoc */
// import $ from 'jquery';
// import Swiper from 'swiper';
// import { Navigation, Thumbs } from 'swiper/modules';
// Swiper.use([Navigation, Thumbs]);
// /**
//  * @class
//  */
// export default class BundleProducts {
//   /**
//    * BundleProducts
//    * @param {object} el - DOM element.
//    */   
//   constructor( el ) {
//     if (!el) {
//       return;
//     }

//     this.triggeringElement = null;
//     this.targetNode = $('#asnp-easy-product-bundle-modal');

//     this.events();
//   }
  
//   /**
//    * Instance events
//    */   

//   events() {
//     this.onClickHandler();
//   }

//   createBikeModels() {
//     return new Promise(async (resolve, reject) => {
//       try {
//         const response = await axios({
//           method: 'get',
//           url: `${wpApiSettings.rest_url}ss-data/create-compatibility-list/64fffa49372b0c1543d60c35`
//         });
//         console.log('response Bike models: ', response);
//         resolve(response);
//       } catch (error) {
//         console.error('Get Products ERROR: ', error);
//         reject(error);
//       }
//     });
//   }

// }