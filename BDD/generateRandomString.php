<?php
use Random\RandomException;

function generateRandomString($length = 10): string {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        try {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        } catch (RandomException $e) {
            echo "<script>console.log('{$e -> getTraceAsString()}');</script>";
        }
    }

    return $randomString;
}