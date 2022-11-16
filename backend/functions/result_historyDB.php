<?php
require_once "../config.php";

session_start();

if (isset($_POST["pushResult"])) {
    pushResult();
} else {
    header("location: home");
}



function pushResult() {
    global $conn;

    // push result if user logged in
    if (isset($_SESSION["loggedIn"])) {
        $userID = $_SESSION["loggedIn"];
        $testID = $_POST["testID"];
        $grade = $_POST["grade"];
        $conn->query("INSERT INTO `e-learning_result_history` (`ID`, `grade`, `testID`, `userID`)
                            VALUES (NULL, $grade, $testID, $userID)");
    }
}