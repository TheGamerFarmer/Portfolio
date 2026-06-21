<?php
require "BDD.php";
require "isUserLoggedFunc.php";
$bdd = connectDatabase();

$token = $_COOKIE['token'] ?? null;

if (!isUserLogged($token) || !isset($_POST['ids']))
    exit;

$stmt = $bdd->prepare("UPDATE projets SET ordre = ? WHERE projetID = ?");
foreach ($_POST['ids'] as $ordre => $projetID) {
    $stmt->execute([(int)$ordre, (int)$projetID]);
}