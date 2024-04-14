function verifMajeur() {
  const inputNaissance = document.getElementById("naissance");
  const anneeNaissance = parseInt(inputNaissance.value.split("-")[0], 10);
  const moisNaissance = parseInt(inputNaissance.value.split("-")[1], 10);
  const jourNaissance = parseInt(inputNaissance.value.split("-")[2], 10);

  const messageAge = document.getElementById("messageError");
  

  const dateActuelle = new Date();
  const anneeActuelle = dateActuelle.getFullYear();
  const moisActuel = dateActuelle.getMonth() + 1; // Ajouter 1 car les mois sont indexés à partir de 0
  const jourActuel = dateActuelle.getDate();

  let age = anneeActuelle - anneeNaissance;
  if (
    moisActuel < moisNaissance ||
    (moisActuel === moisNaissance && jourActuel < jourNaissance)
  ) {
    age--;
  }

  if (age >= 18) {
    return true;
  } else {
    return false;
  }
}

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
  return numeroTelephone.startsWith(prefixesPays[pays]);
}

function confirmationMDP(mdp, confirmation) {
  mdp == confirmation ? true : false;
}
function verifFormat(event) {
  // majorité
  if (!verifMajeur()) {
    messageAge.style.color = "red";
    messageAge.textContent = "Vous devez avoir au moins 18 ans !";
    event.preventDefault();
  }

  // numéro téléphone
  const telephone = document.getElementById("tel").value;
  const pays = document.getElementById('pays').value;
  console.log(telephone, pays);
  if (!verifierPaysNumeroTelephone(telephone, pays)) {
    const messageErrorTel = document.getElementById('messageErrorTel');
    messageErrorTel.style.color="red";
    messageErrorTel.textContent = "Le numéro de téléphone n'est pas compatible avec le pays spécifié.";
    event.preventDefault();
  }

  // confirmation mdp 
  const mdp = document.getElementById("password").value.trim();
  const confirmation = document.getElementById("confirmation").value.trim();
  const messageErrorPassw = document.getElementById("messageErrorPassw");

  if (mdp != confirmation) {
    messageErrorPassw.textContent = "Le mot de passe est différent.";
    event.preventDefault();
  }
}
var button = document.getElementById("submit");
button.addEventListener("click", verifFormat);
