const emplacement = document.getElementById("templatePanier");

const modal = new bootstrap.Modal(document.getElementById("modale"));
let promiseModal = undefined;

async function updateVue(id, initialValue, input) {
    if (input.value > 0 || await displayModal() === true) {
        // We need to update only if the value is greter than 0
        // Or if the user confirm he want to remove from the cart the product
        await fetch(`/api/cart/add.php?productId=${id}&quantity=${input.value - initialValue}&optionsId=${input.dataset.optionIds}`, )
    }
    emplacement.innerHTML = await (await fetch("/pageTemplate/panierTemplate.php")).text();
    
    init();
}

function init() {
    emplacement.querySelectorAll("input[type='number']").forEach((input) => {
        const initialValue = input.value;
        input.addEventListener("change", () => { updateVue(input.name, initialValue, input) });
    });
}

function displayModal() {
    modal.show();
    // Setting up Promise
    return new Promise((resolve) => {
        promiseModal = resolve;
    });
}

function hideModal(update) {
    modal.hide();
    promiseModal(update);
}

init();