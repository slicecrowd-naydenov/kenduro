import CreateProducts from './createProducts/main';
import CreateCategories from './createCategories/main';
// import FilterPrice from './filter-price';
import SearchField from './blog/main';
import BundleProducts from './product-bundles/main';

export default () => {
  if (CreateProducts) {
    new CreateProducts(document.getElementById('updateProducts'));
  }
  
  if (CreateCategories) {
    new CreateCategories(document.getElementById('createCategories'));
  }

  if (SearchField) {
    new SearchField(document.getElementById('search-field'));
  }

  if (BundleProducts) {
    new BundleProducts(document.getElementById('asnp_easy_product_bundle'));
  }

  // if (FilterPrice) {
  //   new FilterPrice(document.getElementById('slider-range'));
  // }

};