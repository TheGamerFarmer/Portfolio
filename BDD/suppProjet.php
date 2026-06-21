<?php
require_once "BDD.php";
$bdd = connectDatabase();

header('Content-Type: text/html; charset=UTF-8');

$token = $_COOKIE['token'] ?? null;

require_once "./isUserLoggedFunc.php";

if (!isUserLogged($token) || !isset($_GET['id']))
    exit;

$bdd -> query("DELETE FROM projets WHERE projetID = " . $_GET['id']);

$imagesDir = __DIR__ . '/../sitePortfolio/projets/images/';
$videosDir = __DIR__ . '/../sitePortfolio/projets/videos/';

$images = $bdd -> query("SELECT * FROM projetsImages WHERE projetID = " . $_GET['id']) -> getIterator();

while ($images -> valid()) {
    $image = $images -> current();

    unlink($imagesDir . $image["lienImage"]);

    $images -> next();
}

$videos = $bdd -> query("SELECT * FROM projetsVideos WHERE projetID = " . $_GET['id']) -> getIterator();

while ($videos -> valid()) {
    $video = $videos -> current();

    unlink($imagesDir . $video["lienVideo"]);

    $videos -> next();
}

$bdd -> query("DELETE FROM projetsImages WHERE projetID = " . $_GET['id']);
$bdd -> query("DELETE FROM projetsVideos WHERE projetID = " . $_GET['id']);