<?php


require_once 'db.php';
require_once 'functions.php';

getParams();
if (isset($id)) {

    $sql = "SELECT * FROM `car` WHERE car.id=:id LIMIT 1";
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
                        <h2>MAŞIN ALQI SATQISI ELANLARI</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
    </footer>

    <div class="sub-footer">
        <p>Copyright © 2020 Company Name - Template by: <a href="https://www.phpjabbers.com/">PHPJabbers.com</a></p>
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
</body>

</html>