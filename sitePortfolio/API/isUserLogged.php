<?php
$token = $_COOKIE['token'] ?? null;

require_once "../../BDD/isUserLoggedFunc.php";

echo json_encode(["value" => isUserLogged($token)]);