/*
* Search link behaviour. The Search menu item is linked too the Search Widget
* (placed in the Header Widget area)
* Behaviour: 	Changes word "Search" for svg icon-search
* 						On click, toggle the search widget section
*/
(function () {

  document.addEventListener("DOMContentLoaded", searchBehaviour);

  function searchBehaviour() {

    let container, menu, links, lastItem;

    container = document.getElementById('site-navigation');
    if (!container) {
      return;
    }

    menu = container.getElementsByTagName('ul')[0];

    links = menu.getElementsByTagName('a');

    lastItem = links[links.length - 1];

/* OPTION 1 - DOES NOT WORK ON IPHONE
<a href="#" class="search-bttn">
 <span class="screen-reader-text">Search</span>
 <svg class="icon icon-search" role="img" aria-hidden="true">
  <use href="#icon-search" xlink:href="#icon-search"></use>
 </svg>
</a>
*/
/* OPTION 2 - TESTING
<object type=”image/svg+xml” data=”mySVG.svg”>
  <div id="fallback"></div>
</object>
*/
    if (lastItem.innerHTML === 'Search' || 'search') {
  /*OPTION 1    let spanEl = document.createElement('span'),
        svgEl = document.createElementNS('http://www.w3.org/2000/svg', 'svg'),
        useEl = document.createElementNS('http://www.w3.org/2000/svg', 'use');

      spanEl.innerHTML = 'Search';
      spanEl.classList.add('screen-reader-text');

      useEl.setAttribute('href', '#icon-search');
      useEl.setAttribute('xlink:href', '#icon-search');

      svgEl.setAttribute('class', 'icon icon-search');
      svgEl.setAttribute('role', 'img');
      svgEl.setAttribute('aria-hidden', 'true');
      svgEl.appendChild(useEl);
      svgEl.appendChild(imgFallback);

      lastItem.innerHTML = '';
      lastItem.appendChild(spanEl);

      lastItem.appendChild(svgEl);

      lastItem.classList.add('search-bttn');
      lastItem.addEventListener('click', toggleSearchForm); */

      /* OPTION 2 */
      let spanEl = document.createElement('span'),
          //objEl = document.createElementNS('http://www.w3.org/2000/svg', 'object');
          imgEl = document.createElement('img'); //<img src="your.svg" onerror="this.src='your.png'">

      spanEl.innerHTML = 'Search';
      spanEl.classList.add('screen-reader-text');

      imgEl.setAttribute('src', 'http://localhost/wp-content/themes/src-project/images/search-icon.svg');
      imgEl.setAttribute('onerror', "this.src='http://localhost/wp-content/themes/src-project/images/search-icon.png'");
      imgEl.setAttribute('width', 25);
      imgEl.setAttribute('height', 25);
      //objEl.setAttribute( 'type', 'image/svg+xml'); //type=”image/svg+xml”
      //objEl.setAttribute( 'data', 'http://localhost/wp-content/themes/src-project/images/search-icon.svg');

      lastItem.innerHTML = '';
      lastItem.appendChild(spanEl);

      lastItem.appendChild(imgEl);

      lastItem.classList.add('search-bttn');
      lastItem.addEventListener('click', toggleSearchForm);
    }

    function toggleSearchForm(event) {
      event.preventDefault();
      var widgetSearch = document.getElementsByClassName('widget_search')[0];

      if (!widgetSearch) {
        return;
      }

      if (widgetSearch.classList.contains('widget-show')) {
        widgetSearch.classList.remove("widget-show");
      } else {
        widgetSearch.classList.add("widget-show");
      }
      if (lastItem.classList.contains('active-search')) {
        lastItem.classList.remove("active-search");
      } else {
        lastItem.classList.add("active-search");
      }
    }
  }

})();
