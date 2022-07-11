<?php
require_once 'db.php';
require_once 'functions.php';
getParams();
$sql = "SELECT * FROM cars INNER JOIN elan ON";
$sql .= " cars.id = elan.CarId INNER JOIN City ON elan.CityId = City.id";
$sql .= " INNER JOIN Gearbox ON cars.GearboxId = Gearbox.id";
$sql .= " INNER JOIN Fuel ON cars.Fuelid = Fuel.id";
$sql .= " INNER JOIN Color ON cars.ColorId = Color.id";
$sql .= " INNER JOIN CarType ON cars.CarTypeId = CarType.id";
if ($query != "All")
    $sql .= " WHERE make = '$query'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$cars = $stmt->fetchAll();

echo json_encode($cars);
