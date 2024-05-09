<?php
class Result {
    public $lon;
    public $lat;
    public $name;
    public $address;
    public $postCode;
    public $city;
    public $countryCode;
    public $openTime;
    public $isLocker;
    public function __construct($lon, $lat, $name, $address, $postCode, $city, $countryCode, $openTime, $isLocker) {
        $this->lon = $lon;
        $this->lat = $lat;
        $this->name = $name;
        $this->address = $address;
        $this->postCode = $postCode;
        $this->city = $city;
        $this->countryCode = $countryCode;
        $this->openTime = $openTime;
        $this->isLocker = $isLocker;
    }
}

if (!isset($_GET) || !isset($_GET["Lon"]) || !isset($_GET["Lat"])) {
    http_response_code(400);
    exit();
}

header("Content-Type: application/json; charset=utf-8");
$json =
'{"Lon":'.$_GET['Lon'].
',"Lat":'.$_GET['Lat'].
',"EnsCode":"5","RelaisMax":"","RelaisSmart":"","RelaisActifouTF":"1","RelaisCodeCountry":"","RayonRecherche":100000,"Delailogistique":0,"AdresseSaisie":"","NbRelais":30,"Activity":""}';


$curl = curl_init("https://service.relaiscolis.com/wslisterelaisproches/RelaisProches/Liste?key=RC202306281026CCRC");
curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-type: application/json"]);

// Set the output as a string
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($curl);
curl_close($curl);

$jsonRes = json_decode($data, true)["PoisList"];
$jsonReturn = array();
for ( $i = 0; $i < count($jsonRes); $i++ ) {
    $openTime = array();
    $openTime["monday"] = array("morning" => $jsonRes[$i]["Horairelundimatin"], "afternoon" => $jsonRes[$i]["Horairelundiapm"]);
    $openTime["tuesday"] = array("morning" => $jsonRes[$i]["Horairemardimatin"], "afternoon" => $jsonRes[$i]["Horairemardiapm"]);
    $openTime["wednesday"] = array("morning" => $jsonRes[$i]["Horairemercredimatin"], "afternoon" => $jsonRes[$i]["Horairemercrediapm"]);
    $openTime["thursday"] = array("morning" => $jsonRes[$i]["Horairejeudimatin"], "afternoon" => $jsonRes[$i]["Horairejeudiapm"]);
    $openTime["friday"] = array("morning" => $jsonRes[$i]["Horairevendredimatin"], "afternoon" => $jsonRes[$i]["Horairevendrediapm"]);
    $openTime["saturday"] = array("morning" => $jsonRes[$i]["Horairesamedimatin"], "afternoon" => $jsonRes[$i]["Horairesamediapm"]);
    $openTime["sunday"] = array("morning" => $jsonRes[$i]["Horairedimanchematin"], "afternoon" => $jsonRes[$i]["Horairedimancheapm"]);

    array_push($jsonReturn, new Result(
        $jsonRes[$i]["Lon"],
        $jsonRes[$i]["Lat"],
        strtoupper($jsonRes[$i]["Nomrelais"]),
        $jsonRes[$i]["Geocoadresse"],
        $jsonRes[$i]["Postalcode"],
        $jsonRes[$i]["Commune"],
        $jsonRes[$i]["Countrycode"],
        $openTime,
        $jsonRes[$i]["IsLocker"],
    ));
}

echo json_encode($jsonReturn);
?>