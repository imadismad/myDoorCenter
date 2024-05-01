document.addEventListener('DOMContentLoaded', function() {
    var priceRangeMin = document.getElementById('priceRangeMin');
    var priceNumberMin = document.getElementById('priceNumberMin');
    var priceValueMin = document.getElementById('priceValueMin'); 
    var priceRangeMax = document.getElementById('priceRangeMax');
    var priceNumberMax = document.getElementById('priceNumberMax');
    var priceValueMax = document.getElementById('priceValueMax');

    var minPrice = 0;
    var maxPrice = 5000;

    updateResult();

    function updateDisplays() {
        priceValueMin.textContent = priceRangeMin.value + '€';
        priceValueMax.textContent = priceRangeMax.value + '€';
        updateResult();
    }

    function updateResult() {

        var formData = new URLSearchParams();
        formData.append('minPrice', minPrice);
        formData.append('maxPrice', maxPrice);

        fetch("../../pageTemplate/productTemplate.php?research=porte", {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: formData
        
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Réseau ou réponse non valide');
            }
            return response.text();
        })
        .then(html => {
            document.getElementById('productResults').innerHTML = html;
        })
        .catch(error => {
            console.error('Erreur lors de la recherche:', error);
            alert('Erreur lors de la recherche: ' + error.message);
        });
    }


    function handleMinChange() {
        // Synchroniser la valeur du champ numérique avec le curseur
        priceNumberMin.value = priceRangeMin.value;
        // Assurer que le min ne dépasse pas le max
        if (parseInt(priceRangeMin.value) > parseInt(priceRangeMax.value)) {
            priceRangeMax.value = priceRangeMin.value;
            priceNumberMax.value = priceRangeMax.value;
        }
        minPrice = priceRangeMin.value;
        maxPrice = priceNumberMax.value;
        updateDisplays();
        updateResult();
    }

    function handleMaxChange() {
        // Synchroniser la valeur du champ numérique avec le curseur
        priceNumberMax.value = priceRangeMax.value;
        // Assurer que le max ne tombe pas en dessous du min
        if (parseInt(priceRangeMax.value) < parseInt(priceRangeMin.value)) {
            priceRangeMin.value = priceRangeMax.value;
            priceNumberMin.value = priceRangeMin.value;
        }
        minPrice = priceRangeMin.value;
        maxPrice = priceNumberMax.value;
        updateDisplays();
        updateResult();
    }

    // Écouteurs d'événements pour les changements de curseurs
    priceRangeMin.addEventListener('input', handleMinChange);
    priceNumberMin.addEventListener('change', handleMinChange);
    priceRangeMax.addEventListener('input', handleMaxChange);
    priceNumberMax.addEventListener('change', handleMaxChange);
});
