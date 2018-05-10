
//on document load
//* display all event (*.php)

var data = {};
let app = {},
  areas = [],
  types = [],
  dates = [];

//TODO this will need to be moved elsewhere as it is also needed when building the dropdown lists for the filter
//check in which programme page we are
const currentURL = window.location.pathname;
const currentHost = window.location.protocol + '//' + window.location.hostname;
const currentYear = currentURL.substring(
      currentURL.length - 5,
      currentURL.length - 1
    );

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
        //TODO Before doing any of this, we need to check what year the event is from
        if (event._embedded != undefined && event._embedded["wp:term"] != undefined) {
          let allTypes = event._embedded["wp:term"][0];
          allTypes.forEach(function(singleType){
            let slug = singleType.slug;
            types[slug] = singleType.name.charAt(0).toUpperCase() + singleType.name.slice(1);
          });
        }
        types.sort(function (a, b) {
          return a.value - b.value;
        });

        let areaName = event.extra_meta["_event_cpt_area"]
          ? event.extra_meta["_event_cpt_area"][0]
          : "No area name set yet";

        if (areas.indexOf(areaName) == -1) {
          areas.push(areaName);
        }
        areas.sort();

        let date = event.extra_meta["_event_cpt_date_event"]
                  ? event.extra_meta["_event_cpt_date_event"][0]
                  : "No date set yet";
        if (dates.indexOf(date) == -1) {
            dates.push(date);
        }
        dates.sort();
      });
    })
    .then(function(data) {
      renderDropDownType(types);
      renderDropDownArea(areas);
      renderDropDownDate(dates);
      submitButton(data);
    });
};

/*
* transform YYYY-MM-DD into a long format date
*/
function getLongDate(date){
  let days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
      months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
      d = new Date(date),
      longDate = '';

  longDate += days[d.getDay()] + ' ' + d.getDate() + ' ' + months[d.getMonth()];

  return longDate;
}

/*
* get all the types an event has been given
*/
function getAllItsTypes(event){
  let typesArray = [];

  if (event._embedded == undefined && event._embedded["wp:term"] == undefined) {
    return typesArray;
  } else {
    let allTypes = event._embedded["wp:term"][0];
    allTypes.forEach(function(singleType){
      let slug = singleType.slug;
      typesArray[slug] = singleType.name;
    });
  }
  typesArray.sort(function (a, b) {
    return a.value - b.value;
  });

  return typesArray;
}

/*
* add event_type filter html to the top of the page
*/
function renderDropDownType(types) {
  let formElement = document.getElementsByClassName("filters")[0];

  let selectElement = document.createElement("select");
  selectElement.setAttribute("name", "select-type");
  selectElement.classList.add("filterElement");
  let defaultElement = document.createElement("option");
  defaultElement.setAttribute("value", "");
  defaultElement.innerHTML = "All Event Types";
  selectElement.appendChild(defaultElement);
  Object.keys(types).sort().forEach(slug => {
    let optionElement = document.createElement("option");
    optionElement.setAttribute("value", slug);
    optionElement.innerHTML = types[slug];
    selectElement.appendChild(optionElement);
  });
  formElement.appendChild(selectElement);
}

/*
* add event_area filter html to the top of the page
*/
function renderDropDownArea(areas) {
  let formElement = document.getElementsByClassName("filters")[0];

  let selectAreaElement = document.createElement("select");
  selectAreaElement.setAttribute("name", "select-area");
  selectAreaElement.classList.add("filterElement");
  let defaultElement = document.createElement("option");
  defaultElement.setAttribute("value", "");
  defaultElement.innerHTML = "All Locations";
  selectAreaElement.appendChild(defaultElement);
  Object.keys(areas).sort().forEach(area => {
    let optionElement = document.createElement("option");
    optionElement.setAttribute("value", areas[area]);
    optionElement.innerHTML = areas[area];
    selectAreaElement.appendChild(optionElement);
  });
  formElement.appendChild(selectAreaElement);
}

/*
* add event_date filter html to the top of the page
*/
function renderDropDownDate(dates) {
  let formElement = document.getElementsByClassName("filters")[0];

  let selectDateElement = document.createElement("select");
  selectDateElement.setAttribute("name", "select-date");
  selectDateElement.classList.add("filterElement");
  let defaultElement = document.createElement("option");
  defaultElement.setAttribute("value", "");
  defaultElement.innerHTML = "All Dates";
  selectDateElement.appendChild(defaultElement);

  Object.keys(dates).sort().forEach(date => {
    let optionElement = document.createElement("option"),
        longDate = getLongDate(dates[date]);

    optionElement.setAttribute("value", dates[date]);
    optionElement.innerHTML = longDate;
    selectDateElement.appendChild(optionElement);
  });
  formElement.appendChild(selectDateElement);
}

