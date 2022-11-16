<?php
session_start();
if (!isset($_SESSION["loggedIn"])) {
    header("location: home");
}
$output = "";
// copy test
if (isset($_GET["test"])) {
    $testID = $_GET["test"];
    $output =
        "<script>
            populateCopyTest($testID);
        </script>";
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
    <script src="https://kit.fontawesome.com/fab5bc8fbc.js" crossorigin="anonymous"></script>
    <title>e-learning</title>
    <link rel="stylesheet" href="./assets/styles/newTest_styles.css">
    <link rel="stylesheet" href="./assets/styles/styles.css">
    <script src="./assets/js/newTestFunctions.js"></script>
    <?=$output?>
</head>
<body>
<?php include_once("./assets/screen_modules/header.php") ?>
<div class="newTest">
    <label for="title">Titel: <br>
        <input id="title" type="text" name="title" value="" required maxlength="40" placeholder="Titel van toets..."><br>
    </label>
    <label for="questionAmount">Aantal vragen: <br>
        <input id="questionAmount" onchange="setQuestionAmount(parseInt(this.value));" type="number" name="questionAmount" value="10" required min="1" max="40" step="1"><br>
    </label>
    <div class="questions"></div>
    <button onclick="saveTest();">opslaan</button>
    <p>
        <br>
        Zet in de vraag :antwoord: waar het input element moet komen. <br>
        Als je geen antwoord geeft voor de vraag, wordt de text als uitleg neer gezet. <br>
        Zet in de vragen :nr: wanneer je een nieuwe regel wil.
    </p>
</div>
</body>
</html>