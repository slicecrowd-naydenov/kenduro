import CreateProducts from './createProducts/main';
import CreateCategories from './createCategories/main';
// import FilterPrice from './filter-price';
import SearchField from './blog/main';
import Compatibilities from './bike-compatibility';

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

  if (Compatibilities) {
    new Compatibilities(document.getElementById('compatibilities'));
  }

  // if (FilterPrice) {
  //   new FilterPrice(document.getElementById('slider-range'));
  // }

};