/*
* add a Submit button to the filter, form read input from all 3 filters and submit query
*/
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
        if (el.name == "select-date") {
          filteredValues.date = el.options[el.selectedIndex].value;
        } else if (el.name == "select-area") {
          filteredValues.area = el.options[el.selectedIndex].value;
        } else {
          filteredValues.type = el.options[el.selectedIndex].value;
        }
      });

      var newArray = data.filter(function(dataItem) {
        return (
          (dataItem.extra_meta["_event_cpt_date_event"] == undefined || dataItem.extra_meta["_event_cpt_date_event"][0].substring(0, 4) == currentYear) &&
          (filteredValues.type == "" ||
            (dataItem._embedded != undefined &&
              dataItem._embedded["wp:term"] != undefined &&
              //dataItem._embedded["wp:term"][0][0].slug == filteredValues.type)) &&
              Object.keys(getAllItsTypes(dataItem)).includes(filteredValues.type) )) &&
          (filteredValues.area == "" ||
            (dataItem.extra_meta != undefined &&
              dataItem.extra_meta["_event_cpt_area"] != undefined &&
              dataItem.extra_meta["_event_cpt_area"][0] == filteredValues.area)) &&
          (filteredValues.date == "" ||
            (dataItem.extra_meta != undefined &&
              dataItem.extra_meta["_event_cpt_date_event"] != undefined &&
              dataItem.extra_meta["_event_cpt_date_event"][0] == filteredValues.date))
        );
      });
      renderNewEventsView(newArray);
    });
}

