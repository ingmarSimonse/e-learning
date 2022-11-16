<?php
session_start();
$output = "";
if (isset($_SESSION["loggedIn"])) {
    $output = "<div class='logOut' onclick='logOut();'>uitloggen</div> <a href='./nieuwe_toets' target='_self'>nieuwe toets</a>";
} else {
    $output = "<a href='./inloggen' target='_self'>inloggen</a>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html;" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/styles/styles.css">
    <link rel="stylesheet" href="./assets/styles/home_styles.css">
    <script src="https://kit.fontawesome.com/fab5bc8fbc.js" crossorigin="anonymous"></script>
    <script src="./assets/js/homeFunctions.js"></script>
    <title>e-learning</title>
</head>
<body>
<?php include_once("./assets/screen_modules/header.php") ?>
<div class="content">
    <?=$output?>
    <div class="tests">

    </div>
</div>
</body>
</html>
