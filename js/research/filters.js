
const priceRangeMin = document.getElementById('priceRangeMin');
const priceNumberMin = document.getElementById('priceNumberMin');
const priceValueMin = document.getElementById('priceValueMin');

function updatePriceMin(value) {
    priceValueMin.textContent = value;
    priceRangeMin.value = value;
    priceNumberMin.value = value;
}

priceRangeMin.addEventListener('input', function() {
    updatePriceMin(this.value);
});

priceNumberMin.addEventListener('input', function() {
    updatePriceMin(this.value);
});


const priceRangeMax = document.getElementById('priceRangeMax');
const priceNumberMax = document.getElementById('priceNumberMax');
const priceValueMax = document.getElementById('priceValueMax');


function updatePriceMax(value) {
    priceValueMax.textContent = value;
    priceRangeMax.value = value;
    priceNumberMax.value = value;
}

priceRangeMax.addEventListener('input', function() {
    updatePriceMax(this.value);
});

priceNumberMax.addEventListener('input', function() {
    updatePriceMax(this.value);
});