/*
* render the list of events resulting from the filter query
*/
function renderNewEventsView(newArray) {
  let programDiv = document.getElementById("programme");
  programDiv.innerHTML = "";
  if (newArray.length === 0) {
    let errorDiv = document.createElement("div");
    errorDiv.classList.add("error");
    errorDiv.innerHTML = "Oops! Nothing to show";
    programDiv.appendChild(errorDiv);
  }

  newArray.forEach(event => {

    let sectionElement = document.createElement("section");
    sectionElement.classList.add("event-entry");
    sectionElement.setAttribute("id", "event-" + event.id);
    let leftColumn = document.createElement("div");
    leftColumn.classList.add("left-column");
    let rightColumn = document.createElement("div");
    rightColumn.classList.add("right-column");
    sectionElement.appendChild(leftColumn);
    sectionElement.appendChild(rightColumn);
    programDiv.appendChild(sectionElement);

    //start of left column
    let aElement = document.createElement("a");
    aElement.setAttribute("href", event.link);
    aElement.setAttribute("alt", "read more about " + event.title.rendered);

    if (event.featured_media != 0) {
      let imgElement = document.createElement("img");
      imgElement.classList.add(
        "attachment-medium",
        "size-medium",
        "wp-post-image"
      );
      if (event._embedded == undefined || event._embedded["wp:featuredmedia"] == undefined){
        imgElement.setAttribute(
          "src", " ");
      }
      else if (event._embedded["wp:featuredmedia"][0].media_details.sizes.medium != undefined) {
        imgElement.setAttribute(
          "src",
          event._embedded["wp:featuredmedia"][0].media_details.sizes.medium.source_url
        );
      } else {
        imgElement.setAttribute(
          "src",
          event._embedded["wp:featuredmedia"][0].media_details.sizes.full.source_url
        );
      }
      aElement.appendChild(imgElement);
      leftColumn.appendChild(aElement);
    }

    let links = document.createElement("div"),
        linksArray = [];
    links.classList.add("links");

    //website
    if (event.extra_meta._event_cpt_organizer_website) {
      linksArray['website'] = event.extra_meta._event_cpt_organizer_website;
    }
    //facebook
    if (event.extra_meta._event_cpt_organizer_facebook) {
      linksArray['facebook'] = event.extra_meta._event_cpt_organizer_facebook;
    }
    //twitter
    if (event.extra_meta._event_cpt_organizer_twitter) {
      linksArray['twitter'] = event.extra_meta._event_cpt_organizer_twitter;
    }
    //instagram
    if (event.extra_meta._event_cpt_organizer_instagram) {
      linksArray['instagram'] = event.extra_meta._event_cpt_organizer_instagram;
    }

    Object.keys(linksArray).forEach(linkTitle => {
      //console.log(linkTitle+' with url: '+linksArray[linkTitle]);
      let aEl = document.createElement("a"),
          spanEl = document.createElement("span"),
          imgEl = document.createElement("img");

        aEl.setAttribute(
          "href",
          linksArray[linkTitle]
        );
        aEl.setAttribute("target", "_blank");
        aEl.setAttribute("rel", "noopener");

        spanEl.classList.add("screen-reader-text");
        spanEl.innerHTML = linkTitle;

        aEl.appendChild(spanEl);
        //New SVG icon format <img src="your.svg" onerror="this.src='your.png'">
        imgEl.setAttribute('width', 22);
        imgEl.setAttribute('height', 22);
        imgEl.setAttribute('style', 'max-height:22px; margin-top:6px;');
        imgEl.classList.add('icon');
        imgEl.setAttribute('src', currentHost + '/wp-content/plugins/events_plugin/src/assets/img/' + linkTitle + '-icon.svg');
        imgEl.setAttribute('onerror', 'this.src='+ currentHost + '/wp-content/plugins/events_plugin/src/assets/img/' + linkTitle + '-icon.png');
        aEl.appendChild(imgEl);

        links.appendChild(aEl);

    });

    leftColumn.appendChild(links);

    //start of right column
    //header
    let headerEl = document.createElement('header'),
        headerTwo = document.createElement("h2"),
        divEl = document.createElement('div');

    headerEl.classList.add('event-header');
    headerTwo.classList.add("event-title");

    let aRightElement = document.createElement("a");
    aRightElement.setAttribute("href", event.link);
    aRightElement.setAttribute(
      "alt",
      "read more about " + event.title.rendered
    );
    aRightElement.innerHTML = event.title.rendered;

    headerTwo.appendChild(aRightElement);
    headerEl.appendChild(headerTwo);

    if (event.extra_meta._event_cpt_main_organizer) {
      let mainOrganiser = event.extra_meta._event_cpt_main_organizer[0];
      divEl.classList.add('event-by');
      divEl.innerHTML = 'by ' + mainOrganiser;
      headerEl.appendChild(divEl);
    }

    rightColumn.appendChild(headerEl);

    //event_types
    let typeDivElement = document.createElement("div");
    typeDivElement.classList.add("entry-meta");
    if (
      event._embedded != undefined &&
      event._embedded["wp:term"] != undefined
    ) {
      let typesArray = event._embedded["wp:term"][0],
          typesList = '';
      typesArray.forEach(function(t){
        typesList += t.name + ' | ';
      })
      typesList = typesList.substring(0, typesList.length - 3);
      typeDivElement.innerHTML = typesList;
    } else {
      typeDivElement.innerHTML = "";
    }

    // headerTwo.appendChild(titleDivElement);
    rightColumn.appendChild(typeDivElement);

    let eventDate = document.createElement("p");
    eventDate.classList.add("date");
    // eventDate.innerHTML = date;
    if (
      event.extra_meta._event_cpt_date_event === undefined ||
      event.extra_meta._event_cpt_startTime_event === undefined ||
      event.extra_meta._event_cpt_endTime_event === undefined
    ) {
      var span = document.createElement("span");
      span.setAttribute("style", "color: #f00");
      span.innerHTML = "No date set yet";
      eventDate.appendChild(span);
    } else {
      eventDate.innerHTML =
        getLongDate(event.extra_meta._event_cpt_date_event) +
        " - " +
        event.extra_meta._event_cpt_startTime_event +
        " - " +
        event.extra_meta._event_cpt_endTime_event;
    }
    rightColumn.appendChild(eventDate);

    let eventLocation = document.createElement("p"),
        locationTxt = '';

    eventLocation.classList.add("location");

    if (event.extra_meta._event_cpt_venue) {
      locationTxt += event.extra_meta._event_cpt_venue;
    }

    if (event.extra_meta._event_cpt_area) {
      locationTxt += ", " + event.extra_meta._event_cpt_area;
    }

    eventLocation.innerHTML = locationTxt;

    rightColumn.appendChild(eventLocation);

    let eventPrice = document.createElement("p");
    eventPrice.classList.add("Price");
    if ((event.extra_meta._event_cpt_price_event == undefined) || event.extra_meta._event_cpt_price_event == '0.00') {
      eventPrice.innerHTML = "Free ";
    } else if (event.extra_meta._event_cpt_price_event == '-1') {
      eventPrice.innerHTML = "Entry by donation";
    } else {
      eventPrice.innerHTML = "£" + parseFloat(event.extra_meta._event_cpt_price_event).toFixed(2);
    }
    rightColumn.appendChild(eventPrice);
  });
}

wp.api.loadPromise.done(() => {
  app.init();
});
