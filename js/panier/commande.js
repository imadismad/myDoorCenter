import limite from "../lib/limite.js";

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
        const URL = "/api/searchCity.php?q=" + currentText;
        
        fetch(URL).then(async (response) => {
            if (response.ok) {
                const data = await response.json();

                data.features.forEach((result, index) => {
                    const li = document.createElement("li");
                    li.textContent = `${result.properties.label}`;
                    li.tabIndex = -1;
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
    document.querySelectorAll(".home > div:not(.home-check-div) > input").forEach((child) => {
        child.disabled = document.getElementById("same-as-bill").checked;
    });
}
document.getElementById("same-as-bill").addEventListener("change", updateHome);
updateHome();


document.getElementById("ptRelayInput").addEventListener("change", (event) => {
    document.querySelector(".point-relay").hidden = !event.target.checked;
    document.querySelector(".home").hidden = event.target.checked;
});

document.getElementById("domicilInput").addEventListener("change", (event) => {
    document.querySelector(".home").hidden = !event.target.checked;
    document.querySelector(".point-relay").hidden = event.target.checked;
});

document.querySelector(".point-relay").hidden = !document.getElementById("ptRelayInput").checked;
document.querySelector(".home").hidden = !document.getElementById("domicilInput").checked;

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
