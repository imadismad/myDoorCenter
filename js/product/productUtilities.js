const modal = new bootstrap.Modal(document.getElementById("modale"))

// JavaScript pour le changement de l'image principale au survol
document.addEventListener('DOMContentLoaded', function () {
    var vignettes = document.querySelectorAll('.vignette');

    vignettes.forEach(function(vignette) {
        vignette.addEventListener('mouseover', function() {
            var newImage = this.getAttribute('src');
            document.getElementById('main-image').setAttribute('src', newImage);
        });
    });
});

function updatePrice(element, basePrice) {
    // Check if the value is above the max
    if (Number.parseInt(element.value) > Number.parseInt(element.max))
        element.value = element.max

    const quantity = element.value;
    const totalPrice = quantity * basePrice;
    document.getElementById('price').innerText = totalPrice.toFixed(2) + '€';
}

function addProduct(productId) {
    const quantity = document.getElementById("quantity-select").value
    const optionId = document.querySelectorAll("input[name='optionId']:checked");
    console.log(optionId);

    const button = document.getElementById("ajoutPanier");
    button.disabled = true;

    let optionsId = "";
    if (optionId.length > 0) {
        optionsId = optionId[0].value;
        for (let i = 1; i < optionId.length; i++) {
            optionsId += "|"+optionId[i].value;
        }
    }

    fetch(
        "/api/cart/add.php?productId="+productId+"&quantity="+quantity+"&optionsId="+optionsId,
    ).then((value) => {
        button.disabled = false;
        displayModal();
    });

}


function displayModal() {
    modal.show();
}

function hideModal() {
    modal.hide();
}


document.addEventListener("DOMContentLoaded", function() {
    const mainImageContainer = document.getElementById('main-image-container');
    const images = document.querySelectorAll('.vignette, #main-image');

    // Créer l'élément popup
    const popupOverlay = document.createElement('div');
    popupOverlay.className = 'popup-overlay';
    const popupImage = document.createElement('img');
    popupImage.className = 'popup-image';
    popupOverlay.appendChild(popupImage);
    document.body.appendChild(popupOverlay);

    // Fonction pour ouvrir la popup
    function openPopup(src) {
        popupImage.src = src;
        popupOverlay.style.display = 'flex';
    }

    // Fonction pour fermer la popup
    function closePopup() {
        popupOverlay.style.display = 'none';
    }

    // Événements pour les images
    images.forEach(image => {
        image.addEventListener('click', () => openPopup(image.src));
    });

    // Événement pour fermer la popup
    popupOverlay.addEventListener('click', closePopup);
});
