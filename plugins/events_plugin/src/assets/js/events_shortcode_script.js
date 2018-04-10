//on document load
//* display all event (*.php)

var data = {};
let app = {},
  areas = [],
  types = [];

app.init = function() {
  let container = document.getElementsByClassName("entry-content")[0];
  let formElement = document.createElement("form");
  formElement.classList.add("filters");
  container.insertBefore(formElement, container.firstChild);

  const events = new wp.api.collections.Events();
  events
    .fetch({ data: { _embed: true } })
    .done(data => {
      data["events"] = events;
      data.forEach(event => {
        let slug = event._embedded["wp:term"][0][0].slug;
        types[slug] = event._embedded["wp:term"][0][0].name;
        let areaName = event.extra_meta["_event_cpt_area"][0];
        let date = event.extra_meta["_event_cpt_date_event"][0];
        if (areas.indexOf(areaName) == -1) {
          areas.push(areaName);
        }
        areas.sort();
      });
    })
    .then(function(data) {
      renderDropDown(types);
      renderDropDownArea(areas);
      renderDropDownDate();
      submitButton(data);
    });
};

//add event_type filter html to the top of the page
function renderDropDown(types) {
  let formElement = document.getElementsByClassName("filters")[0];

  let selectElement = document.createElement("select");
  selectElement.setAttribute("name", "select-type");
  selectElement.classList.add("filterElement");
  let defaultElement = document.createElement("option");
  defaultElement.setAttribute("value", "");
  defaultElement.innerHTML = "All Event Types";
  selectElement.appendChild(defaultElement);
  Object.keys(types).forEach(slug => {
    let optionElement = document.createElement("option");
    optionElement.setAttribute("value", slug);
    optionElement.innerHTML = types[slug];
    selectElement.appendChild(optionElement);
  });
  formElement.appendChild(selectElement);
}

function renderDropDownArea(areas) {
  let formElement = document.getElementsByClassName("filters")[0];

  let selectAreaElement = document.createElement("select");
  selectAreaElement.setAttribute("name", "select-area");
  selectAreaElement.classList.add("filterElement");
  let defaultElement = document.createElement("option");
  defaultElement.setAttribute("value", "");
  defaultElement.innerHTML = "All Locations";
  selectAreaElement.appendChild(defaultElement);
  Object.keys(areas).forEach(area => {
    let optionElement = document.createElement("option");
    optionElement.setAttribute("value", areas[area]);
    optionElement.innerHTML = areas[area];
    selectAreaElement.appendChild(optionElement);
  });
  formElement.appendChild(selectAreaElement);
}

function renderDropDownDate() {
  let formElement = document.getElementsByClassName("filters")[0];

  let inputDateElement = document.createElement("input");
  inputDateElement.classList.add("filterElement");
  inputDateElement.setAttribute("type", "date");
  inputDateElement.setAttribute("data-date-inline-picker", true);
  inputDateElement.setAttribute("pattern", "[0-9]{4}-[0-9]{2}-[0-9]{2}");
  inputDateElement.setAttribute("min", "2018-06-01");
  inputDateElement.setAttribute("max", "2018-06-30");
  formElement.appendChild(inputDateElement);
}

function submitButton(data) {
  var filteredValues = { type: "", area: "", date: "" };
  let formElement = document.getElementsByClassName("filters")[0];
  var btn = document.createElement("BUTTON");
  btn.setAttribute("id", "submitFilterButton");
  var t = document.createTextNode("Find Event");
  btn.appendChild(t);
  formElement.appendChild(btn);
  document
    .getElementById("submitFilterButton")
    .addEventListener("click", function(x) {
      x.preventDefault();
      var elems = document.querySelectorAll(".filterElement");
      elems.forEach(function(el) {
        if (el.type == "date") {
          filteredValues.date = el.value;
        } else if (el.name == "select-area") {
          filteredValues.area = el.options[el.selectedIndex].value;
        } else {
          filteredValues.type = el.options[el.selectedIndex].value;
        }
      });
      var newArray = data.filter(function(dataItem) {
        return (
          (filteredValues.type == "" ||
            dataItem._embedded["wp:term"][0][0].slug == filteredValues.type) &&
          (filteredValues.area == "" ||
            dataItem.extra_meta["_event_cpt_area"][0] == filteredValues.area) &&
          (filteredValues.date == "" ||
            dataItem.extra_meta["_event_cpt_date_event"][0] ==
              filteredValues.date)
        );
      });
      console.log(newArray);
    });
}

wp.api.loadPromise.done(() => {
  app.init();
});
