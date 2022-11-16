<?php
session_start();
if (isset($_SESSION["loggedIn"])) {
    header("location: home");
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
    <link rel="stylesheet" href="./assets/styles/styles.css">
    <link rel="stylesheet" href="./assets/styles/login_styles.css">
    <script src="./assets/js/loginFunctions.js"></script>
</head>
<body>
<?php include_once("./assets/screen_modules/header.php") ?>
<div class="content">
    <button id="btnChangeForm" onclick="changeForm();">Registreer</button>
    <form id="frmLogin" action="#" method="post" onsubmit="frmLogin_Submit(this); return false;">
        <label for="email">E-mail: <br>
            <input type="email" name="email" value="" required maxlength="50" placeholder="Vul hier je E-mail in..."><br>
        </label>
        <label for="password">Wachtwoord: <br>
            <input type="password" name="password" value="" required maxlength="50"><br>
        </label>
        <input type="submit" value="Log in">
    </form>
    <form id="frmRegister" class="hidden" action="#" method="post" onsubmit="frmRegister_Submit(this); return false;">
        <label for="username">Gebruikersnaam: <br>
            <input type="text" name="username" value="" required maxlength="20" placeholder="Vul hier je Gebruikersnaam in..."><br>
        </label>
        <label for="email">E-mail: <br>
            <input type="email" name="email" value="" required maxlength="50" placeholder="Vul hier je E-mail in..."><br>
        </label>
        <label for="password">Wachtwoord: <br>
            <input type="password" name="password" value="" required maxlength="50"><br>
        </label>
        <input type="submit" value="Registreer">
    </form>
</div>
</body>
</html>
