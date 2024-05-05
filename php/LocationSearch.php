<?php
// https://api-adresse.data.gouv.fr/search/?q=95000 Cergy - Cergy&autocomplete=1
// {"type":"FeatureCollection","version":"draft","features":[{"type":"Feature","geometry":{"type":"Point","coordinates":[2.045547,49.04227]},"properties":{"label":"Cergy","score":0.5569345454545453,"id":"95127","type":"municipality","name":"Cergy","postcode":"95000","citycode":"95127","x":630219.48,"y":6882909.37,"population":67790,"city":"Cergy","context":"95, Val-d'Oise, Île-de-France","importance":0.50128,"municipality":"Cergy"}},{"type":"Feature","geometry":{"type":"Point","coordinates":[2.070124,49.032734]},"properties":{"label":"Rue Sully 95000 Cergy","score":0.4187090909090909,"id":"95127_1874","name":"Rue Sully","postcode":"95000","citycode":"95127","x":632003.75,"y":6881827.47,"city":"Cergy","context":"95, Val-d'Oise, Île-de-France","type":"street","importance":0.6458,"street":"Rue Sully"}},{"type":"Feature","geometry":{"type":"Point","coordinates":[2.057339,49.019051]},"properties":{"label":"Rue de Cergy 95000 Neuville-sur-Oise","score":0.40778304347826083,"id":"95450_0180","name":"Rue de Cergy","postcode":"95000","citycode":"95450","x":631050.73,"y":6880316.94,"city":"Neuville-sur-Oise","context":"95, Val-d'Oise, Île-de-France","type":"street","importance":0.57257,"street":"Rue de Cergy"}},{"type":"Feature","geometry":{"type":"Point","coordinates":[2.06855,49.035662]},"properties":{"label":"Rue des Cerisiers 95000 Cergy","score":0.4012821407624633,"id":"95127_0190","name":"Rue des Cerisiers","postcode":"95000","citycode":"95127","x":631892.5,"y":6882154.44,"city":"Cergy","context":"95, Val-d'Oise, Île-de-France","type":"street","importance":0.63991,"street":"Rue des Cerisiers"}},{"type":"Feature","geometry":{"type":"Point","coordinates":[2.080438,49.036939]},"properties":{"label":"Mail des Cerclades 95000 Cergy","score":0.3896163636363636,"id":"95127_0201","name":"Mail des Cerclades","postcode":"95000","citycode":"95127","x":632763.36,"y":6882286.26,"city":"Cergy","context":"95, Val-d'Oise, Île-de-France","type":"street","importance":0.62953,"street":"Mail des Cerclades"}}],"attribution":"BAN","licence":"ETALAB-2.0","query":"95000 Cergy - Cergy","limit":5}

function searchCity($q, $toArray = false) {
    $curl = curl_init("https://api-adresse.data.gouv.fr/search/?q=".$q."&autocomplete=1");
    // Set the output as a string
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if ($toArray) {
        return json_decode($result, true);
    }
    return $result;
}

function searchCoord($q, $postcode)  {
    $curl = curl_init("https://api-adresse.data.gouv.fr/search/?q=".$q."&postcode=".$postcode."&limite=1");
    // Set the output as a string
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    $json = json_decode($result, true);

    $coordinates = $json["features"][0]["geometry"]["coordinates"];
    return $coordinates;
}
