<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Portfolio</title>
    <link rel="icon" type="image/x-icon" href="/icon.jpeg">
    <link rel="stylesheet" href="/sitePortfolio/newProjets/newProjets.css">
    <link rel="stylesheet" href="/sitePortfolio/header/header.css">
    <link rel="stylesheet" href="/sitePortfolio/images/images.css">
    <script type="module" src="/sitePortfolio/header/header.js"></script>
    <script type="module" src="/sitePortfolio/newProjets/newProjets.js"></script>
</head>

<body>
<?php

use Random\RandomException;

require_once "../../BDD.php";
$bdd = connectDatabase();
include("../header/header.php");
?>

<main>
    <form id="formulaire" method="POST" action="" enctype="multipart/form-data">
        <input type="text" name="titre" placeholder="titre" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <textarea name="competences" placeholder="Compétences" required></textarea>
        <textarea name="objectifs" placeholder="Objectifs" required></textarea>
        <textarea name="travailDeGroupe" placeholder="Travail de groupe" required></textarea>
        <textarea name="travailIndividuel" placeholder="Travail individuel dans le groupe" required></textarea>
        <textarea name="aquis" placeholder="Techniques et savoirs faire acquis" required></textarea>
        <input type="file" name="medias[]" id="fileInput" accept="image/*,video/*" multiple>
        <button type="button" id="buttonFileInput">Ajouter des fichiers</button>

        <div id="preview"></div>

        <input type="submit" value="Envoyer">
    </form>

    <?php
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

    if (isset($_POST["titre"])) {
        $uploadDirImages = '../projets/images/';
        $imagesNames = [];
        $uploadDirVideos = '../projets/videos/';
        $videosNames = [];

        foreach ($_FILES['medias']['tmp_name'] as $key => $tmpName) {
            $fileName = generateRandomString() . " " . basename($_FILES['medias']['name'][$key]);

            if (empty($tmpName) || !file_exists($tmpName)) {
                continue;
            }

            $fileType = mime_content_type($tmpName);

            if (str_starts_with($fileType, 'image')) {
                $targetFile = $uploadDirImages . $fileName;
                if (move_uploaded_file($tmpName, $targetFile)) {
                    $imagesNames[] = $fileName;
                }
            } else if (str_starts_with($fileType, 'video')) {
                $targetFile = $uploadDirVideos . $fileName;
                if (move_uploaded_file($tmpName, $targetFile)) {
                    $videosNames[] = $fileName;
                }
            }
        }

        addProject($_POST["titre"], $_POST["description"], $_POST["competences"], $_POST["objectifs"], $_POST["travailDeGroupe"], $_POST["travailIndividuel"], $_POST["aquis"], $imagesNames, $videosNames);
    }
    ?>
</main>

</body>
</html>