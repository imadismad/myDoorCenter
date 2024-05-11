document.addEventListener('DOMContentLoaded', function() {
    var priceRangeMin = document.getElementById('priceRangeMin');
    var priceNumberMin = document.getElementById('priceNumberMin');
    var priceValueMin = document.getElementById('priceValueMin'); 
    var priceRangeMax = document.getElementById('priceRangeMax');
    var priceNumberMax = document.getElementById('priceNumberMax');
    var priceValueMax = document.getElementById('priceValueMax');
    var researchDiv = document.getElementById('research');
    var sortSelect = document.getElementById('sortList');
    var porteField = document.getElementById('porteField');
    var poigneeField = document.getElementById('poigneeField');
    var accessoireField = document.getElementById('accessoireField');
    var allField = document.getElementById('allField');


    var research = researchDiv.value.replace(/\s/g, '+');
    var minPrice = 0;
    var maxPrice = 5000;
    var sort = sortSelect.value;
    
    if (porteField.checked) {
        type = '&porte=true';
    }
    if (poigneeField.checked) {
        type = '&poignee=true';
    }
    if (accessoireField.checked) {
        type = '&accessoire=true';
    }
    if (allField.checked) {
        type = '';
    }


    updateResult();

    function updateDisplays() {
        priceValueMin.textContent = priceRangeMin.value;
        priceValueMax.textContent = priceRangeMax.value;
        updateResult();
    }

    function updateResult() {

        var formData = new URLSearchParams();
        formData.append('minPrice', minPrice);
        formData.append('maxPrice', maxPrice);
        formData.append('sort', sort);

        fetch("../../pageTemplate/productTemplate.php?research="+research+type, {
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

    function handleResearchChange() {
        research = researchDiv.value.replace(/\s/g, '+');
        updateResult();
    }

    // Écouteurs d'événements pour les changements de curseurs
    priceRangeMin.addEventListener('input', handleMinChange);
    priceNumberMin.addEventListener('change', handleMinChange);
    priceRangeMax.addEventListener('input', handleMaxChange);
    priceNumberMax.addEventListener('change', handleMaxChange);
    researchDiv.addEventListener('change', handleResearchChange);
    sortSelect.addEventListener('change', function() {
        sort = sortSelect.value;
        updateResult();
    });
    porteField.addEventListener('change', function() {
        if (porteField.checked) {
            type = '&porte=true';
        }
        updateResult();
    });
    poigneeField.addEventListener('change', function() {
        if (poigneeField.checked) {
            type = '&poignee=true';
        }
        updateResult();
    });
    accessoireField.addEventListener('change', function() {
        if (accessoireField.checked) {
            type = '&accessoire=true';
        }
        updateResult();
    });
    allField.addEventListener('change', function() {
        if (allField.checked) {
            type = '';
        }
        updateResult();
    });
});
