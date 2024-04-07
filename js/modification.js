function verifierPaysNumeroTelephone(numeroTelephone, pays) {
    const prefixesPays = {
        "France": "+33",
        "États-Unis": "+1",
        "Royaume-Uni": "+44",
        "Allemagne": "+49",
        "Espagne": "+34",
        "Italie": "+39",
        "Canada": "+1",
        "Australie": "+61",
        "Japon": "+81",
        "Brésil": "+55"
    };
    if (prefixesPays[pays] === undefined) {
        console.log("Le pays spécifié n'est pas pris en charge.");
        return false;
    }
    console.log(prefixesPays[pays])
    return numeroTelephone.startsWith(prefixesPays[pays]);
}

function verifFormat(event) {

    // numéro téléphone
    const telephone = document.getElementById("tel").value;
    const pays = document.getElementById('pays').textContent.trim();
    console.log("Numéro de telephone: ", telephone);
    console.log("Pays", pays);
    if (!verifierPaysNumeroTelephone(telephone, pays)) {
        const messageErrorTel = document.getElementById('messageErrorTel');
        messageErrorTel.textContent = "Le numéro de téléphone n'est pas compatible avec le pays spécifié.";
        event.preventDefault();
    }
}
var button = document.getElementById("submit");
button.addEventListener("click", verifFormat);
