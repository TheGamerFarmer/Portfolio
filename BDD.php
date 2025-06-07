<?php
$bdd = null;

function connectDatabase(): PDO {
    global $bdd;
    $bdd = new PDO('mysql:host=localhost;dbname=portfolio', "root", "");
    return $bdd;
}