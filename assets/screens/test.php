<?php
session_start();
$testID = $_GET["test"];
$output =
    "<script>
        getQuestions($testID)
    </script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fab5bc8fbc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/styles/styles.css">
    <link rel="stylesheet" href="./assets/styles/test_styles.css">
    <script src="./assets/js/testFunctions.js"></script>
    <?=$output?>
    <title>e-learning</title>
</head>
<body id="body">
<div class="questions"></div>
<button onclick="nextPage();">volgende</button>
<div id="correctAnswer"></div>
</body>
</html>
