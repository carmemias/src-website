//on document load
//* display all event (*.php)

let data = {},
  app = {},
  types = [];

app.init = function() {
  const events = new wp.api.collections.Events();
  events.fetch({ data: { _embed: true } }).done(data => {
    data["events"] = events;
    data.forEach(event => {
      let slug = event._embedded["wp:term"][0][0].slug;
      types[slug] = event._embedded["wp:term"][0][0].name;
    });
    renderDropDown(types);
  });
};

//add event_type filter html to the top of the page
function renderDropDown(types) {
  var container = document.getElementsByClassName('entry-content')[0];
  var selectElement = document.createElement('select');
  selectElement.setAttribute('name', 'select-type');
  Object.keys(types).forEach(slug => {
    var optionElement = document.createElement('option');
    optionElement.setAttribute('value', 'slug');
    optionElement.innerHTML = types[slug];
	selectElement.appendChild(optionElement);
  });
container.insertBefore(selectElement, container.firstChild);
}

app.init();

// data.filter(event => event.type == "music");
