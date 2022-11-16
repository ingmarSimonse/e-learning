<?php
require_once "../config.php";

session_start();

if (isset($_POST["login"])) {
    login();
} elseif (isset($_POST["register"])) {
    register();
} elseif (isset($_POST["logOut"])) {
    logOut();
} else {
    header("location: home");
}



function register() {
    global $conn;
    $returnArr = array();

    $checkUsername = strval($_POST["username"]);
    $checkUsername = $conn -> real_escape_string($checkUsername);
    $checkUsername = htmlspecialchars($checkUsername);
    // check if username exists
    $result = $conn->query("SELECT `name` FROM `e-learning_user` WHERE EXISTS (SELECT `name` FROM `e-learning_user` WHERE `name` = '$checkUsername')");
    if (empty($result->num_rows)) {
        array_push($returnArr, true);
    } else {
        array_push($returnArr, false);
    }

    if ($returnArr[0]) {
        array_push($returnArr, checkEmail());
    }

    // hash password
    if ($returnArr[0]) {
        if (!$returnArr[1]) {
            $hashedPass = password_hash($_POST["password"], PASSWORD_DEFAULT);
            // push user to db
            $name = strval($_POST["username"]);
            $email = strval($_POST["email"]);
            $name = $conn -> real_escape_string($name);
            $name = htmlspecialchars($name);
            $email = $conn -> real_escape_string($email);
            $email = htmlspecialchars($email);
            $conn->query("INSERT INTO `e-learning_user` (`ID`, `name`, `email`, `password`)
                            VALUES (NULL, '$name', '$email', '$hashedPass')");

            saveUserInSession($email);
        }
    }

    echo json_encode($returnArr);
}

function login() {
    global $conn;
    $returnArr = array();

    array_push($returnArr, checkEmail());

    if ($returnArr[0]) {
        $passwordArray = array();
        $email = strval($_POST["email"]);
        $email = $conn -> real_escape_string($email);
        $email = htmlspecialchars($email);
        // get password from email
        $result = $conn->query("SELECT `password` FROM `e-learning_user` WHERE `email` = '$email'");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array()) {
                array_push($passwordArray, $row);
            }
        }

        // password verify
        if (password_verify($_POST["password"], $passwordArray[0]["password"])) {
            array_push($returnArr, true);
            saveUserInSession($email);
        } else {
            array_push($returnArr, false);
        }

    } else {
        array_push($returnArr, false);
    }

    echo json_encode($returnArr);
}

function checkEmail() {
    global $conn;
    $checkEmail = strval($_POST["email"]);
    $checkEmail = $conn -> real_escape_string($checkEmail);
    $checkEmail = htmlspecialchars($checkEmail);
    // check if email exists
    $result = $conn->query("SELECT `email` FROM `e-learning_user` WHERE EXISTS (SELECT `email` FROM `e-learning_user` WHERE `email` = '$checkEmail')");
    if (empty($result->num_rows)) {
        return false;
    } else {
        return true;
    }
}

function saveUserInSession($email) {
    global $conn;
    // save user in session
    $result = $conn->query("SELECT `ID` FROM `e-learning_user` WHERE `email` = '$email'");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            $_SESSION["loggedIn"] = $row[0];
        }
    }
}

function logOut() {
    session_destroy();
}