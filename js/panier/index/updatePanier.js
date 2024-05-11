const emplacement = document.getElementById("templatePanier");

const modal = {
    // Remove Article
    RA: new bootstrap.Modal(document.getElementById("modale")),
    // Out oF Stock
    OFS: new bootstrap.Modal(document.getElementById("modaleOFS")),
    // Cart Change
    CC: new bootstrap.Modal(document.getElementById("modaleCC")),
    // Cannot Add More
    CAM: new bootstrap.Modal(document.getElementById("modaleCAM")),
}

const promise = {
    RA: null,
    OFS: null,
    CC: null,
    CAM: null,
};

let modalOpen = false;

async function updateVue(id, initialValue, input, skipCheck = false) {
    if (!skipCheck && input.max !== "0" && Number.parseInt(input.value) >= Number.parseInt(input.max)) {
        // Checking the new quantity
        const response = await fetch(`/api/cart/getMax.php?productId=${id}`);
        if (response.status === 200) {
            const data = await response.json();
            data.max += Number.parseInt(initialValue);
            input.max = data.max;

            if (data.max === 0) {
                displayModal("OFS", id);
                input.value = 0;
            }else if (Number.parseInt(input.value) >= Number.parseInt(input.max)) {
                displayModal("CAM");
                input.value = input.max;
            }
        }
    }
    
    if (input.value !== initialValue && (input.value > 0 || (input.max !== "0" && await displayModal("RA") === true) || await displayModal("OFS", id) === true)) {
        // We need to update only if the value is greter than 0
        // Or if the user confirm he want to remove from the cart the product
        const response = await fetch(`/api/cart/add.php?productId=${id}&quantity=${input.value - initialValue}&optionsId=${input.dataset.optionIds}`, )
        if (response.status === 400) {
            const data = await response.json();
            if (data.status === "ENOEIS") { // Error Not Enough In Stock
                // Check if the quantity to add is not null
                if (data.maxTotal === 0) {
                    displayModal("OFS", id);
                } else if (data.maxTotal - initialValue === 0) {
                    displayModal("CAM");
                }

                if (data.maxTotal !== initialValue) {
                    // Re try to add the product with the maximum quantity available
                    const response = await fetch(`/api/cart/add.php?productId=${id}&quantity=${data.maxTotal - initialValue}&optionsId=${input.dataset.optionIds}`)
                    console.log(response);
                    if (response.status === 200 && data.maxTotal !== 0) {
                        displayModal("CAM");
                    }
                }
            }
        }        
    }
    emplacement.innerHTML = await (await fetch("/pageTemplate/panierTemplate.php")).text();
    
    init();
}

function init() {
    let messageModifPanier = false;
    const elements = emplacement.querySelectorAll("input[type='number']")
    for (let i = 0; i < elements.length; i++) {
        const input = elements[i];
        const initialValue = input.value;
        console.log(input.max);

        input.addEventListener("change", () => { updateVue(input.name, initialValue, input); });
        
        if (Number.parseInt(input.max) <= 0 &&  input.dataset.stock !== input.max) {
            // Cas pas assez de stock et plusieur produit même ID avec opt !=
            if (input.value !== "1") {
                input.value = Math.max(1, Number.parseInt(input.max));
                updateVue(input.name, initialValue, input, true);
                
                if (input.value === "1")
                    displayModal("CC");
                return;
            }
            
        }else if (input.max === "0") {
            input.value = 0;
            updateVue(input.name, initialValue, input);
        } else  if (Number.parseInt(input.max) < Number.parseInt(input.value)) {
            messageModifPanier = true;
            input.value = input.max;
            updateVue(input.name, initialValue, input);
            return;
        }
    }

    if (messageModifPanier)
        displayModal("CC");

}

/**
 * 
 * @param {"RA"|"OFS"|"CC"} type 
 * @returns 
 */
function displayModal(type, ...args) {
    if (modalOpen)
        return;

    modalOpen = true;
    if (promise[type] === undefined)
        throw new Error("The type of modal is not defined");

    if (type === "OFS") {
        document.getElementById("modalOFSLink").href = `../product.php?id=${args[0]}`;
    }

    modal[type].show();
    // Setting up Promise
    return new Promise((resolve) => {
        promise[type] = resolve;
    });
}

function hideModal(update, type) {
    modal[type].hide();
    modalOpen = false;
    promise[type](update);
}

window.onload = () => {
    init();
};