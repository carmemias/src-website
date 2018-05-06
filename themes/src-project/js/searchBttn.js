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


    if (lastItem.innerHTML === 'Search' || 'search') {
      let spanEl = document.createElement('span'),
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

      lastItem.innerHTML = '';
      lastItem.appendChild(spanEl);

      lastItem.appendChild(svgEl);

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
