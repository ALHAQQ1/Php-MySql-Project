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
                                <li><a href="cars.php"><i class="fa fa-stop"></i>Cars</a></li>
                                <li><a href="about-us.php"><i class="fa fa-stop"></i>About</a></li>
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
                        <li><span>Email:</span><a href="#">Mega.Ceferli@gmail.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="sub-footer">
    <p>Copyright © 2022 Nejat Jafarli</p>
</div>
<!-- <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
    </script> -->

<script src="js/vendor/bootstrap.min.js"></script>

<script src="js/datepicker.js"></script>
<script src="js/plugins.js"></script>
<script src="js/main.js"></script>
<script src="js/modal.js"></script>
<script src="js/login.js"></script>
<script src="js/AddCar.js"></script>
<script>
    function logout() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200)
            //send cars.php
            window.location.href = "cars.php";
        };
        xmlhttp.open("GET", "logout.php", true);
        xmlhttp.send();
    }

</script>

</body>

</html>