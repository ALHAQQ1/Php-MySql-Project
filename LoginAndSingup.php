<?php
session_start();


require_once 'db.php';
require_once 'functions.php';

getParams();


if ($action == "login") {
    $password = md5($password);
    $sql = "SELECT * FROM user WHERE email=:email OR username=:user AND password=:pass";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':user', $email);
    $stmt->bindParam(':pass', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $_SESSION['user'] = $user;
        echo "Login Successful";
    } else {
        echo "Username or password is incorrect";
    }
} else if ($action == "signup") {

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "email is not valid";
        exit;
    }
    $sql = "SELECT * FROM user WHERE Username=:user";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo "Username is already taken";
        exit;
    }
    //check if email is already taken
    $sql = "SELECT * FROM user WHERE email=:email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo "Email is already taken";
        exit;
    }
    if (strlen($password) < 6) {
        echo "password lenght must be at least 6 characters";
        exit;
    }

    $dir = "User-Profile-Pictures/";
    $file = basename($_FILES["image"]["name"]);
    $path = $dir . $file;

    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));


    $check = getimagesize($_FILES["image"]["tmp_name"]);


    $ok = $check && in_array($ext, ["jpg", "png", "jpeg"]) && $_FILES["image"]["size"] < 5000000;

    if ($ok) {
        move_uploaded_file($_FILES["image"]["tmp_name"], $path);
        $imageName = $username . "." . $ext;
        rename($dir . $file, $dir . $imageName);
    } else {
        echo "Image error";
        $ok = false;
        $imageName = "default.jpg";
    }
    $password = md5($password);
    $sql = "INSERT INTO user (Email, Username, Password, Photo) VALUES (:email, :username, :password, :photo)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':photo', $imageName);
    $stmt->execute();

    echo "Signup Successful";
}
