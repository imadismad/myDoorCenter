document.addEventListener('DOMContentLoaded', function() {
    var priceRangeMin = document.getElementById('priceRangeMin');
    var priceNumberMin = document.getElementById('priceNumberMin');
    var priceValueMin = document.getElementById('priceValueMin'); 
    var priceRangeMax = document.getElementById('priceRangeMax');
    var priceNumberMax = document.getElementById('priceNumberMax');
    var priceValueMax = document.getElementById('priceValueMax'); 

    function handleRangeMinChange() {
        var currentValue = parseInt(priceRangeMin.value, 10);
        priceNumberMin.value = currentValue;
        priceValueMin.textContent = currentValue + '€';
        if (currentValue > parseInt(priceRangeMax.value, 10)) {
            priceRangeMax.value = currentValue;
            priceNumberMax.value = currentValue;
            priceValueMax.textContent = currentValue + '€';
        }
        console.log('Valeur minimale ajustée : ' + currentValue);
    }

    function handleNumberMinChange() {
        var currentValue = parseInt(priceNumberMin.value, 10);
        priceRangeMin.value = currentValue;
        priceValueMin.textContent = currentValue + '€'; 
        if (currentValue > parseInt(priceNumberMax.value, 10)) {
            priceNumberMax.value = currentValue;
            priceRangeMax.value = currentValue;
            priceValueMax.textContent = currentValue + '€';
        }
        console.log('Valeur minimale ajustée : ' + currentValue);
    }

    function handleRangeMaxChange() {
        var currentValue = parseInt(priceRangeMax.value, 10);
        priceNumberMax.value = currentValue;
        priceValueMax.textContent = currentValue + '€';
        if (currentValue < parseInt(priceRangeMin.value, 10)) {
            priceRangeMin.value = currentValue;
            priceNumberMin.value = currentValue;
            priceValueMin.textContent = currentValue + '€';
        }
        console.log('Valeur maximale ajustée : ' + currentValue);
    }

    function handleNumberMaxChange() {
        var currentValue = parseInt(priceNumberMax.value, 10);
        priceRangeMax.value = currentValue;
        priceValueMax.textContent = currentValue + '€';
        if (currentValue < parseInt(priceNumberMin.value, 10)) {
            priceNumberMin.value = currentValue;
            priceRangeMin.value = currentValue;
            priceValueMin.textContent = currentValue + '€';
        }
        console.log('Valeur maximale ajustée : ' + currentValue);
    }

    // Ajoutez des écouteurs d'événements pour chaque input
    priceRangeMin.addEventListener('input', handleRangeMinChange);
    priceNumberMin.addEventListener('input', handleNumberMinChange);
    priceRangeMax.addEventListener('input', handleRangeMaxChange);
    priceNumberMax.addEventListener('input', handleNumberMaxChange);
});
