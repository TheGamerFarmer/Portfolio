<?php

require_once __DIR__ . "/../../BDD/BDD.php";
require_once __DIR__ . "/../../BDD/insertSession.php";

$input = file_get_contents('php://input');
$data = json_decode($input, true);
$clientHash = $data["password"] ?? '';

if (password_verify("Ceci est un sel Backend anudetndaput" . $clientHash . "Ceci est du poivre Backend anpdetanudpit", "\$2y\$10\$Gyca46HjK8.GMfL3TK7eFuzXfnov98ixdYEuhZAb9iXstO89LdUAq")
    || password_verify("Ceci est un sel Backend anudetndaput" . $clientHash . "Ceci est du poivre Backend anpdetanudpit", "\$2y\$10\$CsIZdnpWpUadhAfyKZ04AORjmGUbhc10bc4cU3eibmW9mefuYGQSq")) {
    try {
        $token = bin2hex(random_bytes(16));
        $expiration = time() + (24 * 3600);

        insertSession($token, $expiration);

        setcookie("token",
            $token,
            ['expires' => $expiration,
                'path' => '/',
                'secure' => false,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
        echo "Connection réussit";
    } catch (\Throwable $e) {
        http_response_code(500);
        echo "Erreure serveur" . $e;
    }
} else {
    http_response_code(401);
    echo "Mot de passe incorrect";
}