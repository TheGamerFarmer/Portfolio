<?php
function isUserLogged(string|null $token): bool {
    if (!$token || strlen($token) !== 32) {
        return false;
    }

    $bdd = connectDatabase();

    $query = $bdd->prepare("SELECT expiration_date FROM session WHERE token = :token LIMIT 1");
    $query->execute(['token' => $token]);
    $session = $query->fetch(PDO::FETCH_ASSOC);

    if ($session) {
        if ($session["expiration_date"] > time()) {
            return true;
        } else {
            $query = $bdd->prepare("DELETE FROM session WHERE token = :token");
            $query->execute(['token' => $token]);
        }
    }

    return false;
}