import limite from "../../lib/limite.js";
import { checkVisa, checkMasterCard, checkPhone } from "../../lib/dataChecker.js";

const ptRelay = document.getElementById("pt-relay-search");
const ptRelayUl = document.getElementById("pt-relay-search-ul");
let map; // The map object
const mapMarkers = [];
const pickUpShopResultUl = document.getElementById("point-relay-result").querySelector("ul");

let currentActive; // To know wich relai point is active

// Linking the input bill with the input delivery
document.getElementById("bill-info").querySelectorAll("input").forEach((input) => {
    const id = input.id;
    const deliveryInput = document.getElementById(id.replace("-bill", ""));
    const firstNameShop = document.querySelector(`#point-relay > input[name='${id.replace("-bill", "")}']`);

    if (deliveryInput !== null) {
        if (id === "firstname-bill" || id === "lastname-bill") {
            firstNameShop.value = input.value;
            input.addEventListener("input", (event) => {
                if (document.getElementById("same-as-bill").checked)
                    deliveryInput.value = event.target.value;
                firstNameShop.value = event.target.value;
            });
        } else
            input.addEventListener("input", (event) => {
                if (document.getElementById("same-as-bill").checked)
                    deliveryInput.value = event.target.value;
            });
    }
});

const updateHome = () => {
    document.querySelectorAll(".home > div:not(#sameAsFactInp) > input").forEach((child) => {
        child.readOnly = document.getElementById("same-as-bill").checked;
    });
}

document.getElementById("same-as-bill").addEventListener("change", (event) => {
    updateHome();
    if (event.target.checked) {
        document.getElementById("homeDelivery").querySelectorAll("input").forEach((input) => {
            if (input.type === "text") {
                const id = input.id;
                const billInput = document.getElementById(id + "-bill");

                if (billInput !== null)
                    input.value = billInput.value;
            }
        });
    }
});
updateHome();


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

document.getElementById("ptRelayInput").addEventListener("change", (event) => {
    document.querySelector("#point-relay").hidden = !event.target.checked;
    document.querySelector(".home").hidden = event.target.checked;

    document.querySelectorAll("#point-relay > input[type='text' ]").forEach((input) => {
        input.disabled = false;
    });
    document.querySelectorAll("#homeDelivery input[type='text' ]").forEach((input) => {
        input.disabled = true;
    });
});

document.getElementById("domicilInput").addEventListener("change", (event) => {
    document.querySelector(".home").hidden = !event.target.checked;
    document.querySelector("#point-relay").hidden = event.target.checked;

    document.querySelectorAll("#point-relay > input[type='text' ]").forEach((input) => {
        input.disabled = true;
    });
    document.querySelectorAll("#homeDelivery input[type='text' ]").forEach((input) => {
        input.disabled = false;
    });
});

document.querySelector("#point-relay").hidden = !document.getElementById("ptRelayInput").checked;
document.querySelector(".home").hidden = !document.getElementById("domicilInput").checked;

