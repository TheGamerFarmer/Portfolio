<?php
require_once "BDD.php";
$bdd = connectDatabase();

$bdd -> query("DELETE FROM projets WHERE projetID = " . $_GET['id']);

$imagesDir = '/sitePortfolio/projets/images/';
$videosDir = '/sitePortfolio/projets/videos/';

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