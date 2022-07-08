<?php

use function PHPSTORM_META\sql_injection_subst;

require_once 'db.php';
require_once 'functions.php';

getParams();

$sql = "SELECT * FROM `car`";

if (isset($SellerName)) {
    $sql = "SELECT * FROM car WHERE SellerName = :SellerName";
    $sql .= " ORDER BY Views DESC";
    $sql .= " LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':SellerName', $SellerName);
} else {
    include 'getCarForQuery.php';
    $sql .= " ORDER BY Views DESC";
    $sql .= " LIMIT 50";
    $stmt = $conn->prepare($sql);

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
}
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Car Dealer</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/hero-slider.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/style.css">

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>

    <div class="wrap">
        <header id="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <button id="primary-nav-button" type="button">Menu</button>
                        <a href="index.php">
                            <div class="logo">
                                <img src="img/logo.png" alt="Venue Logo">
                            </div>
                        </a>
                        <nav id="primary-nav" class="dropdown cf">
                            <ul class="dropdown menu">
                                <li><a href="index.php">Home</a></li>

                                <li class='active'><a href="cars.php">Cars</a></li>

                                <li><a href="about-us.html">About Us</a></li>

                                <li><a class="nav-link" href="contact.php">Contact Us</a></li>
                            </ul>
                        </nav><!-- / #primary-nav -->
                    </div>
                </div>
            </div>
        </header>
    </div>

    <section class="banner banner-secondary" id="top" style="background-image: url(img/banner-image-1-1920x300.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <div class="line-dec"></div>
                        <h2>Cars</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <section class="featured-places">
            <div class="container">
                <form action="">
                    <div class="row">

                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Vehicle Type:</label>

                                <select name="CarType" class="form-control">
                                    <option value="All">--All--</option>
                                    <?php

                                    $sql = "SELECT CarType FROM car ";
                                    if (isset($Make) && $Make!="All") {
                                        $sql .= " WHERE Make = :Make";
                                        $sql .= " GROUP BY CarType";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bindParam(':Make', $Make);
                                    } else {
                                        $sql .= " GROUP BY CarType";
                                        $stmt = $conn->prepare($sql);
                                    }
                                    $stmt->execute();
                                    $Vehicle = $stmt->fetchAll();
                                    foreach ($Vehicle as $Veh) {
                                        $string = "<option value='" . $Veh['CarType'] . "'";
                                        if (isset($CarType) && $CarType == $Veh['CarType']) $string .= "selected";
                                        $string .= ">" . $Veh['CarType'] . "</option>";
                                        echo $string;
                                    }
                                    ?>

                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Make:</label>

                                <select name="Make" onchange="GetDataForMake(this.value)" class="form-control">
                                    <option value="All">-- All --</option>
                                    <?php
                                    $stmt = $conn->prepare("SELECT Make FROM car GROUP BY Make");
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

                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Model:</label>
                                <select name="Model" class="form-control">
                                    <option value="All">-- All --</option>
                                    <?php
                                    $sql = "SELECT Model FROM car ";
                                    if (isset($Make) && $Make!="All") {
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



                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Engine size:</label>

                                <select name="EngineSize" class="form-control">
                                    <option value="All">-- All --</option>
                                    <?php
                                    $arr = [];
                                    $sql = "SELECT Engine FROM car ";
                                    if (isset($Make) && $Make!="All") {
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

                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Power:</label>

                                <select name="Power" class="form-control">
                                    <option value="All">-- All --</option>
                                    <?php
                                    $arr = [];
                                    $sql = "SELECT EnginePower FROM car";
                                    if (isset($Make) && $Make!="All") {
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

                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Fuel:</label>

                                <select name="Fuel" class="form-control">
                                    <option value="All">-- All --</option>
                                    <?php
                                    $sql = "SELECT fuel FROM car ";
                                    if (isset($Make) && $Make!="All") {
                                        $sql .= " WHERE Make = :Make";
                                        $sql .= " GROUP BY fuel";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bindParam(':Make', $Make);
                                    } else {
                                        $sql .= " GROUP BY fuel";
                                        $stmt = $conn->prepare($sql);
                                    }
                                    $stmt->execute();
                                    $Fuels = $stmt->fetchAll();
                                    foreach ($Fuels as $fuel) {
                                        $string = "<option value='" . $fuel["fuel"] . "'";
                                        if (isset($Fuel) && $Fuel == $fuel["fuel"]) $string .= "selected";
                                        $string .= ">" . $fuel["fuel"] . "</option>";
                                        echo $string;
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Gearbox:</label>

                                <select name="Gearbox" class="form-control">
                                    <option value="All">-- All --</option>
                                    <option value="Mexaniki" <?php echo (isset($GearBox) && $GearBox == "Mexaniki") ? "Selected" : ""; ?>>Mexaniki</option>
                                    <option value="Avtomat" <?php echo (isset($GearBox)  && $GearBox == "Avtomat") ? "Selected" : ""; ?>>Avtomat</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Color:</label>

                                <select name="Color" class="form-control">
                                    <option value="All">-- All --</option>
                                    <?php
                                    $sql = "SELECT Color FROM car ";
                                    if (isset($Make) && $Make!="All") {
                                        $sql .= " WHERE Make = :Make";
                                        $sql .= " GROUP BY Color";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bindParam(':Make', $Make);
                                    } else {
                                        $sql .= " GROUP BY Color";
                                        $stmt = $conn->prepare($sql);
                                    }
                                    $stmt->execute();
                                    $Colors = $stmt->fetchAll();
                                    foreach ($Colors as $color) {
                                        $string = "<option value='" . $color["Color"] . "'";
                                        if (isset($Color) && $Color == $color["Color"]) $string .= "selected";
                                        $string .= ">" . $color["Color"] . "</option>";
                                        echo $string;
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Price:</label>

                                <select class="form-control">
                                    <option value="">-- All --</option>
                                    <option value="">-- All --</option>
                                    <option value="">-- All --</option>
                                    <option value="">-- All --</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Mileage:</label>

                                <select class="form-control">
                                    <option value="">-- All --</option>
                                    <option value="">-- All --</option>
                                    <option value="">-- All --</option>
                                    <option value="">-- All --</option>
                                </select>
                            </div>
                        </div> -->
                    </div>
                    <div class="text-center ">
                        <input type="submit" value="Search" class="btn btn-primary btn-lg">
                    </div>
                </form>
            </div>
        </section>

        <section class="featured-places">
            <div class="container">
                <div class="row">
                    <!--  -->
                    <?php
                    foreach ($cars as $key) {
                        $string = '<div class="col-md-4 col-sm-6 col-xs-12">';
                        $string .= '<div class="featured-item">';
                        $string .= '<a href="car-details.php?id=' . $key["id"] . '">'; // bu id deyismelidi
                        $string .= '<div class="thumb">';
                        $string .= '<div class="thumb-img">';


                        //get image from database
                        $stmt = $conn->prepare("SELECT * FROM images WHERE CarId = :id");
                        $stmt->bindParam(":id", $key["id"]);
                        $stmt->execute();
                        $car = $stmt->fetch();

                        $string .= '<img class="MyClass2" src="Car-image/' . $car["Value"] . '" alt="' . $car["Value"] . '">';
                        $string .= '</div>';
                        $string .= '<div class="overlay-content">';
                        $string .= '<strong><i class="fa fa-dashboard"></i> ' . $key["Milage"] . 'km</strong> &nbsp;&nbsp;&nbsp;&nbsp;'; // KM gelmelidi
                        $string .= '<strong><i class="fa fa-cube"></i> ' . $key["Engine"] . '</strong>&nbsp;&nbsp;&nbsp;&nbsp;'; //mator gucu
                        $string .= '<strong><i class="fa fa-cog"></i> ' . $key["Gearbox"] . '</strong>&nbsp;&nbsp;&nbsp;&nbsp;'; //gearbox
                        $string .= '<strong><i class="fa fa-map-marker"></i> ' . $key["SellerCity"] . '</strong>'; //City
                        $string .= '</div>';
                        $string .= '</div>';
                        $string .= '</a>';
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
                        $string .= '<div class="text-button">';
                        $string .= '<a href="car-details.php?id=' . $key["id"] . '">View More</a>'; // ID gelmelidi
                        $string .= '</div>';
                        $string .= '</div>';
                        $string .= '</div>';
                        $string .= '</div>';
                        echo $string;
                    }

                    ?>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="about-veno">
                        <div class="logo">
                            <img src="img/footer_logo.png" alt="Venue Logo">
                        </div>
                        <p>Mauris sit amet quam congue, pulvinar urna et, congue diam. Suspendisse eu lorem massa.
                            Integer sit amet posuere tellustea dictumst.</p>
                        <ul class="social-icons">
                            <li>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="useful-links">
                        <div class="footer-heading">
                            <h4>Useful Links</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <ul>
                                    <li><a href="index.php"><i class="fa fa-stop"></i>Home</a></li>
                                    <li><a href="cars.php"><i class="fa fa-stop"></i>Cars</a></li>
                                    <li><a href="about-us.html"><i class="fa fa-stop"></i>About</a></li>
                                    <li><a href="contact.php"><i class="fa fa-stop"></i>Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="contact-info">
                        <div class="footer-heading">
                            <h4>Contact Information</h4>
                        </div>
                        <p><i class="fa fa-map-marker"></i>Yeni Yasamal/Baku</p>
                        <ul>
                            <li><span>Phone:</span><a href="#">+994 55 844 88 31</a></li>
                            <li><span>Email:</span><a href="#">Mega.Cferli@gmail.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <div class="sub-footer">
        <p>Copyright © 2022 Nejat Jafarli</p>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>
    <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
    </script>

    <script src="js/vendor/bootstrap.min.js"></script>

    <script src="js/datepicker.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script>
        function GetDataForMake(make) {
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    function onlyUnique(value, index, self) {
                        return self.indexOf(value) === index;
                    }
                    console.log(this.responseText);
                    var response = JSON.parse(this.responseText);

                    let CarType = [];
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
                        GearBox.push(response[i].GearBox);
                        Color.push(response[i].Color);
                    }

                    CarType = CarType.filter(onlyUnique);
                    models = models.filter(onlyUnique);
                    EngineSize = EngineSize.filter(onlyUnique);
                    Power = Power.filter(onlyUnique);
                    Fuel = Fuel.filter(onlyUnique);
                    GearBox = GearBox.filter(onlyUnique);
                    Color = Color.filter(onlyUnique);

                    let CarTypeSelect = document.querySelector("[name = 'CarType']");
                    let ModelSelect = document.querySelector("[name = 'Model']");
                    let EngineSizeSelect = document.querySelector("[name = 'EngineSize']");
                    let PowerSelect = document.querySelector("[name = 'Power']");
                    let FuelSelect = document.querySelector("[name = 'Fuel']");
                    let GearBoxSelect = document.querySelector("[name = 'GearBox']");
                    let ColorSelect = document.querySelector("[name = 'Color']");

                    let CarTypeHtml = "<option value='All'>--All--</option>";
                    let modelsHtml = "<option value='All'>--All--</option>";
                    let EngineSizeHtml = "<option value='All'>--All--</option>";
                    let PowerHtml = "<option value='All'>--All--</option>";
                    let FuelHtml = "<option value='All'>--All--</option>";
                    let GearBoxHtml = "<option value='All'>--All--</option>";
                    let ColorHtml = "<option value='All'>--All--</option>";

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

                    CarTypeSelect.innerHTML = CarTypeHtml;
                    ModelSelect.innerHTML = modelsHtml;
                    EngineSizeSelect.innerHTML = EngineSizeHtml;
                    PowerSelect.innerHTML = PowerHtml;
                    FuelSelect.innerHTML = FuelHtml;
                    GearBoxSelect.innerHTML = GearBoxHtml;
                    ColorSelect.innerHTML = ColorHtml;

                }
            };
            xmlhttp.open("GET", "getCars.php?query=" + make, true);
            xmlhttp.send();
        }
    </script>
</body>

</html>