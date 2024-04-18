import CreateProducts from './createProducts/main';
import CreateCategories from './createCategories/main';
// import FilterPrice from './filter-price';

export default () => {
  if (CreateProducts) {
    new CreateProducts(document.getElementById('updateProducts'));
  }
  
  if (CreateCategories) {
    new CreateCategories(document.getElementById('createCategories'));
  }

  // if (FilterPrice) {
  //   new FilterPrice(document.getElementById('slider-range'));
  // }

};