import WooCommerceRestApi from '@woocommerce/woocommerce-rest-api';

const currentDomain = window.location.origin;

const WooCommerce = new WooCommerceRestApi({
  url: currentDomain,
  consumerKey: 'ck_f57eae48f59482750c6ac2c93a0cec2a7f20e0b2',
  consumerSecret: 'cs_b3158831c8ea20df1675724fff78191e7623b162',
  version: 'wc/v3',  
});

export default WooCommerce;