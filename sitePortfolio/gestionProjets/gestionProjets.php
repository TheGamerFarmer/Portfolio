<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Gestion projets</title>
    <link rel="icon" type="image/x-icon" href="/icon.jpeg">
    <link rel="stylesheet" href="/sitePortfolio/gestionProjets/gestionProjets.css">
    <link rel="stylesheet" href="/sitePortfolio/header/header.css">
    <link rel="stylesheet" href="/sitePortfolio/images/images.css">
    <script type="module" src="/sitePortfolio/header/header.js"></script>
    <script type="module" src="/sitePortfolio/gestionProjets/gestionProjets.js"></script>
</head>

<body>
<?php

use Random\RandomException;

require_once "../../BDD.php";
$bdd = connectDatabase();
include("../header/header.php");
?>

<main>
    <h1>Gestion projets</h1>
    <form id="formulaire" method="POST" action="" enctype="multipart/form-data">
        <h2 class="sousTitre">Nouveau projet</h2>
        <label for="titre">Titre :</label>
        <input id="titre" type="text" name="titre" placeholder="titre" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description" placeholder="Description" required></textarea>

        <label for="competences">Compétences :</label>
        <textarea id="competences" name="competences" placeholder="Compétences" required></textarea>

        <label for="objectifs">Objectifs :</label>
        <textarea id="objectifs" name="objectifs" placeholder="Objectifs" required></textarea>

        <label for="travailDeGroupe">Travail de groupe :</label>
        <textarea id="travailDeGroupe" name="travailDeGroupe" placeholder="Travail de groupe" required></textarea>

        <label for="travailIndividuel">Travail individuel dans le groupe :</label>
        <textarea id="travailIndividuel" name="travailIndividuel" placeholder="Travail individuel dans le groupe" required></textarea>

        <label for="aquis">Techniques et savoirs faire acquis :</label>
        <textarea id="aquis" name="aquis" placeholder="Techniques et savoirs faire acquis" required></textarea>

        <input id="fileInput" type="file" name="medias[]" accept="image/*,video/*" multiple>
        <button id="fileInputButton" type="button">Ajouter des images ou vidéos</button>

        <div id="preview"></div>

        <input type="submit" value="Enregistrer">
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

        $bdd -> query("INSERT INTO projets (title, description, competences, objectifs, travail_En_Groupe, travail_individuel, savoir_Faire_Aquis)
            VALUES ('{$_POST["titre"]}',
                    '{$_POST["description"]}',
                    '{$_POST["competences"]}',
                    '{$_POST["objectifs"]}',
                    '{$_POST["travailDeGroupe"]}',
                    '{$_POST["travailIndividuel"]}',
                    '{$_POST["aquis"]}')");

        $projectID = $bdd -> query("SELECT max(projetID) FROM projets") -> fetchColumn();

        forEach($imagesNames as $image) {
            $bdd -> query("INSERT INTO projetsImages (projetID, lienImage) VALUES ('$projectID', '$image')");
        }

        forEach($videosNames as $video) {
            $bdd -> query("INSERT INTO projetsVideos (projetID, lienVideo) VALUES ('$projectID', '$video')");
        }
    }
    ?>
</main>

</body>
</html>