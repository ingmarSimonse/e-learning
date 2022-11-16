<?php
// Haal URI op, en haal onze scriptnaam eraf
$_GET['basepath'] = dirname($_SERVER['PHP_SELF']);
if ($_GET['basepath'] == "/" || $_GET['basepath'] == "\\") {
    $_GET['basepath'] =  "";
}
$_GET['imgpath'] = dirname(dirname($_SERVER['PHP_SELF']));
$uri = substr($_SERVER['REQUEST_URI'], strlen($_GET['basepath']));

// Controleer of er een querystring (bv. ?a=123&b=456) is meegegeven
if (strstr($uri, '?'))
{
    // Als er een querystring is meegegeven, dan gaan we deze
    // nu van de string afhalen omdat we dit niet nodig hebben
    $uri = substr($uri, 0, strpos($uri, '?'));
}

// Nu we een URI hebben, gaan we deze opdelen in stukken, gescheiden
// op de forwardslash (/)
// We gebruiken de trim functie om de eerste, en eventueel laatste, forwardslash weg te halen
$params = explode("/", trim($uri, "/"));

// We lopen door onze array $params heen om alle waardes aan een
// $_GET te koppelen. We doen dit omdat we dan in ieder script
// de waardes weer kunnen oproepen.
// We zouden dit ook kunnen doen door de waardes in een $_SESSION te zetten.
foreach($params as $key => $value) {
    $_GET['v'.$key] = trim($value);
}

// We gaan nu kijken aan de hand van de eerste parameter welke pagina we moeten hebben
switch($_GET['v0']) {
    case 'home':
        include_once 'assets/screens/home.php';
        break;
    case 'inloggen':
        include_once 'assets/screens/login.php';
        break;
    case 'toets':
        include_once 'assets/screens/test.php';
        break;
    case 'nieuwe_toets':
        include_once 'assets/screens/newTest.php';
        break;
    default: // Standaard zullen we altijd de homepagina inladen.
        include_once 'assets/screens/home.php';
}