// Check form content
document.getElementById("order-next-step").addEventListener("click", (event) => {
    event.preventDefault();
    let valide = true;

    // Check if the user has filled the form
    const billInput = document.getElementById("bill-info").querySelectorAll("input");
    const shopDelivery = document.getElementById("ptRelayInput").checked;

    for (const input of billInput) {
        if (input.value.trim() === "") {
            if (!input.classList.contains("is-invalid")) {
                input.classList.add("is-invalid");
                valide = false;
            }
        } else if (input.classList.contains("is-invalid"))
            input.classList.remove("is-invalid");
    }

    if (shopDelivery) {
        const parent = document.getElementById("point-relay").querySelector("div.autocomplet-input");
        const input = parent.querySelector("input");

        if (pickUpShopResultUl.querySelector("li.active") === null) {
            input.classList.add("is-invalid");
            valide = false;
        }
        else if (input.classList.contains("is-invalid"))
            input.classList.remove("is-invalid");
    } else
        for (const input of document.getElementById("homeDelivery").querySelectorAll("input[type='text']")) {
            if (input.value.trim() === "") {
                if (!input.classList.contains("is-invalid")) {
                    input.classList.add("is-invalid");
                    valide = false;
                }
            } else if (input.classList.contains("is-invalid"))
                input.classList.remove("is-invalid");
        }
    
    for (const input of document.getElementById("creditCardInfo").querySelectorAll("input")) {
        if (input.value.trim() === "") {
            if (!input.classList.contains("is-invalid")) {
                input.classList.add("is-invalid");
                valide = false;
            }
        } else if (input.classList.contains("is-invalid"))
            input.classList.remove("is-invalid");
    }

    // Check if phone post code and credit card are valid
    const phone = document.getElementById("phone");
    if (!checkPhone(phone.value) && !phone.classList.contains("is-invalid")) {
        phone.classList.add("is-invalid");
        valide = false;
    }

    const cardNumber = document.getElementById("cardNumber");
    if (
        !checkVisa(cardNumber.value) &&
        !checkMasterCard(cardNumber.value) &&
        !cardNumber.classList.contains("is-invalid")
    ) {
        cardNumber.classList.add("is-invalid");
        valide = false;
    }

    const cardCVV = document.getElementById("cardCVV");
    if (!/^\d{3}$/.test(cardCVV.value.trim()) && !cardCVV.classList.contains("is-invalid")) {
        cardCVV.classList.add("is-invalid");
        valide = false;
    }

    const cardExpiryDate = document.getElementById("cardExpiryDate");
    const date = new Date("01/"+cardExpiryDate.value);
    date.setMonth(date.getMonth() + 1);
    if (
        (date.toString() === "Invalid Date" || date < new Date())&&
        !cardExpiryDate.classList.contains("is-invalid")
    ) {
        cardExpiryDate.classList.add("is-invalid");
        valide = false;
    }
    
    if (valide)
        document.getElementsByTagName("form")[0].submit();
});

// autocomplete adress
document.getElementById("address-bill").addEventListener("input", limite(async (event) => {
    autoCompleteAddress(
        event.target,
        document.getElementById("address-bill-search-ul"),
        document.getElementById("postal-code-bill"),
        document.getElementById("city-bill")
    );
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

                li.addEventListener("click", () => {
                    if (currentActive !== undefined)
                        pickUpShopResultUl.querySelector("li.active").classList.remove("active");

                    li.classList.add("active");
                    currentActive = index;

                    console.log(store);
                    // Set hidden input
                    document.querySelector("#point-relay > input[name='address']").value = store.address.toLowerCase();
                    document.querySelector("#point-relay > input[name='postal-code']").value = store.postCode;
                    document.querySelector("#point-relay > input[name='city']").value = store.city.toLowerCase();

                    centerMapOn(store.lon, store.lat);
                });

                pickUpShopResultUl.appendChild(li);
                addStoreToMap(store.lon, store.lat, (marker) => {
                    if (currentActive !== undefined)
                        pickUpShopResultUl.querySelector("li.active").classList.remove("active");

                    li.classList.add("active");
                    li.scrollIntoView();
                    centerMapOn(store.lon, store.lat);

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

    marker.on("click", () => { callback(marker) });

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
 * @param {HTMLInputElement} inputStreet The input give by the user
 * @param {HTMLDivElement} divResult the HTLML input element
 * @param {HTMLInputElement} HTMLinputPostCode the HTML input element for the postal code
 * @param {HTMLInputElement} HTMLinputCity the HTML input element for the city
 */
async function autoCompleteAddress(inputStreet, divResult, HTMLinputPostCode, HTMLinputCity) {
    if (inputStreet.value.length < 3) return;
    const URL = "/api/searchCity.php?q=" + encodeURIComponent(inputStreet.value.replaceAll(" ", "+"));
    const response = await fetch(URL);
    const data = await response.json();
    const result = data.features; // Array

    const ul = inputStreet; 

    while (ul.firstChild) ul.removeChild(ul.lastChild);

    result.forEach((element) => {
        const pte = element.properties;
        const button = document.createElement("button");

        button.classList.add("dropdown-item", "list-group-item-action");
        button.textContent = `${pte.name}, ${pte.postcode} ${pte.city}`;
        button.addEventListener("click", () => {
            inputStreet.value = pte.name;
            document.getElementById("postal-code-bill").value = pte.postcode;
            document.getElementById("city-bill").value = pte.city;
            while (ul.firstChild) ul.removeChild(ul.lastChild);
        });

        ul.appendChild(button);
    });  
}