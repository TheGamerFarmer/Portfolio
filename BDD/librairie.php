<?php
use Random\RandomException;

header('Content-Type: text/html; charset=UTF-8');

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

function sanitize($string): string {
    $string = str_replace("\\", "\\\\", $string);
    $string = str_replace("'", "\'", $string);
    $string = str_replace('"', '\"', $string);
    $string = str_replace("{", "\{", $string);
    return str_replace("}", "\}", $string);
}