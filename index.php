<?php 
session_start();

require_once 'db.php';
require_once 'functions.php';

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
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/login.css">

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <script src="js/selectPlugin.js"></script>
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
                                <?php 
                                //get current page name
                                $current_page = basename($_SERVER['PHP_SELF']);
                                ?>
                                <li><a href="index.php">Home</a></li>

                                <li <?=($current_page=="cars.php")?'class="active"':"" ?> ><a href="cars.php">Cars</a></li>

                                <li <?=($current_page=="about-us.php")?'class="active"':"" ?>><a href="about-us.php">About Us</a></li>

                                <li <?=($current_page=="contact.php")?'class="active"':"" ?>><a class="nav-link" href="contact.php">Contact Us</a></li>
                                <?php
                                if (isset($_SESSION['user']) && $_SESSION['user'] != "") {
                                    //img
                                    echo "<li>";
                                    echo '<img style="object-fit:cover; width:45px;height:45px; border-radius:50%; vertical-align:middle;" src="User-Profile-Pictures/' . $_SESSION['user']['Photo'] . '" alt="user">';
                                    echo "</li>";
                                    echo "<li>";
                                    echo '<a href="" >' . $_SESSION['user']['Username'] . '</a>';
                                    echo "</li>";
                                    // print_r($_SESSION['user']);
                                    echo "<li>";
                                    echo '<a><button onclick="logout()" value="Logout" class="btn">Logout</button></a>';
                                    echo "</li>";
                                } else {
                                    echo "<li>";
                                    echo '<button onclick="ShowModal(this.value)" value="Login" class="btn" id="myBtn">Login</button>';
                                    echo "</li>";
                                }
                                ?>
                            </ul>
                        </nav><!-- / #primary-nav -->
                    </div>
                </div>
            </div>
        </header>
    </div>

    <section class="banner" id="top" style="background-image: url(img/homepage-banner-image-1920x700.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="banner-caption">
                        <div class="line-dec"></div>
                        <h2>Bizimle Elaqe</h2>
                        <div class="blue-button">
                            <a href="contact.php">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="disp-none" id="modalBox">
        <div id='modal'>
        </div>
    </div>
    </section>
    <main>
        <section class="featured-places">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-heading">
                            <span>Featured Cars</span>
                            <h2>Most Viewed Cars</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="featured-item">
                            <div class="thumb">
                                <div class="thumb-img">
                                    <img src="img/product-1-720x480.jpg" alt="">
                                </div>
                                <div class="overlay-content">
                                    <strong><i class="fa fa-dashboard"></i> 130 000km</strong> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong><i class="fa fa-cube"></i> 1800 cc</strong>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong><i class="fa fa-cog"></i> Manual</strong>
                                </div>
                            </div>
                            <div class="down-content">
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>

                                <br>

                                <p>190 hp / Petrol / 2008 / Used vehicle</p>

                                <p><span><del><sup>$</sup>11999.00 </del> <strong><sup>$</sup>11779.00</strong></span></p>

                                <div class="text-button">
                                    <a href="car-details.php?id=1">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="featured-item">
                            <div class="thumb">
                                <div class="thumb-img">
                                    <img src="img/product-2-720x480.jpg" alt="">
                                </div>
                                <div class="overlay-content">
                                    <strong><i class="fa fa-dashboard"></i> 130 000km</strong> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong><i class="fa fa-cube"></i> 1800 cc</strong>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong><i class="fa fa-cog"></i> Manual</strong>
                                </div>
                            </div>
                            <div class="down-content">
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>

                                <br>

                                <p>190 hp / Petrol / 2008 / Used vehicle</p>

                                <p><span><del><sup>$</sup>11999.00 </del> <strong><sup>$</sup>11779.00</strong></span></p>

                                <div class="text-button">
                                    <a href="car-details.php">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="featured-item">
                            <div class="thumb">
                                <div class="thumb-img">
                                    <img src="img/product-3-720x480.jpg" alt="">
                                </div>
                                <div class="overlay-content">
                                    <strong><i class="fa fa-dashboard"></i> 130 000km</strong> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong><i class="fa fa-cube"></i> 1800 cc</strong>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong><i class="fa fa-cog"></i> Manual</strong>
                                </div>
                            </div>
                            <div class="down-content">
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>

                                <br>

                                <p>190 hp / Petrol / 2008 / Used vehicle</p>

                                <p><span><del><sup>$</sup>11999.00 </del> <strong><sup>$</sup>11779.00</strong></span></p>

                                <div class="text-button">
                                    <a href="car-details.php">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="featured-item">
                            <div class="thumb">
                                <div class="thumb-img">
                                    <img src="img/product-4-720x480.jpg" alt="">
                                </div>
                                <div class="overlay-content">
                                    <strong><i class="fa fa-dashboard"></i> 130 000km</strong> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong><i class="fa fa-cube"></i> 1800 cc</strong>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong><i class="fa fa-cog"></i> Manual</strong>
                                </div>
                            </div>
                            <div class="down-content">
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>

                                <br>

                                <p>190 hp / Petrol / 2008 / Used vehicle</p>

                                <p><span><del><sup>$</sup>11999.00 </del> <strong><sup>$</sup>11779.00</strong></span></p>

                                <div class="text-button">
                                    <a href="car-details.html">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="featured-item">
                            <div class="thumb">
                                <div class="thumb-img">
                                    <img src="img/product-5-720x480.jpg" alt="">
                                </div>
                                <div class="overlay-content">
                                    <strong><i class="fa fa-dashboard"></i> 130 000km</strong> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong><i class="fa fa-cube"></i> 1800 cc</strong>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong><i class="fa fa-cog"></i> Manual</strong>
                                </div>
                            </div>
                            <div class="down-content">
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>

                                <br>

                                <p>190 hp / Petrol / 2008 / Used vehicle</p>

                                <p><span><del><sup>$</sup>11999.00 </del> <strong><sup>$</sup>11779.00</strong></span></p>

                                <div class="text-button">
                                    <a href="car-details.html">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="featured-item">
                            <div class="thumb">
                                <div class="thumb-img">
                                    <img src="img/product-6-720x480.jpg" alt="">
                                </div>
                                <div class="overlay-content">
                                    <strong><i class="fa fa-dashboard"></i> 130 000km</strong> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong><i class="fa fa-cube"></i> 1800 cc</strong>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong><i class="fa fa-cog"></i> Manual</strong>
                                </div>
                            </div>
                            <div class="down-content">
                                <h4>Lorem ipsum dolor sit amet, consectetur</h4>

                                <br>

                                <p>190 hp / Petrol / 2008 / Used vehicle</p>

                                <p><span><del><sup>$</sup>11999.00 </del> <strong><sup>$</sup>11779.00</strong></span></p>

                                <div class="text-button">
                                    <a href="car-details.html">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="video-container">
            <div class="video-overlay"></div>
            <div class="video-content">
                <div class="inner">
                    <div class="section-heading">
                        <span>Contact Us</span>
                        <h2>Vivamus nec vehicula felis</h2>
                    </div>
                    <!-- Modal button -->

                    <div class="blue-button">
                        <a href="contact.php">Talk to us</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php 
include 'footer.php'
?>