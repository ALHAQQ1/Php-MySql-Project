<?php

session_start();
require_once 'db.php';
require_once 'functions.php';
getParams();

if (!isset($_SESSION['user'])) {
    echo 'Nice Try :)';
    exit;
}
if (isset($Status)) {
    $string="Added Your Favorites";
    $sql = "";
    if (1 - $Status == 0){
        $sql = "DELETE FROM favories WHERE UserId = :UserId AND ElanId=:ElanId";
        $string="Removed Your Favorites";
    }
    else if (1 - $Status == 1)
        $sql = "INSERT INTO favories (UserId,ElanId) VALUES (:UserId,:ElanId)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':UserId', $_SESSION['user']['id']);
    $stmt->bindParam(':ElanId', $ElanId);
    $stmt->execute();

    echo $string;
}
