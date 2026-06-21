<?php
require_once __DIR__ . "/BDD.php";

function insertSession(string $token, float|int $expiration): void {
    $bdd = connectDatabase();
    $stmt = $bdd->prepare("INSERT INTO session (token, expiration_date) VALUES (?, ?)");
    $stmt->execute([$token, $expiration]);
}