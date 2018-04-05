//on document load
//* display all event (*.php)

let data = {},
  app = {},
  areas = [];
  types = [];

app.init = function() {
  let container = document.getElementsByClassName('entry-content')[0];
  let formElement = document.createElement('form');
  formElement.classList.add('filters');
  container.insertBefore(formElement,container.firstChild);

  const events = new wp.api.collections.Events();
  events.fetch({ data: { _embed: true } }).done(data => {
    data["events"] = events;
    data.forEach(event => {
      let slug = event._embedded["wp:term"][0][0].slug;
      types[slug] = event._embedded["wp:term"][0][0].name;
      let areaName = event.extra_meta["_event_cpt_area"][0];
      if(areas.indexOf(areaName) == -1){
        areas.push(areaName);
      };
      areas.sort();
    });
    renderDropDown(types);
    renderDropDownArea(areas);
  });
};

//add event_type filter html to the top of the page
function renderDropDown(types) {
  let formElement = document.getElementsByClassName('filters')[0];

  let selectElement = document.createElement('select');
  selectElement.setAttribute('name', 'select-type');
  let defaultElement = document.createElement("option");
  defaultElement.setAttribute("value", "");
  defaultElement.innerHTML = "All Event Types";
  selectElement.appendChild(defaultElement);
  Object.keys(types).forEach(slug => {
    let optionElement = document.createElement('option');
    optionElement.setAttribute('value', 'slug');
    optionElement.innerHTML = types[slug];
    selectElement.appendChild(optionElement);
  });
  formElement.appendChild(selectElement);
}

function renderDropDownArea(areas) {
let formElement = document.getElementsByClassName("filters")[0];

  let selectAreaElement = document.createElement('select');
  selectAreaElement.setAttribute('areas', 'select-area');
  let defaultElement = document.createElement('option');
  defaultElement.setAttribute('value', '');
  defaultElement.innerHTML = 'All Locations';
  selectAreaElement.appendChild(defaultElement);
  Object.keys(areas).forEach(area => {
    let optionElement = document.createElement('option');
    optionElement.setAttribute('value', 'area');
    optionElement.innerHTML = areas[area];
    selectAreaElement.appendChild(optionElement);
  });
  formElement.appendChild(selectAreaElement);
  }


wp.api.loadPromise.done(() => {
  app.init();
});

// data.filter(event => event.type == "music");
