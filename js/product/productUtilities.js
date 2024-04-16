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