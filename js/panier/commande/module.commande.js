import limite from "../../lib/limite.js";
import { checkMail, checkPhone } from "../../lib/dataChecker.js";

const ptRelay = document.getElementById("pt-relay-search");
const ptRelayUl = document.getElementById("pt-relay-search-ul");
let map; // The map object
const mapMarkers = [];
const pickUpShopResultUl = document.getElementById("point-relay-result").querySelector("ul");

let currentActive; // To know wich relai point is active

// Adding event
ptRelay.addEventListener("input", limite(async () => {
    while (ptRelayUl.firstChild) ptRelayUl.removeChild(ptRelayUl.lastChild);
    let currentText = ptRelay.value;

    if (currentText.length > 2) {
        const URL = "/api/searchCity.php?q=" + encodeURIComponent(currentText.replaceAll(" ", "+"));
        
        fetch(URL).then(async (response) => {
            if (response.ok) {
                const data = await response.json();

                data.features.forEach((result, index) => {
                    const li = document.createElement("button");
                    li.textContent = `${result.properties.label}`;
                    li.tabIndex = -1;
                    li.classList.add("dropdown-item", "list-group-item-action");
                    li.addEventListener("click", () => {
                        updateInputText(result.properties.label)

                        // searching for result
                        centerMapOn(result.geometry.coordinates[0], result.geometry.coordinates[1]);
                        searchPickUpStore(result.geometry.coordinates[0], result.geometry.coordinates[1]);
                    });

                    ptRelayUl.appendChild(li);
                });

                // ptRelayCodePostalUl.hidden = false;
                ptRelay.focus();
            }
        });
    }
}, 500));

const updateHome = () => {
    document.querySelectorAll(".home > div:not(#sameAsFactInp) > input").forEach((child) => {
        child.disabled = document.getElementById("same-as-bill").checked;
    });
}
document.getElementById("same-as-bill").addEventListener("change", updateHome);
updateHome();


document.getElementById("ptRelayInput").addEventListener("change", (event) => {
    document.querySelector("#point-relay").hidden = !event.target.checked;
    document.querySelector(".home").hidden = event.target.checked;
});

document.getElementById("domicilInput").addEventListener("change", (event) => {
    document.querySelector(".home").hidden = !event.target.checked;
    document.querySelector("#point-relay").hidden = event.target.checked;
});

document.querySelector("#point-relay").hidden = !document.getElementById("ptRelayInput").checked;
document.querySelector(".home").hidden = !document.getElementById("domicilInput").checked;

document.getElementById("order-next-step").addEventListener("click", () => {
    // Check if the user has filled the form
    const billInput = document.getElementById("bill-info").querySelectorAll("input");
    const shopDelivery = document.getElementById("ptRelayInput").checked;
    
    for (const input of billInput) {
        console.log(input.classList);
        if (input.value.trim() === "") {
            if (!input.classList.contains("is-invalid"))
                input.classList.add("is-invalid");
        } else if (input.classList.contains("is-invalid"))
            input.classList.remove("is-invalid");
    }

    if (shopDelivery) {
        const parent = document.getElementById("point-relay").querySelector("div.autocomplet-input");
        const input = parent.querySelector("input");
        console.log(pickUpShopResultUl.querySelector("li.active") === null);
        if (pickUpShopResultUl.querySelector("li.active") === null)
            input.classList.add("is-invalid");
        else if (input.classList.contains("is-invalid"))
            input.classList.remove("is-invalid");
    } else
        for (const input of document.getElementById("homeDelivery").querySelectorAll("input[type='text']")) {
            if (input.value.trim() === "") {
                if (!input.classList.contains("is-invalid"))
                    input.classList.add("is-invalid");
            } else if (input.classList.contains("is-invalid"))
                input.classList.remove("is-invalid");
        }
    
    for (const input of document.getElementById("creditCardInfo").querySelectorAll("input")) {
        if (input.value.trim() === "") {
            if (!input.classList.contains("is-invalid"))
                input.classList.add("is-invalid");
        } else if (input.classList.contains("is-invalid"))
            input.classList.remove("is-invalid");
    }

    // Check if phone mail and credit card are valid
    const phone = document.getElementById("phone");
    if (!checkPhone(phone.value) && !phone.parentElement.classList.contains("is-invalid"))
        phone.parentElement.classList.add("is-invalid");

    

});

