<?php
session_start();

require_once 'db.php';
require_once 'functions.php';

getParams();
if (isset($id)) {

    $sql  = " SELECT cars.id as id,UserId,elan.id as elanid,ColorName as Color,";
    $sql .= " CarTypeName as CarType,FuelName as Fuel,GearboxName as Gearbox,Make,Model,Year,Engine,EnginePower,MillAge as Milage";
    $sql .= " ,Price,PriceType,IsSalon,Description,CityName as SellerCity,SellerName ";
    $sql .= " FROM cars,elan,City,gearbox,fuel,color,carType WHERE ";
    $sql .= " cars.id = elan.CarId ";
    $sql .= " AND elan.CityId = City.id";
    $sql .= " AND cars.GearboxId = Gearbox.id";
    $sql .= " AND cars.Fuelid = Fuel.id";
    $sql .= " AND cars.ColorId = Color.id";
    $sql .= " AND cars.CarTypeId = CarType.id";
    $sql .= " AND cars.id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM `extras` WHERE extras.CarId=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $extras = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //get images
    $sql = "SELECT * FROM `images` WHERE images.CarId=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //get contact
    $sql = "SELECT * FROM `contacts` WHERE contacts.CarId=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $contact = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

include 'header.php';
?>

    <main>
        <section class="featured-places">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div>
                            <img id="head-image" src="Car-image/<?= $images[0]["Value"] ?>" alt="" class="img-responsive wc-image">
                        </div>
                        <br>
                        <div class="row" style="display:flex; flex-wrap: wrap;">
                            <!--images  -->
                            <?php
                            foreach ($images as $key) {

                                $string = '<div class="col-sm-4 col-xs-6">';
                                $string .= '<div class="form-group">';
                                $string .= '<img class="MyClass"  src="Car-image/' . $key["Value"] . '" alt="" class="img-responsive ';
                                $string .= '"/>';
                                $string .= '</div>';
                                $string .= '</div>';

                                echo $string;
                            }

                            ?>
                            <!--  -->
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <form action="#" method="post" class="form">
                            <h2><strong class="text-primary"><?= $car["Price"] . " " . $car["PriceType"] ?></strong></h2>

                            <br>

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="clearfix">
                                        <span class="pull-left">Type</span>

                                        <strong class="pull-right"><?= $car["CarType"] ?></strong>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="clearfix">
                                        <span class="pull-left">Make</span>

                                        <strong class="pull-right"><?= $car["Make"] ?></strong>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="clearfix">
                                        <span class="pull-left"> Model</span>

                                        <strong class="pull-right"><?= $car["Model"] ?></strong>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="clearfix">
                                        <span class="pull-left">Mileage</span>

                                        <strong class="pull-right"><?= $car["Milage"] ?></strong>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="clearfix">
                                        <span class="pull-left">Fuel</span>

                                        <strong class="pull-right"><?= $car["Fuel"] ?></strong>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="clearfix">
                                        <span class="pull-left">Engine size</span>

                                        <strong class="pull-right"><?= $car["Engine"] ?></strong>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="clearfix">
                                        <span class="pull-left">Power</span>

                                        <strong class="pull-right"><?= $car["EnginePower"] . " hp" ?></strong>
                                    </div>
                                </li>


                                <li class="list-group-item">
                                    <div class="clearfix">
                                        <span class="pull-left">Gearbox</span>

                                        <strong class="pull-right"><?= $car["Gearbox"] ?></strong>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="clearfix">
                                        <span class="pull-left">Color</span>

                                        <strong class="pull-right"><?= $car["Color"] ?></strong>
                                    </div>
                                </li>
                            </ul>

                            <div class="accordions">
                                <ul class="accordion">
                                    <li>
                                        <a class="accordion-trigger">Vehicle Extras</a>
                                        <div class="accordion-content">
                                            <div class="row">
                                                <!-- Extras -->
                                                <?php
                                                foreach ($extras as $key) {
                                                    $string = '<div class="col-sm-6 col-xs-12">';
                                                    $string .= '<p>';
                                                    $string .= $key["Value"];; //Value
                                                    $string .= '</p>';
                                                    $string .= '</div>';

                                                    echo $string;
                                                }
                                                ?>
                                                <!-- Extras -->
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="accordion-trigger">Vehicle Description</a>
                                        <div class="accordion-content">
                                            <?php
                                            echo nl2br($car["Description"]);
                                            ?>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="accordion-trigger">Contact Details</a>

                                        <div class="accordion-content">

                                            <p>
                                                <span>Name</span>

                                                <br>
                                                <?php

                                                if ($car["IsSalon"] == 0) {
                                                ?>
                                                    <strong><?= $car["SellerName"] ?></strong>
                                                <?php
                                                } else echo "<strong><a href='http://localhost/car/cars.php?SellerName=" . $car["SellerName"] . "'>" . $car["SellerName"] . "</a></strong>";
                                                ?>

                                            </p>
                                            <p>
                                                <span>Phone</span>

                                                <br>

                                                <?php

                                                if ($car["IsSalon"] == 0) {
                                                ?>
                                                    <strong>
                                                        <a href="tel:<?= $contact[0]["PhoneNumber"] ?>"><?= $contact[0]["PhoneNumber"] ?></a>
                                                    </strong>
                                                <?php
                                                } else {
                                                    foreach ($contact as $key) {
                                                        $string = "<strong>";
                                                        $string .= '<a href="' . $key["PhoneNumber"] . '">' . $key["PhoneNumber"] . '</a>';
                                                        $string .= "</strong>";
                                                        $string .= "<br/>";
                                                        echo $string;
                                                    }
                                                }

                                                ?>
                                            </p>
                                            <p>
                                                <span>City</span>

                                                <br>

                                                <strong><?= $car["SellerCity"] ?></strong>
                                            </p>

                                        </div>
                                    </li>
                                </ul> <!-- / accordion -->
                            </div>
                        </form>
                    </div>
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
                        <p>Mauris sit amet quam congue, pulvinar urna et, congue diam. Suspendisse eu lorem massa. Integer sit amet posuere tellustea dictumst.</p>
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
                                    <li><a href="inde.html"><i class="fa fa-stop"></i>Home</a></li>
                                    <li><a href="about.html"><i class="fa fa-stop"></i>About</a></li>
                                    <li><a href="team.html"><i class="fa fa-stop"></i>Team</a></li>
                                    <li><a href="contact.html"><i class="fa fa-stop"></i>Contact Us</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    <li><a href="faq.html"><i class="fa fa-stop"></i>FAQ</a></li>
                                    <li><a href="testimonials.html"><i class="fa fa-stop"></i>Testimonials</a></li>
                                    <li><a href="blog.html"><i class="fa fa-stop"></i>Blog</a></li>
                                    <li><a href="terms.html"><i class="fa fa-stop"></i>Terms</a></li>
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
                        <p><i class="fa fa-map-marker"></i> 212 Barrington Court New York, ABC</p>
                        <ul>
                            <li><span>Phone:</span><a href="#">+1 333 4040 5566</a></li>
                            <li><span>Email:</span><a href="#">contact@company.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script>
        const mainImg = document.getElementById("head-image");
        const Images = document.querySelectorAll('.MyClass');
        Images[0].classList.add("actived");

        Images.forEach(x => {
            x.addEventListener('click', function() {
                mainImg.src = this.src;
                Images.forEach(y => {
                    y.classList.remove("actived");
                });
                this.classList.add("actived");
            });
        });
    </script>
   <?php 
   include "footer.php";
   ?>