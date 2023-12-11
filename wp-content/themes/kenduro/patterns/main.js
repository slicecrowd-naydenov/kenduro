import ready from './shared/ready';
import atoms from './atoms/index';
import molecules from './molecules/index';
import organisms from './organisms/index';

if ( !window.Promise ) {
  window.Promise = Promise;
}

/**
 * Function that is fired once the page is Reaady to fire any JS, add anything
 * required to be executed after the page is ready.
 */
function onReady() {
  window.current_project_data = window.current_project_data || {};
  atoms();
  organisms();
  molecules();
}

// The callback is fired when the dom is ready.
ready( onReady );