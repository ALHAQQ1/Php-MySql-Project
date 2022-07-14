<?php
session_start();

require_once 'db.php';
require_once 'functions.php';

getParams();
if (isset($favorite)) {
    if (!isset($_SESSION['user'])) {
        header("Location: cars.php");
        exit;
    }
}

$sql  = " SELECT cars.id as id,elan.UserId,elan.id as elanid,ColorName as Color,";
$sql .= " CarTypeName as CarType,FuelName as Fuel,GearboxName as Gearbox,Make,Model,Year,Engine,EnginePower,MillAge as Milage";
$sql .= " ,Price,PriceType,IsSalon,Description,CityName as SellerCity,SellerName ";
$sql .= " FROM cars,elan,City,gearbox,fuel,color,carType";
if (isset($favorite)) $sql .= " ,favories";
$sql .= " WHERE  cars.id = elan.CarId ";
if (isset($favorite)) {
    $sql .= " AND favories.ElanId=elan.id";
    $sql .= " AND favories.UserId = :FavuserId";
}
$sql .= " AND elan.CityId = City.id";
$sql .= " AND cars.GearboxId = Gearbox.id";
$sql .= " AND cars.Fuelid = Fuel.id";
$sql .= " AND cars.ColorId = Color.id";
$sql .= " AND cars.CarTypeId = CarType.id ";
if (!isset($UserId))
    $sql .= " AND elan.status = 1";


if (isset($SellerName)) {
    $sql .= " SellerName = :SellerName";
    $sql .= " ORDER BY cars.id LIMIT 51";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':SellerName', $SellerName);
} else if (isset($favorite)) {
    $sql .= " ORDER BY cars.id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':FavuserId', $_SESSION["user"]['id']);
} else {
    include 'getCarForQuery.php';
    $sql .= " ORDER BY cars.id LIMIT 51";
    $stmt = $conn->prepare($sql);

    if (isset($UserId))
        if ($_SESSION['user']['id'] == $UserId)
            $stmt->bindParam(':UserId', $UserId);
    if (isset($Make) && $Make != "All")
        $stmt->bindParam(':Make', $Make);
    if (isset($Model) && $Model != "All")
        $stmt->bindParam(':Model', $Model);
    if (isset($Color) && $Color != "All")
        $stmt->bindParam(':Color', $Color);
    if (isset($CarType) && $CarType != "All")
        $stmt->bindParam(':CarType', $CarType);
    if (isset($EngineSize) && $EngineSize != "All")
        $stmt->bindParam(':Engine', $EngineSize);
    if (isset($Power) && $Power != "All")
        $stmt->bindParam(':Power', $Power);
    if (isset($Fuel) && $Fuel != "All")
        $stmt->bindParam(':Fuel', $Fuel);
    if (isset($Gearbox) && $Gearbox != "All")
        $stmt->bindParam(':Gearbox', $Gearbox);
    if (isset($City) && $City != "All")
        $stmt->bindParam(':City', $City);
    if (isset($MinPrice) && is_numeric($MinPrice))
        $stmt->bindParam(':MinPrice', $MinPrice);
    if (isset($MaxPrice) && is_numeric($MaxPrice))
        $stmt->bindParam(':MaxPrice', $MaxPrice);
    if (isset($MinYear) && is_numeric($MinYear))
        $stmt->bindParam(':MinYear', $MinYear);
    if (isset($MaxYear) && is_numeric($MaxYear))
        $stmt->bindParam(':MaxYear', $MaxYear);
    if (isset($MinMileage) && is_numeric($MinMileage))
        $stmt->bindParam(':MinMileage', $MinMileage);
    if (isset($MaxMileage) && is_numeric($MaxMileage))
        $stmt->bindParam(':MaxMileage', $MaxMileage);
}
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);



include 'header.php';
?>