document.getElementById("address-bill").addEventListener("input", limite(async (event) => {
    const data = await autoCompleteAddress(event.target.value, null);
    const result = data.features; // Array

    const ul = document.getElementById("address-bill-search-ul");

    result.forEach((element) => {
        const pte = element.properties;
        console.log(`Street : ${pte.name}, Post Code : ${pte.postcode}, City : ${pte.city}`);
        const button = document.createElement("button");
        button.classList.add("dropdown-item", "list-group-item-action");
        button.textContent = `${pte.name}, ${pte.postcode} ${pte.city}`;
        button.addEventListener("click", () => {
            //event.target.value = button.textContent;
            //ul.hidden = true;
        });

        ul.appendChild(button);
    });
}, 500));

window.onload = () => {
    map = L.map("map");

    // Setting up the map
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
}

function updateInputText(content) {
    ptRelay.value = content;

    while (ptRelayUl.firstChild) ptRelayUl.removeChild(ptRelayUl.lastChild);
}

function searchPickUpStore(Lon, Lat) {
    const URL = `/api/pickUpStore/search.php?country=FR&Lon=${Lon}&Lat=${Lat}`;
    fetch(URL).then(async (response) => {
        if (response.ok) {
            const data = await response.json();

            while (pickUpShopResultUl.firstChild) pickUpShopResultUl.remove(pickUpShopResultUl.lastChild);
            removeAllMarkerOnMap();
            data.forEach((store, index) => {
                const li = document.createElement("li");
                const name = document.createElement("div");
                const address = document.createElement("div");
                const openTime = document.createElement("div");
                
                name.innerText = `${store.name}`;
                name.classList.add("name");

                address.innerText = `${store.address} ${store.postCode} ${store.city}`;
                address.classList.add("address");

                openTime.innerText = openTimeObjectToString(store.openTime);
                openTime.classList.add("openTime");

                li.append(name, address, openTime);
                pickUpShopResultUl.appendChild(li);
                addStoreToMap(store.lon, store.lat, () => {
                    if (currentActive !== undefined)
                        pickUpShopResultUl.querySelector("li.active").classList.remove("active");

                    li.classList.add("active");
                    currentActive = index;
                });
            });
        }
    });

    while (pickUpShopResultUl.firstChild) pickUpShopResultUl.removeChild(pickUpShopResultUl.lastChild);
}

function centerMapOn(Lon, Lat) {
    map.setView([Lat, Lon], 13);
}

function addStoreToMap(Lon, Lat, callback) {
    const marker = L.marker([Lat, Lon]);
    mapMarkers.push(marker);

    marker.on("click", callback);

    marker.addTo(map);
}

function removeAllMarkerOnMap() {
    while (mapMarkers.length !== 0) {
        mapMarkers.shift().remove();
    }
}

/**
 * Convert the openTime field in a server response into a string use for the user display
 * @param {any} opentTime the schedule give by the server in his respons
 * @return the string to display inside the li
 */
function openTimeObjectToString(opentTime) {
    let following = [];
    let currentContent;

    let result = "";

    const toString = () => {
        if (following.length === 0) return;
        if (result !== "") result += "\n";
            
        result += keyToDay(following[0]);
        if (following.length > 1) result += ` - ${keyToDay(following[following.length - 1])}`;

        if (currentContent.morning.split("-")[1] === currentContent.afternoon.split("-")[0])
            result += `: ${currentContent.morning.split("-")[0]} - ${currentContent.afternoon.split("-")[1]}`;
        else
            result += `: ${currentContent.morning.replace("-", " - ")} et ${currentContent.afternoon.replace("-", " - ")} `;

        following = [];
        currentContent = undefined;
    }

    for (const key in opentTime) {
        const value = opentTime[key];

        if (following.length === 0) {
            following.push(key);
            currentContent = value;
        }else if (currentContent.morning === value.morning && currentContent.afternoon === value.afternoon) {
            following.push(key);
        } else {
            toString();
        }
    }

    toString();
    return result;
}

/**
 * Convert the key of a day in a openTime part in a server response into a dayt of a week in french
 * @param {string} dayKey the key of a day 
 */
function keyToDay(dayKey) {
    switch(dayKey.toLowerCase()) {
        case "monday":
            return "Lundi";
        case "tuesday":
            return "Mardi";
        case "wednesday":
            return "Mercredi";
        case "thursday":
            return "Jeudi";
        case "friday":
            return "Vendredi";
        case "saturday":
            return "Samedi";
        case "sunday":
            return "Dimanche"
    }

    return "undefined";
}

/**
 * Autocomplete address for user
 * @param {string} input The input give by the user
 * @param {HTMLInputElement} HTMLinput the HTLML input element
 */
async function autoCompleteAddress(input, div) {
    if (input.length < 3) return;
    const URL = "/api/searchCity.php?q=" + encodeURIComponent(input.replaceAll(" ", "+"));
    const response = await fetch(URL);
    const data = await response.json();

    return data;    
}