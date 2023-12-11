import CreateProducts from './createProducts/main';
import CreateCategories from './createCategories/main';
import FilterPrice from './filter-price';
import ProductCategoryFilter from './product-category/product-categories-filter';

export default () => {
  if (CreateProducts) {
    new CreateProducts(document.getElementById('createProducts'));
  }
  
  if (CreateCategories) {
    new CreateCategories(document.getElementById('createCategories'));
  }

  if (FilterPrice) {
    new FilterPrice(document.getElementById('slider-range'));
  }

  if (ProductCategoryFilter) {
    new ProductCategoryFilter(document.getElementById('cat-filters'));
  }
};