<?php
include_once ("../BDD/config.php");
require_once "../BDD/functionsSQL.php";
// Create connection
$conn = new mysqli(SQL_SERVER, SQL_USER, SQL_PASSWORD, SQL_BDD_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Produit";
$result = $conn->query($sql);

// Output data as JSON
header('Content-Type: application/json');
$rows = [];
if ($result?->num_rows > 0) {
    while ($row = $result?->fetch_assoc()) {
        $rows[] = $row;
    }
}
echo json_encode($rows);
$conn->close();
?>