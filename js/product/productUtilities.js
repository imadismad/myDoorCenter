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

          function updatePrice(element) {
  var quantity = element.value;
  var basePrice = 120; // Prix de base du produit, à ajuster
  var totalPrice = quantity * basePrice;
  document.getElementById('price').innerText = totalPrice + '€';
}