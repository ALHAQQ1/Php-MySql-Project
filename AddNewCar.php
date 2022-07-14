<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo "First Login";
    return;
}
require_once 'db.php';
require_once 'functions.php';

getParams();

// print_r($_REQUEST);
if (
    isset($CarColor) && isset($Fuel) && isset($GearBox) && isset($CarType) &&
    isset($CarMake) && isset($CarModel) && isset($CarYear) && isset($carEngineSize) &&
    isset($carEnginePower) && isset($CarMillage) && isset($CarPrice) && isset($car_description)
) {


    $sql = "INSERT INTO `cars`(`ColorId`, `Fuelid`, `GearboxId`, `CarTypeId`, `Make`, `Model`, `Year`, `Engine`, `EnginePower`, `MillAge`, `Price`, `PriceType`, `IsSalon`, `Description`) VALUES";
    $carEnginePower = $carEnginePower;

    $carEngineSize = $carEngineSize / 1000;
    $carEngineSize .= " L";
    $carEngineSize = str_replace(".", ",", $carEngineSize);
    $sql .= "(:CarColor,:Fuel,:GearBox,:CarType,:CarMake,:CarModel,:CarYear,:carEngineSize,:carEnginePower,:CarMillage,:CarPrice,:CarPriceType,'0',:Description)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':CarColor', $CarColor);
    $stmt->bindParam(':Fuel', $Fuel);
    $stmt->bindParam(':GearBox', $GearBox);
    $stmt->bindParam(':CarType', $CarType);
    $stmt->bindParam(':CarMake', $CarMake);
    $stmt->bindParam(':CarModel', $CarModel);
    $stmt->bindParam(':CarYear', $CarYear);
    $stmt->bindParam(':carEngineSize', $carEngineSize);
    $stmt->bindParam(':carEnginePower', $carEnginePower);
    $stmt->bindParam(':CarMillage', $CarMillage);
    $stmt->bindParam(':CarPrice', $CarPrice);
    $stmt->bindParam(':CarPriceType', $CarPriceType);
    $stmt->bindParam(':Description', $car_description);

    $stmt->execute();

    $last_id = $conn->lastInsertId();

    // // //ADD image to car there
    $images[] = "";
    $dir = "Car-image/";
    $i = -1;
    foreach ($_FILES['car_image']['name'] as $row => $name) {
        $i = $i + 1;
        $file = basename($name);
        $path = $dir . $file;

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));


        $check = getimagesize($_FILES["car_image"]["tmp_name"][$row]);


        $ok = $check && in_array($ext, ["jpg", "png", "jpeg"]) &&
            $_FILES["car_image"]["size"][$row] < 5000000;

        if ($ok) {
            move_uploaded_file($_FILES["car_image"]["tmp_name"][$row], $path);
            $images[] = $imageName = $last_id . '-' . $CarMake . '-' . $CarModel . '-' . $i . '.' . $ext;
            rename($dir . $file, $dir . $imageName);
        }
    }


    array_shift($images);


    foreach ($images as $key) {
        $sql = "INSERT INTO `images`(`Value`, `CarId`) VALUES (:Value,:CarId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':Value', $key);
        $stmt->bindParam(':CarId', $last_id);
        $stmt->execute();
    }


    //extras

    //split string to array
    $ExtraSelected = explode(",", $ExtraSelected);

    foreach ($ExtraSelected as $key) {
        $sql = "INSERT INTO `extras`(`Value`,`CarId`) VALUES";
        $sql .= "(:Value,:CarId)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':Value', $key);
        $stmt->bindParam(':CarId', $last_id);
        $stmt->execute();
    }


    //remove first 4 char

    // 055-844-88-31
    $start = substr($car_seller_phone, 0, strlen($car_seller_phone) - (strlen($car_seller_phone) - 3));
    $start = '(' . $start . ') ';
    $car_seller_phone = substr($car_seller_phone, 4);

    // (055) 844-88-31
    $car_seller_phone = $start . $car_seller_phone;
    //add contact info to car
    $sql = "INSERT INTO `contacts`(`PhoneNumber`,`CarId`) VALUES";
    $sql .= "(:PhoneNumber,:CarId)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':PhoneNumber', $car_seller_phone);
    $stmt->bindParam(':CarId', $last_id);

    $stmt->execute();

    //get current date with year-month-day
    $date = date('Y-m-d');
    
    $sql = "INSERT INTO `elan`(`UserId`,`SellerName`,`CityId`,`CarId`,`Status`,`date`) VALUES";
    $sql .= "(:UserId,:SellerName,:CityId,:CarId,'1',:date)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':UserId', $_SESSION['user']['id']);
    $stmt->bindParam(':SellerName', $car_seller_name);
    $stmt->bindParam(':CityId', $CarCity);
    $stmt->bindParam(':CarId', $last_id);
    $stmt->bindParam(':date', $date);
    $stmt->execute();

    echo "success";
} else
    echo "error";
