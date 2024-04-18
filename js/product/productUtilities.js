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
  var quantity = element.value;
  var totalPrice = quantity * basePrice;
  document.getElementById('price').innerText = totalPrice.toFixed(2) + '€';
}

function addProduct(productId) {
    const quantity = document.getElementById("quantity-select").value
    const optionId = document.querySelectorAll("input[name='optionId']:checked");

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