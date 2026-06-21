<?php
require_once "BDD.php";
$bdd = connectDatabase();

header('Content-Type: text/html; charset=UTF-8');

$id = (int)$_GET['id'];

$projet = $bdd->query("SELECT * FROM projets WHERE projetID = $id");

$projetMedias = $bdd->query("
    SELECT 'image' as type, lienImage as lien, ordre FROM projetsImages WHERE projetID = $id
    UNION ALL
    SELECT 'video' as type, lienVideo as lien, ordre FROM projetsVideos WHERE projetID = $id
    ORDER BY ordre
");

$toReturn = array(
    "projet" => $projet->fetchAll(),
    "medias" => $projetMedias->fetchAll()
);

echo json_encode($toReturn, JSON_PRETTY_PRINT);