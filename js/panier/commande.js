import limite from "../lib/limite.js";

const ptRelayCodePostal = document.getElementById("pt-relay-code-postal");
const ptRelayCodePostalUl = document.getElementById("pt-relay-postal-ul");

const ptRelayVille = document.getElementById("pt-relay-nom-ville");
const ptRelayVilleUl = document.getElementById("pt-relay-ville-ul");

// Adding event
ptRelayCodePostal.addEventListener("input", limite(async () => {
    while (ptRelayCodePostalUl.firstChild) ptRelayCodePostalUl.removeChild(ptRelayCodePostalUl.lastChild);
    let currentText = ptRelayCodePostal.value;

    if (currentText.length > 2) {
        const URL = "/api/searchCity.php?pays=FR&mode=codePostal&term=" + currentText;

        fetch(URL).then(async (response) => {
            if (response.ok) {
                const data = await response.json();

                data.forEach((result, index) => {
                    const li = document.createElement("li");
                    li.textContent = result.label;
                    li.tabIndex = -1;
                    li.addEventListener("click", () => {
                        updateInputText(result.Libelle, result.CodePostal)
                    });

                    ptRelayCodePostalUl.appendChild(li);
                });

                // ptRelayCodePostalUl.hidden = false;
                ptRelayCodePostal.focus();
            }
        });
    }
}, 500));

ptRelayVille.addEventListener("input", limite(async () => {
    while (ptRelayVilleUl.firstChild) ptRelayVilleUl.removeChild(ptRelayVilleUl.lastChild);
    let currentText = ptRelayVille.value;
    
    if (currentText.length > 2) {
        const URL = "/api/searchCity.php?pays=FR&mode=ville&term=" + currentText;

        fetch(URL).then(async (response) => {
            if (response.ok) {
                const data = await response.json();

                data.forEach((result, index) => {
                    const li = document.createElement("li");
                    li.textContent = result.label;
                    li.tabIndex = -1;
                    li.addEventListener("click", () => {
                        updateInputText(result.Libelle, result.CodePostal)
                    });

                    ptRelayVilleUl.appendChild(li);
                });

                // ptRelayCodePostalUl.hidden = false;
                ptRelayVille.focus();
            }
        });
    }
}, 500));


function updateInputText(city, codePostal) {
    ptRelayCodePostal.value = codePostal;
    ptRelayVille.value = city;

    console.log("aaa");

    while (ptRelayVilleUl.firstChild) ptRelayVilleUl.removeChild(ptRelayVilleUl.lastChild);
    while (ptRelayCodePostalUl.firstChild) ptRelayCodePostalUl.removeChild(ptRelayCodePostalUl.lastChild);
}