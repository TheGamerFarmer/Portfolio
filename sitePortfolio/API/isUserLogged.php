<?php
$token = $_COOKIE['token'] ?? null;

require_once __DIR__ . "/../../BDD/BDD.php";
require_once __DIR__ . "/../../BDD/isUserLoggedFunc.php";

echo json_encode(["value" => isUserLogged($token)]);