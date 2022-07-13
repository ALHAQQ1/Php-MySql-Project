<?php

session_start();

require_once 'functions.php';
require_once 'db.php';

getParams();

$messageStatus = false;

if (isset($name) && $subject && $message) {
    $sql = 'INSERT INTO `message`(`name`, `subject`, `text`) VALUES (:name, :subject, :message)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':subject', $subject);
    $stmt->bindParam(':message', $message);
    $stmt->execute();
    $messageStatus = true;
}

include 'header.php';

?>
<main>
    <section class="popular-places">
        <div class="container">
            <div class="contact-content">
                <div class="row">
                    <div class="col-md-8">
                        <div class="left-content">
                            <div class="row">
                                <form action="" method="POST">
                                    <div class="col-md-6">
                                        <fieldset>
                                            <input name="name" type="text" class="form-control" id="name" placeholder="Your name..." required="">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset>
                                            <input name="subject" type="text" class="form-control" id="subject" placeholder="Subject..." required="">
                                        </fieldset>
                                    </div>
                                    <div class="col-md-12">
                                        <fieldset>
                                            <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your message..." required=""></textarea>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="submit" value="Send Message" class="btn">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <?php
                                        if ($messageStatus) echo '<div class="alert alert-success">Message sent!</div>';
                                        ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="right-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="content">
                                        <p>Etiam viverra nibh at lorem hendrerit porta non nec ligula. Donec hendrerit porttitor pretium.</p>
                                        <ul>
                                            <li><span>Phone:</span><a href="#">+994 55 844 88 31</a></li>
                                            <li><span>Email:</span><a href="#">Mega.Ceferli@gmail.com</a></li>
                                            <li><span>Address:</span><i class="fa fa-map-marker"></i> Yeni Yasamal/Baku</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include  'footer.php';
?>