const emplacement = document.getElementById("templatePanier");

async function updateVue(id, initialValue, input) {
    await fetch(`/api/cart/add.php?productId=${id}&quantity=${input.value - initialValue}&optionsId=${input.dataset.optionIds}`, )
    emplacement.innerHTML = await (await fetch("/pageTemplate/panierTemplate.php")).text();
    init();
}

function init() {
    emplacement.querySelectorAll("input[type='number']").forEach((input) => {
        const initialValue = input.value;
        input.addEventListener("change", () => { updateVue(input.name, initialValue, input) });
    });
}

init();