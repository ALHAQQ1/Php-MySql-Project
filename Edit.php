<?php

session_start();
if (!isset($_SESSION['user']))
    return;


require_once 'db.php';
require_once 'functions.php';
getParams();



$sql  = " SELECT cars.id as id,elan.UserId,elan.id as elanid,ColorName as Color,";
$sql .= " CarTypeName as CarType,FuelName as Fuel,GearboxName as Gearbox,Make,Model,Year,Engine,EnginePower,MillAge as Milage";
$sql .= " ,Price,PriceType,IsSalon,Description,CityName as SellerCity,SellerName ";
$sql .= " FROM cars,elan,City,gearbox,fuel,color,carType";
$sql .= " WHERE  cars.id = elan.CarId ";
$sql .= " AND elan.CityId = City.id";
$sql .= " AND cars.GearboxId = Gearbox.id";
$sql .= " AND cars.Fuelid = Fuel.id";
$sql .= " AND cars.ColorId = Color.id";
$sql .= " AND cars.CarTypeId = CarType.id ";
$sql .= " AND cars.id = :id ";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $CarId);

$stmt->execute();

$car = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!-- add item panel -->
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Edit Car</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                    <label>Car Make</label>
                    <select name="CarMake" class="form-control" required>
                        <option value="All">-- All --</option>
                        <?php
                        $stmt = $conn->prepare("SELECT Make FROM cars GROUP BY Make");
                        $stmt->execute();
                        $makes = $stmt->fetchAll();
                        foreach ($makes as $make) {
                            $string = "<option value='" . $make['Make'] . "'";
                            if ($car['Make'] == $make['Make']) $string .= "selected";

                            $string .= ">" . $make['Make'] . "</option>";
                            echo $string;
                        }
                        ?>
                    </select>
                </div>


                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                    <label for="car_model">Car Model</label>
                    <input value=<?= '"' . $car['Model'] . '"' ?> type="text" class="form-control" id="car_model" name="CarModel" placeholder="Car Model" required>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label for="car_year">Car Year</label>
                    <select name="CarYear" class="form-control" required>
                        <option value="All">-- All --</option>
                        <?php
                        for ($i = (int)date('Y'); $i > 1902; $i--) {
                            $string = "<option value='" . $i . "' ";
                            if ($car['Year'] == $i) $string .= "selected";
                            $string .= ">" . $i . "</option>";

                            echo $string;
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label for="car_price">Car Price</label>
                    <div class="row">
                        <div class="col-md-7 col-sm-7 col-xs-7">
                            <input value=<?='"'.$car["Price"].'"'?> type="number" class="form-control" id="car_price" name="CarPrice" placeholder="Car Price" required>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <select name="CarPriceType" class="form-control" required>

                                <option value="AZN" <?= $car['PriceType'] == 'AZN' ? 'selected' : ""  ?>>AZN</option>
                                <option value="$" <?= $car['PriceType'] == '$' ? 'selected' : ""  ?>>$</option>
                                <option value="EUR" <?= $car['PriceType'] == 'EUR' ? 'selected' : ""  ?>>EUR</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label for="carEngineSize">Engine Size</label>
                    <select name="carEngineSize" class="form-control" required>
                        <option value="All">-- All --</option>
                        <?php
                        // split the engine size into two parts
                        $engineSize = explode(' ', $car['Engine']);
                        //replace the '.' with ','
                        $engineSize = str_replace(',', '.', $engineSize[0]);
                        $engineSize = (float)$engineSize;
                        $engineSize = $engineSize * 1000;


                        for ($i = 50; $i < 16500;) {
                            $string = "<option value='" . $i . "'";
                            if ($engineSize == $i) $string .= "selected";
                            $string .= " >" . $i . "</option>";
                            echo $string;
                            if ($i <= 450) $i = $i + 50;
                            else if ($i >= 500 && $i < 7500) $i = $i + 100;
                            else if ($i >= 7500) $i = $i + 500;
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                    <label for="carEnginePower"> Car Horse Power(HP)</label>
                    <input value=<?= '"' . $car["EnginePower"] . '"' ?> type="number" class="form-control" id="carEnginePower" name="carEnginePower" placeholder="Car Engine Power" required>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label for="carMillage">Car Millage</label>
                    <input value=<?= '"' . $car["Milage"] . '"' ?> type="number" class="form-control" id="carMillage" name="carMillage" placeholder="Car Millage" required>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label>Color</label>
                    <select name="CarColor" class="form-control" required>
                        <option value="All">-- All --</option>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM color");
                        $stmt->execute();
                        $colors = $stmt->fetchAll();
                        foreach ($colors as $color) {
                            $string = "<option value='" . $color['id'] . "'";
                            if ($car['Color'] == $color['ColorName']) $string .= "selected";
                            $string .= ">" . $color['ColorName'] . "</option>";
                            echo $string;
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label>GearBox</label>
                    <select name="GearBox" class="form-control" required>
                        <option value="All">-- All --</option>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM gearbox");
                        $stmt->execute();
                        $gearboxes = $stmt->fetchAll();
                        foreach ($gearboxes as $gearbox) {
                            $string = "<option value='" . $gearbox['id'] . "'";
                            if ($car['Gearbox'] == $gearbox['GearboxName']) $string .= "selected";
                            $string .= ">" . $gearbox['GearboxName'] . "</option>";
                            echo $string;
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label>Fuel</label>
                    <select name="Fuel" class="form-control" required>
                        <option value="All">-- All --</option>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM fuel");
                        $stmt->execute();
                        $Fuels = $stmt->fetchAll();
                        foreach ($Fuels as $Fuel) {
                            $string = "<option value='" . $Fuel['id'] . "'";
                            if ($car['Fuel'] == $Fuel['FuelName']) $string .= "selected";
                            $string .= ">" . $Fuel['FuelName'] . "</option>";
                            echo $string;
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label>Car Type</label>
                    <select name="CarType" class="form-control" required>
                        <option value="All">-- All --</option>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM cartype");
                        $stmt->execute();
                        $CarTypes = $stmt->fetchAll();
                        foreach ($CarTypes as $CarType) {
                            $string = "<option value='" . $CarType['id'] . "'";
                            if ($car['CarType'] == $CarType['CarTypeName']) $string .= "selected";
                            $string .= ">" . $CarType['CarTypeName'] . "</option>";
                            echo $string;
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">

                    <label for="car_image">City</label>
                    <select name="CarCity" class="form-control" required>
                        <option value="All">-- All --</option>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM City");
                        $stmt->execute();
                        $Cities = $stmt->fetchAll();
                        foreach ($Cities as $City) {
                            $string = "<option value='" . $City['id'] . "'";
                            if ($car['SellerCity'] == $City['CityName']) $string .= "selected";
                            $string .= ">" . $City['CityName'] . "</option>";
                            echo $string;
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label>SellerName</label>
                    <input value=<?= '"' . $car["SellerName"] . '"' ?> type="text" class="form-control" id="SellerName" name="SellerName" placeholder="Car Seller Name" required>
                    <label>Phone Number</label>
                    <?php

                    $sql = "SELECT * FROM contacts WHERE CarId=:id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":id", $car["id"]);
                    $stmt->execute();
                    $contacts = $stmt->fetch();

                    $Number = $contacts["PhoneNumber"];
                    //replace
                    $Number = str_replace("(", "", $Number);
                    $Number = str_replace(")", "", $Number);
                    //trim
                    $Number = trim($Number);
                    $start = substr($Number, 0, strlen($Number) - (strlen($Number) - 3));
                    $start = $start . "-";
                    $Number = substr($Number, 4);

                    $Number=$start.$Number;

                    ?>
                    <input value=<?='"'.$Number.'"'?> type="tel" class="form-control" id="Phone Number" name="PhoneNumber" required>

                    <small>Format: 123-456-78-90</small>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label>Extras</label>
                    <select id="extras" style="height: 160px;" name="Extras[]" class="form-control" multiple>
                        <?php

                        $stmt = $conn->prepare("SELECT * FROM extras WHERE CarId = :id");
                        $stmt->bindParam(":id", $car['id']);
                        $stmt->execute();
                        $CarExtras = $stmt->fetchAll();

                        $stmt = $conn->prepare("SELECT * FROM extras GROUP BY Value");
                        $stmt->execute();
                        $Extras = $stmt->fetchAll();
                        foreach ($Extras as $Extra) {
                            $string = "<option value='" . $Extra['Value'] . "'";
                            foreach ($CarExtras as $key)
                                if ($Extra['Value'] == $key['Value']) {
                                    $string .= "selected";
                                    break;
                                }
                            $string .= ">" . $Extra['Value'] . "</option>";
                            echo $string;
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label for="car_description">Car Description</label>
                    <textarea style="resize: none;" class="form-control" id="car_description" name="car_description" rows="10"><?= $car["Description"] ?></textarea>
                </div>
                <div style="display: flex; justify-content: center;" class="form-group  col-md-12 col-sm-12 col-xs-12">
                    <button onclick="Edit()" class="btn" value="addCar">Edit</button>
                </div>

            </div>
        </div>
    </div>
</div>