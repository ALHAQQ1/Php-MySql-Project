<?php
require_once 'db.php';
require_once 'functions.php';
getParams();
if ($query == "All")
    $sql = "SELECT * FROM cars";
else
    $sql = "SELECT * FROM `car` WHERE make = '$query'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$cars = $stmt->fetchAll();

echo json_encode($cars);