</div>
<main>
    <section class="featured-places">
        <div class="container">
            <form action="">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label>Vehicle Type:</label>
                            <select name="CarType" class="form-control">
                                <option value="All">--All--</option>
                                <?php

                                $sql = "SELECT * FROM CarType ";
                                if (isset($Make) && $Make != "All") {
                                    $sql .= " Inner Join cars on CarType.id=CarTypeId";
                                    $sql .= " WHERE Make=:Make";
                                    $sql .= " GROUP BY CarTypeName";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':Make', $Make);
                                } else {
                                    $stmt = $conn->prepare($sql);
                                }
                                $stmt->execute();
                                $Vehicle = $stmt->fetchAll();
                                foreach ($Vehicle as $Veh) {
                                    $string = "<option value='" . $Veh['CarTypeName'] . "'";
                                    if (isset($CarType) && $CarType == $Veh['CarTypeName']) $string .= "selected";
                                    $string .= ">" . $Veh['CarTypeName'] . "</option>";
                                    echo $string;
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label>Make:</label>

                            <select name="Make" onchange="GetDataForMake(this.value)" class="form-control">
                                <option value="All">-- All --</option>
                                <?php
                                $stmt = $conn->prepare("SELECT Make FROM cars GROUP BY Make");
                                $stmt->execute();
                                $makes = $stmt->fetchAll();
                                foreach ($makes as $make) {
                                    $string = "<option value='" . $make['Make'] . "'";
                                    if (isset($Make) && $Make == $make['Make']) $string .= "selected";
                                    $string .= ">" . $make['Make'] . "</option>";
                                    echo $string;
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label>Model:</label>
                            <select name="Model" class="form-control">
                                <option value="All">-- All --</option>
                                <?php
                                $sql = "SELECT Model FROM cars ";
                                if (isset($Make) && $Make != "All") {
                                    $sql .= " WHERE Make = :Make";
                                    $sql .= " GROUP BY Model";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':Make', $Make);
                                } else {

                                    $sql .= " GROUP BY Model";
                                    $stmt = $conn->prepare($sql);
                                }
                                $stmt->execute();
                                $models = $stmt->fetchAll();
                                foreach ($models as $model) {
                                    $string = "<option value='" . $model["Model"] . "'";
                                    if (isset($Model) && $Model == $model["Model"]) $string .= "selected";
                                    $string .= ">" . $model["Model"] . "</option>";
                                    echo $string;
                                }
                                ?>
                            </select>
                        </div>
                    </div>



                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label>Engine size:</label>

                            <select name="EngineSize" class="form-control">
                                <option value="All">-- All --</option>
                                <?php
                                $arr = [];
                                $sql = "SELECT Engine FROM cars ";
                                if (isset($Make) && $Make != "All") {
                                    $sql .= " WHERE Make = :Make";
                                    $sql .= " GROUP BY Engine";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':Make', $Make);
                                } else {
                                    $sql .= " GROUP BY Engine";
                                    $stmt = $conn->prepare($sql);
                                }
                                $stmt->execute();
                                $Engines = $stmt->fetchAll();
                                foreach ($Engines as $engine) $arr[] = ($engine['Engine']);
                                sort($arr, SORT_NUMERIC);
                                foreach ($arr as $EngineSiz) {
                                    $string = "<option value='" . $EngineSiz . "'";
                                    if (isset($EngineSize) && $EngineSize == $EngineSiz) $string .= "selected";
                                    $string .= ">" . $EngineSiz . "</option>";
                                    echo $string;
                                }

                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label>Power:</label>

                            <select name="Power" class="form-control">
                                <option value="All">-- All --</option>
                                <?php
                                $arr = [];
                                $sql = "SELECT EnginePower FROM cars";
                                if (isset($Make) && $Make != "All") {
                                    $sql .= " WHERE Make = :Make";
                                    $sql .= " GROUP BY EnginePower";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':Make', $Make);
                                } else {
                                    $sql .= " GROUP BY EnginePower";
                                    $stmt = $conn->prepare($sql);
                                }
                                $stmt->execute();
                                $EnginePower = $stmt->fetchAll();
                                foreach ($EnginePower as $EnginePowe) $arr[] = ($EnginePowe['EnginePower']);
                                sort($arr, SORT_NUMERIC);
                                foreach ($arr as $EnginePowe) {
                                    $string = "<option value='" . $EnginePowe . "'";
                                    if (isset($Power) && $Power == $EnginePowe) $string .= "selected";
                                    $string .= ">" . $EnginePowe . "</option>";
                                    echo $string;
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label>Fuel:</label>

                            <select name="Fuel" class="form-control">
                                <option value="All">-- All --</option>
                                <?php
                                $sql = "SELECT * FROM fuel ";
                                if (isset($Make) && $Make != "All") {

                                    $sql .= " INNER JOIN cars ON fuel.id = cars.Fuelid";
                                    $sql .= " WHERE Make = :Make";
                                    $sql .= " GROUP BY FuelName";

                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':Make', $Make);
                                } else {
                                    $stmt = $conn->prepare($sql);
                                }
                                $stmt->execute();
                                $Fuels = $stmt->fetchAll();
                                foreach ($Fuels as $fuel) {
                                    $string = "<option value='" . $fuel["FuelName"] . "'";
                                    if (isset($Fuel) && $Fuel == $fuel["FuelName"]) $string .= "selected";
                                    $string .= ">" . $fuel["FuelName"] . "</option>";
                                    echo $string;
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label>Gearbox:</label>

                            <select name="Gearbox" class="form-control">
                                <option value="All">-- All --</option>
                                <?php
                                $sql = "SELECT * FROM gearbox ";
                                if (isset($Make) && $Make != "All") {
                                    $sql .= " INNER JOIN cars ON gearbox.id = cars.GearboxId";
                                    $sql .= " WHERE Make = :Make";
                                    $sql .= " GROUP BY GearboxName";

                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':Make', $Make);
                                } else {
                                    $stmt = $conn->prepare($sql);
                                }
                                $stmt->execute();
                                $Fuels = $stmt->fetchAll();
                                foreach ($Fuels as $fuel) {
                                    $string = "<option value='" . $fuel["GearboxName"] . "'";
                                    if (isset($Gearbox) && $Gearbox == $fuel["GearboxName"]) $string .= "selected";
                                    $string .= ">" . $fuel["GearboxName"] . "</option>";
                                    echo $string;
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label>Color:</label>

                            <select name="Color" class="form-control">
                                <option value="All">-- All --</option>
                                <?php
                                $sql = "SELECT * FROM color";
                                if (isset($Make) && $Make != "All") {
                                    $sql .= " INNER JOIN cars ON Color.id = cars.ColorId";
                                    $sql .= " WHERE Make = :Make";
                                    $sql .= " GROUP BY ColorName";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':Make', $Make);
                                } else {
                                    $stmt = $conn->prepare($sql);
                                }
                                $stmt->execute();
                                $Fuels = $stmt->fetchAll();
                                foreach ($Fuels as $fuel) {
                                    $string = "<option value='" . $fuel["ColorName"] . "'";
                                    if (isset($Fuel) && $Fuel == $fuel["ColorName"]) $string .= "selected";
                                    $string .= ">" . $fuel["ColorName"] . "</option>";
                                    echo $string;
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label>City:</label>

                            <select name="City" class="form-control">
                                <option value="All">-- All --</option>
                                <?php
                                $sql = "SELECT CityName FROM cars INNER JOIN elan";
                                $sql .= " ON cars.id = elan.CarId INNER JOIN city ON elan.CityId = city.id";

                                if (isset($Make) && $Make != "All") {
                                    $sql .= " WHERE Make = :Make";
                                    $sql .= " GROUP BY CityName";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':Make', $Make);
                                } else {
                                    $sql .= " GROUP BY CityName";
                                    $stmt = $conn->prepare($sql);
                                }
                                $stmt->execute();
                                $Cities = $stmt->fetchAll();
                                foreach ($Cities as $city) {
                                    $string = "<option value='" . $city["CityName"] . "'";
                                    if (isset($City) && $City == $city["CityName"]) $string .= "selected";
                                    $string .= ">" . $city["CityName"] . "</option>";
                                    echo $string;
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id=""><label>Set Price:</label></span>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input <?php
                                            if (isset($MinPrice) && is_numeric($MinPrice))
                                                echo 'value="' . $MinPrice . '"';
                                            ?> name="MinPrice" type="number" placeholder="MinPrice" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <input <?php
                                            if (isset($MaxPrice) && is_numeric($MaxPrice))
                                                echo 'value="' . $MaxPrice . '"';
                                            ?> name="MaxPrice" type="number" placeholder="MaxPrice" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id=""><label>Set Mileage:</label></span>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input <?php
                                            if (isset($MinMileage) && is_numeric($MinMileage))
                                                echo 'value="' . $MinMileage . '"';
                                            ?> name="MinMileage" type="number" placeholder="MinMileage" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <input <?php
                                            if (isset($MaxMileage) && is_numeric($MaxMileage))
                                                echo 'value="' . $MaxMileage . '"';
                                            ?> name="MaxMileage" type="number" placeholder="MaxMileage" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <div class="form-group">
                            <label>Set Year:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <select style="margin-bottom:0px!important;" name="MinYear" class="form-control">
                                        <option value="All">Min Year</option>
                                        <?php
                                        $sql = "SELECT Year FROM cars ";
                                        if (isset($Make) && $Make != "All") {
                                            $sql .= " WHERE Make = :Make";
                                            $sql .= " GROUP BY Year";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bindParam(':Make', $Make);
                                        } else {
                                            $sql .= " GROUP BY Year ORDER BY Year ASC";
                                            $stmt = $conn->prepare($sql);
                                        }
                                        $stmt->execute();
                                        $Years = $stmt->fetchAll();
                                        foreach ($Years as $year) {
                                            $string = "<option value='" . $year["Year"] . "'";
                                            if (isset($MinYear) && $MinYear == $year["Year"]) $string .= "selected";
                                            $string .= ">" . $year["Year"] . "</option>";
                                            echo $string;
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">

                                    <select style="margin-bottom:0px!important;" name="MaxYear" class="form-control">
                                        <option value="All">Max Year</option>
                                        <?php
                                        $sql = "SELECT Year FROM cars ";
                                        if (isset($Make) && $Make != "All") {
                                            $sql .= " WHERE Make = :Make";
                                            $sql .= " GROUP BY Year";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bindParam(':Make', $Make);
                                        } else {
                                            $sql .= " GROUP BY Year ORDER BY Year DESC";
                                            $stmt = $conn->prepare($sql);
                                        }
                                        $stmt->execute();
                                        $Years = $stmt->fetchAll();
                                        foreach ($Years as $year) {
                                            $string = "<option value='" . $year["Year"] . "'";
                                            if (isset($MaxYear) && $MaxYear == $year["Year"]) $string .= "selected";
                                            $string .= ">" . $year["Year"] . "</option>";
                                            echo $string;
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="text-center">
                    <input style="margin-top:30px; width:33%;" type="submit" value="Search" class="btn">
                </div>
            </form>

        </div>
    </section>

    <section class="featured-places">
        <div class="container">
            <div class="row" id="allCars">
                <!--  -->
                <?php
                $lastId = 0;
                $favories;
                if (isset($_SESSION['user'])) {
                    $stmt = $conn->prepare("SELECT * FROM `favories` WHERE UserId=:UserId");
                    $stmt->bindParam(":UserId", $_SESSION['user']['id']);
                    $stmt->execute();
                    $favories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }


                foreach ($cars as $key) {
                    $string = '<div  class="col-md-4 col-sm-6 col-xs-12">';
                    $string .= '<div onclick="carDetail(' . $key['id'] . ')" style="cursor:pointer;" class="featured-item">';
                    $string .= '<div class="thumb">';
                    //get image from database
                    $stmt = $conn->prepare("SELECT * FROM images WHERE CarId = :id");
                    $stmt->bindParam(":id", $key["id"]);
                    $stmt->execute();
                    $car = $stmt->fetch();

                    $string .= '<div class="thumb-img">';
                    $string .= '<img style="max-height:300px;min-height:300px;object-fit:cover;" class="MyClass2" src="Car-image/' . $car["Value"] . '" alt="' . $car["Value"] . '">';


                    $string .= '<div  style="top:10px;left:5px;" class="overlay-content">';
                    $string .= '<strong><i class="fa fa-dashboard"></i> ' . $key["Milage"] . 'km</strong> &nbsp;&nbsp;'; // KM gelmelidi
                    $string .= '<strong><i class="fa fa-cube"></i> ' . $key["Engine"] . '</strong>&nbsp;&nbsp;'; //mator gucu
                    $string .= '<strong><i class="fa fa-cog"></i> ' . $key["Gearbox"] . '</strong>&nbsp;&nbsp;'; //gearbox
                    $string .= '<strong><i class="fa fa-map-marker"></i> ' . $key["SellerCity"] . '</strong>&nbsp;'; //City
                    if (isset($favories)) {
                        $check = 0;
                        $style = 'style="font-size:22px; float:right; margin-top:-3px;cursor:pointer;font-weight: bolder;"';
                        foreach ($favories as $favori) {
                            if (isset($_SESSION['user']) && $key['elanid'] == $favori['ElanId']) {
                                $string .= '<a onclick="AddFavorite(this,' . $_SESSION['user']['id'] . ',' . $key['elanid'] . ',1,event)" style="z-index:99" href="javascript:void(0)"><i ' . $style . ' class="fa fa-heart" aria-hidden="true"></i></a>';
                                $check = 1;
                                break;
                            }
                        }
                        if ($check == 0)
                            $string .= '<a onclick="AddFavorite(this,' . $_SESSION['user']['id'] . ',' . $key['elanid'] . ',0,event)" style="z-index:99" href="javascript:void(0)"><i ' . $style . ' class="fa fa-heart-o" aria-hidden="true"></i></a>';
                    }
                    $string .= '</div>';
                    $string .= '</div>';
                    $string .= '</div>';
                    $string .= '<div class="down-content">';
                    $string .= '<h4>' . $key["Make"] . ' ' . $key["Model"] . '</h4>'; // masin adi gelmelidi
                    $string .= '<br>';
                    $IsNew;

                    if ($key["Milage"] > 0)
                        $IsNew = "Used Vehicle";
                    else
                        $IsNew = "New Vehicle";

                    $string .= ' <p>' . $key["EnginePower"] . 'hp / ' . $key["Fuel"] . ' / ' . $key["Year"] . ' / ' . $IsNew . '</p>'; // Mator gucu Benzin Novu il ve teze olup olmamasi gelmelidi
                    $string .= ' <p><span><strong>' . $key["Price"] . ' ' . $key["PriceType"] . '</strong></span>'; //qiymet
                    $string .= '</p>';
                    if (isset($_SESSION['user']) && $key["UserId"] == $_SESSION["user"]["id"]) {
                        $string .= '<div style="display:flex;justify-content: space-evenly;align-items: center;align-content: center;flex-wrap: wrap;">';
                        $string .= '<div class="text-button">';
                        $string .= '<a href="car-details.php?id=' . $key["id"] . '">View More</a>'; // ID gelmelidi
                        $string .= '</div>';
                        $string .= '<button onclick="ShowModal(\'Edit\',' . $key["id"] . ')" value="Edit" class="btn buttons">Edit</button>';
                        $string .= '</div>';
                    } else {
                        $string .= '<div class="text-button">';
                        $string .= '<a href="car-details.php?id=' . $key["id"] . '">View More</a>'; // ID gelmelidi
                        $string .= '</div>';
                    }

                    $string .= '</div>';
                    $string .= '</div>';
                    $string .= '</div>';
                    echo $string;
                    $lastId = $key["id"];
                }
                ?>
            </div>
            <?php

            if (!isset($favorite)) {
            ?>
                <div style="display:flex; justify-content: center;">
                    <button id="loadMore" onclick="LoadMore(<?= $lastId ?>)" value="Load More" class="btn">Load More</button>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
    <script>
        const MakeSelect = document.querySelector("[name = 'Make']");
        const CarTypeSelect = document.querySelector("[name = 'CarType']");
        const ModelSelect = document.querySelector("[name = 'Model']");
        const EngineSizeSelect = document.querySelector("[name = 'EngineSize']");
        const PowerSelect = document.querySelector("[name = 'Power']");
        const FuelSelect = document.querySelector("[name = 'Fuel']");
        const GearBoxSelect = document.querySelector("[name = 'Gearbox']");
        const ColorSelect = document.querySelector("[name = 'Color']");
        const CitySelect = document.querySelector("[name = 'City']");
        const MinYearSelect = document.querySelector("[name = 'MinYear']");
        const MaxYearSelect = document.querySelector("[name = 'MaxYear']");
        const MinPriceSelect = document.querySelector("[name = 'MinPrice']");
        const MaxPriceSelect = document.querySelector("[name = 'MaxPrice']");
        const MinMilageSelect = document.querySelector("[name = 'MinMileage']");
        const MaxMilageSelect = document.querySelector("[name = 'MaxMileage']");

        const UserId = document.getElementById("user").getAttribute("href").split("=")[1];

        function carDetail(id) {
            //send him new blank page
            window.open("car-details.php?id=" + id, '_blank');
        }

        function GetDataForMake(make) {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    function onlyUnique(value, index, self) {
                        return self.indexOf(value) === index;
                    }
                    var response = JSON.parse(this.responseText);

                    let CarType = [];

                    let Years = [];
                    let Cities = [];
                    let models = [];
                    let EngineSize = [];
                    let Power = [];
                    let Fuel = [];
                    let GearBox = [];
                    let Color = [];
                    for (var i = 0; i < response.length; i++) {

                        CarType.push(response[i].CarType);
                        models.push(response[i].Model);
                        EngineSize.push(response[i].Engine);
                        Power.push(response[i].EnginePower);
                        Fuel.push(response[i].Fuel);
                        GearBox.push(response[i].Gearbox);
                        Color.push(response[i].Color);
                        Cities.push(response[i].SellerCity);
                        Years.push(response[i].Year);
                    }

                    CarType = CarType.filter(onlyUnique);
                    models = models.filter(onlyUnique);
                    EngineSize = EngineSize.filter(onlyUnique);
                    Power = Power.filter(onlyUnique);
                    Fuel = Fuel.filter(onlyUnique);
                    GearBox = GearBox.filter(onlyUnique);
                    Color = Color.filter(onlyUnique);
                    Cities = Cities.filter(onlyUnique);
                    Years = Years.filter(onlyUnique);


                    let CarTypeHtml = "<option value='All'>--All--</option>";
                    let modelsHtml = "<option value='All'>--All--</option>";
                    let EngineSizeHtml = "<option value='All'>--All--</option>";
                    let PowerHtml = "<option value='All'>--All--</option>";
                    let FuelHtml = "<option value='All'>--All--</option>";
                    let GearBoxHtml = "<option value='All'>--All--</option>";
                    let ColorHtml = "<option value='All'>--All--</option>";
                    let CityHtml = "<option value='All'>--All--</option>";
                    let MinYearHtml = "<option value='All'>Min Year</option>";
                    let MaxYearHtml = "<option value='All'>Max Year</option>";

                    //remove last 1 char andconvert float array and sort enginesize and power
                    EngineSize = EngineSize.map(function(item) {
                        return parseFloat(String(item).replaceAll(",", "."));
                    });
                    Power = Power.map(function(item) {
                        return parseFloat(String(item).replaceAll(",", "."));
                    });
                    EngineSize.sort(function(a, b) {
                        return a - b;
                    });
                    Power.sort(function(a, b) {
                        return a - b;
                    });

                    //convert again string
                    EngineSize = EngineSize.map(function(item) {
                        return String(item).replaceAll(".", ",") + " L";
                    });
                    Power = Power.map(function(item) {
                        return String(item).replaceAll(".", ",");
                    });



                    for (var i = 0; i < CarType.length; i++)
                        CarTypeHtml += "<option value='" + CarType[i] + "'>" + CarType[i] + "</option>";
                    for (var i = 0; i < models.length; i++)
                        modelsHtml += "<option value='" + models[i] + "'>" + models[i] + "</option>";
                    for (var i = 0; i < EngineSize.length; i++)
                        EngineSizeHtml += "<option value='" + EngineSize[i] + "'>" + EngineSize[i] + "</option>";
                    for (var i = 0; i < Power.length; i++)
                        PowerHtml += "<option value='" + Power[i] + "'>" + Power[i] + "</option>";
                    for (var i = 0; i < Fuel.length; i++)
                        FuelHtml += "<option value='" + Fuel[i] + "'>" + Fuel[i] + "</option>";
                    for (var i = 0; i < GearBox.length; i++)
                        GearBoxHtml += "<option value='" + GearBox[i] + "'>" + GearBox[i] + "</option>";
                    for (var i = 0; i < Color.length; i++)
                        ColorHtml += "<option value='" + Color[i] + "'>" + Color[i] + "</option>";
                    for (var i = 0; i < Cities.length; i++)
                        CityHtml += "<option value='" + Cities[i] + "'>" + Cities[i] + "</option>";

                    //sort years asc
                    Years = Years.sort(function(a, b) {
                        return a - b;
                    });

                    for (var i = 0; i < Years.length; i++)
                        MinYearHtml += "<option value='" + Years[i] + "'>" + Years[i] + "</option>";

                    //sort years desc
                    Years = Years.sort(function(a, b) {
                        return b - a;
                    });
                    for (var i = 0; i < Years.length; i++)
                        MaxYearHtml += "<option value='" + Years[i] + "'>" + Years[i] + "</option>";


                    CarTypeSelect.innerHTML = CarTypeHtml;
                    ModelSelect.innerHTML = modelsHtml;
                    EngineSizeSelect.innerHTML = EngineSizeHtml;
                    PowerSelect.innerHTML = PowerHtml;
                    FuelSelect.innerHTML = FuelHtml;
                    GearBoxSelect.innerHTML = GearBoxHtml;
                    ColorSelect.innerHTML = ColorHtml;
                    CitySelect.innerHTML = CityHtml;
                    MinYearSelect.innerHTML = MinYearHtml;
                    MaxYearSelect.innerHTML = MaxYearHtml;
                }
            };
            xmlhttp.open("GET", "getCars.php?query=" + make, true);
            xmlhttp.send();
        }

        //function loadmore
        const allCars = document.getElementById("allCars");
        let LastId = 0;

        function asyncAjax(url) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: url,
                    type: "GET",
                    beforeSend: function() {},
                    success: function(data) {
                        resolve(data) // Resolve promise and when success
                    }
                });
            });
        }

        async function LoadMore(lastId) {

            if (LastId == 0)
                LastId = lastId;
            else
                lastId = LastId;
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = async function() {
                if (this.readyState == 4 && this.status == 200) {

                    if (this.responseText=='[]') {
                        alert("End Of Cars")
                        document.getElementById("loadMore").style.display = "none";
                        return;
                    }

                    let response = JSON.parse(this.responseText);


                    let html = "";
                    for (var i = 0; i < response.length; i++) {
                        let id = response[i].id;
                        let Make = response[i].Make;
                        let Model = response[i].Model;
                        let Engine = response[i].Engine;
                        let EnginePower = response[i].EnginePower;
                        let Fuel = response[i].Fuel;
                        let Gearbox = response[i].Gearbox;
                        let Color = response[i].Color;
                        let SellerCity = response[i].SellerCity;
                        let Year = response[i].Year;
                        let Price = response[i].Price;
                        let PriceType = response[i].PriceType;
                        let SellerName = response[i].SellerName;
                        let Milage = response[i].Milage;
                        let ElanUserId = response[i].UserId;
                        let elanid = response[i].elanid;

                        await asyncAjax("getCarImage.php?id=" + id).then(function(data) {
                            html = '<div class="col-md-4 col-sm-6 col-xs-12">';
                            html += '<div ';
                            html += 'onclick="carDetail(' + id + ')" style="cursor:pointer;" '
                            html += 'class="featured-item">';
                            html += '<div class="thumb">';
                            html += '<div class="thumb-img">';
                            html += '<img style="max-height:300px;min-height:300px;object-fit:cover;" class="MyClass2" src="Car-image/' + data + '" alt="' + data + '">';
                            html += '</div>';
                            html += '<div style="top:10px;left:5px;" class="overlay-content">';
                            html += '<strong><i class="fa fa-dashboard"></i> ' + Milage + 'km</strong> &nbsp;&nbsp;&nbsp;&nbsp;'; // KM gelmelidi
                            html += '<strong><i class="fa fa-cube"></i> ' + Engine + '</strong>&nbsp;&nbsp;&nbsp;&nbsp;'; //mator gucu
                            html += '<strong><i class="fa fa-cog"></i> ' + Gearbox + '</strong>&nbsp;&nbsp;&nbsp;&nbsp;'; //gearbox
                            html += '<strong><i class="fa fa-map-marker"></i> ' + SellerCity + '</strong>'; //City
                            <?php
                            if (isset($favories)) {
                                $newString = "";
                                $check = 0;
                                $style = 'style="font-size:22px; float:right; margin-top:-3px;cursor:pointer;font-weight: bolder;"';
                                foreach ($favories as $favori) {
                                    if (isset($_SESSION['user']) && $key['elanid'] == $favori['ElanId']) {
                                        $newString .= 'html+= \'<a onclick="AddFavorite(this,' . $_SESSION['user']['id'] . ',' . '\'+elanid+\'' . ',1,event)" style="z-index:99" href="javascript:void(0)"><i ' . $style . ' class="fa fa-heart" aria-hidden="true"></i></a>\';';
                                        $check = 1;
                                        break;
                                    }
                                }
                                if ($check == 0)
                                    $newString .= 'html+=\'<a onclick="AddFavorite(this,' . $_SESSION['user']['id'] . ',' . '\'+elanid+\'' . ',0,event)" style="z-index:99" href="javascript:void(0)"><i ' . $style . ' class="fa fa-heart-o" aria-hidden="true"></i></a>\';';
                                echo $newString . "\n";
                            }
                            ?>
                            html += '</div>';
                            html += '</div>';
                            html += '<div class="down-content">';
                            html += '<h4>' + Make + ' ' + Model + '</h4>'; // masin adi gelmelidi
                            html += '<br>';
                            let IsNew;

                            Milage = parseInt(Milage);
                            if (Milage > 0)
                                IsNew = "Used Vehicle";
                            else
                                IsNew = "New Vehicle";

                            html += ' <p>' + EnginePower + 'hp / ' + Fuel + ' / ' + Year + ' / ' + IsNew + '</p>'; // Mator gucu Benzin Novu il ve teze olup olmamasi gelmelidi
                            html += ' <p><span><strong>' + Price + ' ' + PriceType + '</strong></span>'; //qiymet
                            html += '</p>';

                            if (UserId && ElanUserId == UserId) {
                                html += '<div style="display:flex;justify-content: space-evenly;align-items: center;align-content: center;flex-wrap: wrap;">';
                                html += '<div class="text-button">';
                                html += '<a href="car-details.php?id=' + id + '">View More</a>'; // ID gelmelidi
                                html += '</div>';
                                html += '<button onclick="ShowModal(\'Edit\',' + id + ')" value="Edit" class="btn buttons">Edit</button>';
                                html += '</div>';
                            } else {
                                html += '<div class="text-button">';
                                html += '<a href="car-details.php?id=' + id + '">View More</a>'; // ID gelmelidi
                                html += '</div>';
                            }



                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';

                            LastId = id;


                        }).catch(function(err) {
                            console.log(err);
                        }).finally(function() {
                            allCars.innerHTML += html;
                            realoadEditBtns();
                        });
                    }
                }
            }

            let queryString = "?lastId=" + lastId;
            const Search = window.location.search;
            const urlParams = new URLSearchParams(Search);
            urlParams.forEach((value, key) => {
                queryString += "&" + key + "=" + value;
            })
            xmlhttp.open("GET", "getCarForQuery.php" + queryString, true);
            xmlhttp.send();

        };



        function AddFavorite(element, UserId, elanid, status, event) {
            //stop event
            event.stopImmediatePropagation();
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // alert(this.responseText);
                    // get element child
                    let child = element.children;

                    if (status == 0) {
                        child[0].className = "fa fa-heart";
                        status = 1;
                    } else {
                        child[0].className = "fa fa-heart-o";
                        status = 0;
                    }

                    //remove atribute from element
                    element.removeAttribute("onclick");
                    element.setAttribute("onclick", "AddFavorite(this," + UserId + "," + elanid + "," + status + ",event)");

                }
            }
            xmlhttp.open("GET", "addRemoveFavorite.php?UserId=" + UserId + "&ElanId=" + elanid + "&Status=" + status, true);
            xmlhttp.send();
        }


        realoadEditBtns();

        //add click event all EditBtn
        function realoadEditBtns() {
            let EditBtn = document.querySelectorAll(".buttons");
            for (let i = 0; i < EditBtn.length; i++) {
                EditBtn[i].addEventListener("click", function(e) {
                    e.stopPropagation();
                });
            }
        }
    </script>
</main>

<?php
include "footer.php";
?>