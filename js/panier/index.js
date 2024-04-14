import currentCart from "../lib/cart.js";
import { TAXE } from "../lib/const.js";

const tbody = document.getElementById("cartTable");

if (currentCart.getNumberOfItem() === 0) {
    currentCart.addItem(0, 10);
    currentCart.addItem(1, 7);
} 

currentCart.forEach((item) => {
    const line = document.createElement("tr");
    const name = document.createElement("td");
    const quantity = document.createElement("td");
    const prixUnit = document.createElement("td");
    const tva = document.createElement("td");
    const tot = document.createElement("td");
    const input = document.createElement("input");

    input.type = "number";
    input.value = item.getQuantity();
    input.min = 0;
    input.addEventListener("change", (event) => {
        const newValue = event.target.value;
        item.setQuantity(newValue > 0 ? newValue : 0);
        tot.innerText = ((55.55 + 9.99) * item.getQuantity()).toFixed(2) + "€";
        currentCart.updateSessionStorage();
    });
    quantity.appendChild(input);

    name.textContent = item.getItemId();

    prixUnit.innerText = "55.55€";
    tva.innerText = 55.55 * TAXE + "€";
    tot.innerText = ((55.55 + 9.99) * item.getQuantity()).toFixed(2) + "€";

    line.append(name, quantity, prixUnit, tva, tot)

    tbody.append(line);
});
