
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

        let areaName = event.extra_meta["_event_cpt_area"]
          ? event.extra_meta["_event_cpt_area"][0]
          : "No area name set yet";

        let date = event.extra_meta["_event_cpt_date_event"]
          ? event.extra_meta["_event_cpt_date_event"][0]
          : "No date set yet";
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
      renderNewEventsView(newArray);
    });
}

function renderNewEventsView(newArray) {
  let programDiv = document.getElementById("programme");
  programDiv.innerHTML = "";
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
      imgElement.setAttribute(
        "src",
        event._embedded["wp:featuredmedia"][0].media_details.sizes.medium
          .source_url
      );
      aElement.appendChild(imgElement);
      leftColumn.appendChild(aElement);
    }

    let links = document.createElement("div");
    links.classList.add("links");
    if (event.extra_meta._event_cpt_organizer_website) {
      let website = document.createElement("a");
      website.setAttribute(
        "href",
        event.extra_meta._event_cpt_organizer_website[0]
      );
      website.setAttribute("target", "_blank");
      website.setAttribute("rel", "noopener");

      let span = document.createElement("span");
      span.classList.add("screen-reader-text");
      span.innerHTML = "Website";

      let svgEl = document.createElementNS("http://www.w3.org/2000/svg", "svg");
      let useEl = document.createElementNS("http://www.w3.org/2000/svg", "use");

      useEl.setAttribute("href", "#icon-website");
      useEl.setAttribute("xlink:href", "#icon-website");

      svgEl.setAttribute("class", "icon icon-website");
      svgEl.setAttribute("role", "img");
      svgEl.setAttribute("aria-hidden", "true");

      svgEl.appendChild(useEl);
      website.appendChild(span);
      website.appendChild(svgEl);
      links.appendChild(website);
    }
    if (event.extra_meta._event_cpt_organizer_facebook) {
      let facebook = document.createElement("a");
      facebook.setAttribute(
        "href",
        event.extra_meta._event_cpt_organizer_facebook[0]
      );
      facebook.setAttribute("target", "_blank");
      facebook.setAttribute("rel", "noopener");

      let span = document.createElement("span");
      span.classList.add("screen-reader-text");
      span.innerHTML = "facebook";

      let svgEl = document.createElementNS("http://www.w3.org/2000/svg", "svg");
      let useEl = document.createElementNS("http://www.w3.org/2000/svg", "use");

      useEl.setAttribute("href", "#icon-facebook");
      useEl.setAttribute("xlink:href", "#icon-facebook");

      svgEl.setAttribute("class", "icon icon-facebook");
      svgEl.setAttribute("role", "img");
      svgEl.setAttribute("aria-hidden", "true");

      svgEl.appendChild(useEl);
      facebook.appendChild(span);
      facebook.appendChild(svgEl);
      links.appendChild(facebook);
    }
    if (event.extra_meta._event_cpt_organizer_twitter) {
      let twitter = document.createElement("a");
      twitter.setAttribute(
        "href",
        event.extra_meta._event_cpt_organizer_twitter[0]
      );
      twitter.setAttribute("target", "_blank");
      twitter.setAttribute("rel", "noopener");

      let span = document.createElement("span");
      span.classList.add("screen-reader-text");
      span.innerHTML = "twitter";

      let svgEl = document.createElementNS("http://www.w3.org/2000/svg", "svg");
      let useEl = document.createElementNS("http://www.w3.org/2000/svg", "use");

      useEl.setAttribute("href", "#icon-twitter");
      useEl.setAttribute("xlink:href", "#icon-twitter");

      svgEl.setAttribute("class", "icon icon-twitter");
      svgEl.setAttribute("role", "img");
      svgEl.setAttribute("aria-hidden", "true");

      svgEl.appendChild(useEl);
      twitter.appendChild(span);
      twitter.appendChild(svgEl);
      links.appendChild(twitter);
    }
    if (event.extra_meta._event_cpt_organizer_instagram) {
      let instagram = document.createElement("a");
      instagram.setAttribute(
        "href",
        event.extra_meta._event_cpt_organizer_instagram[0]
      );
      instagram.setAttribute("target", "_blank");
      instagram.setAttribute("rel", "noopener");

      let span = document.createElement("span");
      span.classList.add("screen-reader-text");
      span.innerHTML = "instagram";

      let svgEl = document.createElementNS("http://www.w3.org/2000/svg", "svg");
      let useEl = document.createElementNS("http://www.w3.org/2000/svg", "use");

      useEl.setAttribute("href", "#icon-instagram");
      useEl.setAttribute("xlink:href", "#icon-instagram");

      svgEl.setAttribute("class", "icon icon-instagram");
      svgEl.setAttribute("role", "img");
      svgEl.setAttribute("aria-hidden", "true");

      svgEl.appendChild(useEl);
      instagram.appendChild(span);
      instagram.appendChild(svgEl);
      links.appendChild(instagram);
    }
    leftColumn.appendChild(links);
    //start of right column
    let headerTwo = document.createElement("h2");
    headerTwo.classList.add("type-title");

    let aRightElement = document.createElement("a");
    aRightElement.setAttribute("href", event.link);
    aRightElement.setAttribute(
      "alt",
      "read more about " + event.title.rendered
    );
    aRightElement.innerHTML = event.title.rendered;

    headerTwo.appendChild(aRightElement);
    rightColumn.appendChild(headerTwo);

    let titleDivElement = document.createElement("div");
    titleDivElement.classList.add("entry-meta");
    titleDivElement.innerHTML = event._embedded["wp:term"][0][0].name;

    // headerTwo.appendChild(titleDivElement);
    rightColumn.appendChild(titleDivElement);

    let contentDivElement = document.createElement("div");
    contentDivElement.classList.add("event-excerpt");
    contentDivElement.innerHTML = event.excerpt.rendered;
    rightColumn.appendChild(contentDivElement);

    let organizerParagraph = document.createElement("p");
    organizerParagraph.classList.add("organisers");
    if (event.extra_meta._event_cpt_main_organizer) {
      organizerParagraph.innerHTML = event.extra_meta._event_cpt_main_organizer;
    }

    rightColumn.appendChild(organizerParagraph);
    // organizerParagraph.classList.add("organisers");

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
        event.extra_meta._event_cpt_date_event +
        " From " +
        event.extra_meta._event_cpt_startTime_event +
        " To " +
        event.extra_meta._event_cpt_endTime_event;
    }
    rightColumn.appendChild(eventDate);

    let eventLocation = document.createElement("p");
    eventLocation.classList.add("location");

    if(event.extra_meta._event_cpt_area){
        eventLocation.innerHTML = event.extra_meta._event_cpt_area + ", "
    }

    if(event.extra_meta._event_cpt_address_town_city){
      eventLocation.innerHTML = event.extra_meta._event_cpt_address_town_city;
    }

    rightColumn.appendChild(eventLocation);

    let eventPrice = document.createElement("p");
    eventPrice.classList.add("price");
    if (event.extra_meta._event_cpt_price_event == undefined) {
      eventPrice.innerHTML = "Free ";
    } else {
      eventPrice.innerHTML = "£ " + event.extra_meta._event_cpt_price_event;
    }
    rightColumn.appendChild(eventPrice);
  });
}

wp.api.loadPromise.done(() => {
  app.init();
});
