<?php
require "BDD.php";
require "librairie.php";
$bdd = connectDatabase();

header('Content-Type: text/html; charset=UTF-8');

if (isset($_POST["projectID"])) {
    $uploadDirImages = '../sitePortfolio/projets/images/';
    $imagesNames = [];
    $uploadDirVideos = '../sitePortfolio/projets/videos/';
    $videosNames = [];

    if (isset($_FILES['medias'])) {
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
    }

    $titre = sanitize($_POST["titre"]);
    $description = sanitize($_POST["description"]);
    $competences = sanitize($_POST["competences"]);
    $objectifs = sanitize($_POST["objectifs"]);
    $travailDeGroupe = sanitize($_POST["travailDeGroupe"]);
    $travailIndividuel = sanitize($_POST["travailIndividuel"]);
    $aquis = sanitize($_POST["aquis"]);


    $bdd -> query("UPDATE projets SET title = '$titre',
                   description = '$description',
                   competences = '$competences',
                   objectifs = '$objectifs',
                   travail_En_Groupe = '$travailDeGroupe',
                   travail_individuel = '$travailIndividuel',
                   savoir_Faire_Aquis = '$aquis'
               WHERE projetID = {$_POST["projectID"]};");

    $oldMedias = array_merge($bdd -> query("SELECT * FROM projetsImages WHERE projetID = {$_POST["projectID"]};") -> fetchAll(),
        $bdd -> query("SELECT * FROM projetsVideos WHERE projetID = {$_POST["projectID"]};") -> fetchAll());

    forEach($oldMedias as $oldMedia) {
        $lienMedia = $oldMedia[2];

        if ( !isset($_POST["oldmedias"]) || !in_array($lienMedia, $_POST["oldmedias"])) {
            if (file_exists($uploadDirImages . $lienMedia)) {
                $bdd -> query("DELETE FROM projetsImages WHERE projetID = {$_POST["projectID"]} AND lienImage = '$lienMedia';");
                unlink($uploadDirImages . $lienMedia);
            } else if (!isset($_POST["oldmedias"]) || file_exists($uploadDirVideos . $lienMedia)) {
                $bdd -> query("DELETE FROM projetsVideos WHERE projetID = {$_POST["projectID"]} AND lienVideo = '$lienMedia';");
                unlink($uploadDirVideos . $lienMedia);
            }
        }
    }

    forEach($imagesNames as $image) {
        $bdd -> query("INSERT INTO projetsImages (projetID, lienImage) VALUES ('{$_POST["projectID"]}', '$image')");
    }

    forEach($videosNames as $video) {
        $bdd -> query("INSERT INTO projetsVideos (projetID, lienVideo) VALUES ('{$_POST["projectID"]}', '$video')");
    }
}