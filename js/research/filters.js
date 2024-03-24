// Obtenez les éléments de l'interface
const priceRangeMin = document.getElementById('priceRangeMin');
const priceNumberMin = document.getElementById('priceNumberMin');
const priceValueMin = document.getElementById('priceValueMin');

// Fonction pour mettre à jour l'affichage de la valeur et synchroniser les contrôles
function updatePriceMin(value) {
    priceValueMin.textContent = value;
    priceRangeMin.value = value;
    priceNumberMin.value = value;
}

// Écoutez l'événement 'input' pour le curseur
priceRangeMin.addEventListener('input', function() {
    updatePriceMin(this.value);
});

// Écoutez l'événement 'input' pour le champ numérique
priceNumberMin.addEventListener('input', function() {
    updatePriceMin(this.value);
});


const priceRangeMax = document.getElementById('priceRangeMax');
const priceNumberMax = document.getElementById('priceNumberMax');
const priceValueMax = document.getElementById('priceValueMax');

// Fonction pour mettre à jour l'affichage de la valeur et synchroniser les contrôles
function updatePriceMax(value) {
    priceValueMax.textContent = value;
    priceRangeMax.value = value;
    priceNumberMax.value = value;
}

// Écoutez l'événement 'input' pour le curseur
priceRangeMax.addEventListener('input', function() {
    updatePriceMax(this.value);
});

// Écoutez l'événement 'input' pour le champ numérique
priceNumberMax.addEventListener('input', function() {
    updatePriceMax(this.value);
});
