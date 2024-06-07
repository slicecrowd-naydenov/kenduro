/* eslint-disable max-nested-callbacks */
/* eslint-disable require-jsdoc */
//Import
import $ from 'jquery';
import axios from 'axios';

/**
 * @class
 */

export default class SearchField {
  /**
   * SearchField
   * @param {object} el - DOM element.
   */
  constructor(el) {
    if (!el) {
      return;
    }
    this.el = $(el);
    this.searchResults = $('#search-results');

    this.events();
  }

  events() {
    this.initSearch();
  }

  initSearch() {
    let searchTimeout;
    // Attach an event listener to the search input field
    $('.search-field').on('input', (event) => {
      // Get the search query from the input field
      var searchQuery = event.target.value;

      // Check if the search query is empty
      // if (searchQuery === '') {
      //   // If the search query is empty, remove the search results
      //   $('#search-results').html('');
      //   return;
      // }

      // Show the loader
      // $('#search-results').html('<div class="loader"></div>');
      this.searchResults.addClass('searching');


      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
        // Define the GraphQL query
        var query = `
        query SearchPosts {
          posts(where: {search: "${searchQuery}"}) {
            edges {
              node {
                title
                excerpt
                link
                featuredImage {
                  node {
                    mediaItemUrl
                  }
                }
              }
            }
          }
        }`;

        // Make the GraphQL request using Axios

        axios({
          method: 'post',
          url: 'http://kenduro.test/graphql',
          data: JSON.stringify({ query: query }),
          headers: {
            'content-type': 'application/json; charset=UTF-8'
          }
        })        
          .then((response) => {
            this.searchResults.removeClass('searching');
            const data = response.data;
            // Check if any matches were found
            const posts = data.data.posts.edges;
            if (posts.length === 0) {
              // If no matches were found, show a "Not Found" message
              this.searchResults.html('<h3>Няма намерени резултати</h3>');
            } else {
              // Create a list element to hold the search results
              const list = $('<ul>').addClass('blog-post-list');

              let searchContainerAppendData = '';
              // Loop through the returned posts and add each one to the list
              posts.map((edge, i) => {
                const post = edge.node;
                const newestPost = i === 0 ? '<p class="paragraph paragraph-m semibold newest-blog-article">Най-новото от Кендуро Блог</p>' : '';
                let imageURL = '';
                let imageALT = '';
                const postExcerpt = post.excerpt.replace('<p>', '').replace('</p>', '');

                if (post.featuredImage) {
                  imageURL = post.featuredImage.node.mediaItemUrl;
                  imageALT = post.title || 'Post Image';
                }
                // var value = item.html_value.replace(/[^0-9]/gi, ''); // Replace everything that is not a number with nothing

                searchContainerAppendData += `
                  <li class="blog-post-list__item">
                    <a href="${post.link}">
                      <div class="thumb">
                        ${newestPost}
                        <img class="blog-post-list__item-image" src="${imageURL}" alt="${imageALT}">
                      </div>
                      <div class="title-wrapper">
                        <p class="paragraph paragraph-xl semibold post-title">${post.title}</p>
                        <p class="paragraph paragraph-l post-excerpt">${postExcerpt}</p>
                        <span class="learn-more">
                          Виж повече
                          <svg width="4" height="8" viewBox="0 0 4 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M0.54116 0.16498L3.77792 3.45536C4.07403 3.76749 4.07403 4.24869 3.77792 4.54781L0.54116 7.83818C0.234844 8.15031 0 7.99425 0 7.51305L0 0.49012C0 -0.00409031 0.234844 -0.14715 0.54116 0.16498Z" fill="#FB8500"/>
                          </svg>
                        </span>
                      </div>
                    </a>
                  </li>
                `;
              });
              list.append(searchContainerAppendData);

              // Replace the existing search results with the new list
              this.searchResults
                .html('')
                .append(list);
            }
            
          })
          .catch((error) => {
            if (error.response) {
              // The request was made and the server responded with a status code
              // that falls out of the range of 2xx
              console.log(error.response.data);
              console.log(error.response.status);
              console.log(error.response.headers);
            } else if (error.request) {
              // The request was made but no response was received
              // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
              // http.ClientRequest in node.js
              console.log(error.request);
            } else {
              // Something happened in setting up the request that triggered an Error
              console.log('Error', error.message);
            }
            console.log(error.config);
          });
      }, 250);
    });
  }

}