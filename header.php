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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body>
    <div class="wrap">
        <header id="header">
            <div class="container">
                <div class="row" >
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

                                <li <?= ($current_page == "cars.php") ? 'class="active"' : "" ?>><a href="cars.php">Cars</a></li>

                                <li <?= ($current_page == "about-us.php") ? 'class="active"' : "" ?>><a href="about-us.php">About Us</a></li>

                                <li <?= ($current_page == "contact.php") ? 'class="active"' : "" ?>><a class="nav-link" href="contact.php">Contact Us</a></li>
                                <?php
                                if (isset($_SESSION['user']) && $_SESSION['user'] != "") {
                                    //img
                                    echo "<li>";
                                    echo '<img style="object-fit:cover; width:45px;height:45px; border-radius:50%; vertical-align:middle;" src="User-Profile-Pictures/' . $_SESSION['user']['Photo'] . '" alt="user">';
                                    echo "</li>";
                                    echo "<li>";
                                    echo '<a id="user" href="cars.php?UserId=' . $_SESSION['user']['id'] . '" >' . $_SESSION['user']['Username'] . '</a>';
                                    echo "</li>";
                                    echo "<li>";
                                    echo '<a href="cars.php?favorite=1"><i style="font-size:20px;" class="fa fa-heart" aria-hidden="true"></i></a>';
                                    echo "</li>";
                                    // print_r($_SESSION['user']);
                                    echo "<li>";
                                    echo '<a><button style="width:105px"; onclick="logout()" value="Logout" class="btn">Logout</button></a>';
                                    echo "</li>";
                                    echo "<li>";
                                    echo '<button style="width:105px"; onclick="ShowModal(\'AddCar\')" value="AddCar" class="btn">Add new Car</button>';
                                    echo "</li>";
                                } else {
                                    echo "<li>";
                                    echo '<button onclick="ShowModal(\'Login\')" value="Login" class="btn" id="myBtn">Login</button>';
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
    <div class="disp-none" id="modalBox">
        <div id='modal'>
        </div>
    </div>