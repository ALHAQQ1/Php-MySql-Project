<?php

session_start();
if (!isset($_SESSION['user']))
    return;

require_once 'db.php';


?>
<!-- add item panel -->
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Add Car</h3>
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
                            $string .= ">" . $make['Make'] . "</option>";
                            echo $string;
                        }
                        ?>
                    </select>
                </div>


                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                    <label for="car_model">Car Model</label>
                    <input type="text" class="form-control" id="car_model" name="CarModel" placeholder="Car Model" required>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label for="car_year">Car Year</label>
                    <select name="CarYear" class="form-control" required>
                        <option value="All">-- All --</option>
                        <?php
                        for ($i = (int)date('Y'); $i > 1902; $i--) {
                            $string = "<option value='" . $i . "'>" . $i . "</option>";
                            echo $string;
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label for="car_price">Car Price</label>
                    <div class="row">
                        <div class="col-md-7 col-sm-7 col-xs-7">
                            <input type="number" class="form-control" id="car_price" name="CarPrice" placeholder="Car Price" required>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <select name="CarPriceType" class="form-control" required>
                                <option value="AZN">AZN</option>
                                <option value="$">$</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label for="carEngineSize">Engine Size</label>
                    <select name="carEngineSize" class="form-control" required>
                        <option value="All">-- All --</option>
                        <?php
                        for ($i = 50; $i < 16500;) {
                            $string = "<option value='" . $i . "'>" . $i . "</option>";
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
                    <input type="number" class="form-control" id="carEnginePower" name="carEnginePower" placeholder="Car Engine Power" required>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label for="carMillage">Car Millage</label>
                    <input type="number" class="form-control" id="carMillage" name="carMillage" placeholder="Car Millage" required>
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
                            $string .= ">" . $City['CityName'] . "</option>";
                            echo $string;
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label>SellerName</label>
                    <input type="text" class="form-control" id="SellerName" name="SellerName" placeholder="Car Seller Name" required>
                    <label>Phone Number</label>
                    <input type="tel" placeholder="050-111-22-33" class="form-control" id="Phone Number" name="PhoneNumber" required>

                    <small>Format: 123-456-78-90</small>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label>Extras</label>
                    <select id="extras" style="height: 160px;" name="Extras[]" class="form-control" multiple>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM extras GROUP BY Value");
                        $stmt->execute();
                        $Extras = $stmt->fetchAll();
                        foreach ($Extras as $Extra) {
                            $string = "<option value='" . $Extra['Value'] . "'";
                            $string .= ">" . $Extra['Value'] . "</option>";
                            echo $string;
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label for="car_description">Car Description</label>
                    <textarea style="resize: none;" class="form-control" id="car_description" name="car_description" rows="10"></textarea>
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <label for="Img">Car Image</label>
                    <input type="file" name="Img" multiple />
                </div>
                <div class="form-group  col-md-4 col-sm-4 col-xs-4">
                    <button onclick="CheckAndSend()" class="btn" value="addCar">Submit</button>
                </div>

            </div>
        </div>
    </div>
</div>