<?php
require_once "BDD.php";
$bdd = connectDatabase();

$projet = $bdd -> query("SELECT * FROM projets WHERE projetID = " . $_GET['id']);
$projetImages = $bdd -> query("SELECT * FROM projetsImages WHERE projetID = " . $_GET['id']);
$projetVideos = $bdd -> query("SELECT * FROM projetsvideos WHERE projetID = " . $_GET['id']);

$toReturn = array(
    "projet" => $projet -> fetchAll(),
    "images" => $projetImages -> fetchAll(),
    "videos" => $projetVideos -> fetchAll(),
);

echo json_encode($toReturn, JSON_PRETTY_PRINT);