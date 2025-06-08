<?php
require_once "BDD.php";
$bdd = connectDatabase();

header('Content-Type: text/html; charset=UTF-8');

$projet = $bdd -> query("SELECT * FROM projets WHERE projetID = " . $_GET['id']);
$projetImages = $bdd -> query("SELECT * FROM projetsImages WHERE projetID = " . $_GET['id']);
$projetVideos = $bdd -> query("SELECT * FROM projetsVideos WHERE projetID = " . $_GET['id']);

$toReturn = array(
    "projet" => $projet -> fetchAll(),
    "images" => ($projetImages -> rowCount() > 0 ? $projetImages -> fetchAll() : array()),
    "videos" => ($projetVideos -> rowCount() > 0 ? $projetVideos -> fetchAll() : array()),
);

echo json_encode($toReturn, JSON_PRETTY_PRINT);