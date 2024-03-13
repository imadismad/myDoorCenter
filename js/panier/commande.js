import throttleFetch from "../lib/throttleFetch.js";

const ptRelayCodePostal = document.getElementById("pt-relay-code-postal");
const ptRelayCodePostalUl = document.getElementById("pt-relay-postal-ul");

const ptRelayVille = document.getElementById("pt-relay-nom-ville");
const ptRelayVilleUl = document.getElementById("pt-relay-ville-ul");

// Adding event
ptRelayCodePostal.addEventListener("change", async () => {
    console.log("aa");
    let currentText = ptRelayCodePostal.value;
    if (currentText.length > 2) {
        const URL = "/api/pickUpStore/searchCity.php?pays=FR&mode=codePostal&term=" + currentText;
        console.log(URL);

        fetch(URL).then(async (response) => {
            const data = await response.json();
            data.forEach((result) => {
                const li = document.createElement("li");
                li.textContent = result.label;
                ptRelayCodePostalUl.appendChild(li);
            });
        });
        /*const response = throttleFetch(URL, 2000);

        if (response.ok) {
            const data = await response.json();
            console.log(data);
        }*/
    }
});