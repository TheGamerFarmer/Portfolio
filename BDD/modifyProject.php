<?php
require "BDD.php";
require "generateRandomString.php";
$bdd = connectDatabase();

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

    $bdd -> query("UPDATE projets SET title = '{$_POST["titre"]}',
                   description = '{$_POST["description"]}',
                   competences = '{$_POST["competences"]}',
                   objectifs = '{$_POST["objectifs"]}',
                   travail_En_Groupe = '{$_POST["travailDeGroupe"]}',
                   travail_individuel = '{$_POST["travailIndividuel"]}',
                   savoir_Faire_Aquis = '{$_POST["aquis"]}'
               WHERE projetID = {$_POST["projectID"]};");

    $oldMedias = array_merge($bdd -> query("SELECT * FROM projetsimages WHERE projetID = {$_POST["projectID"]};") -> fetchAll(),
        $bdd -> query("SELECT * FROM projetsvideos WHERE projetID = {$_POST["projectID"]};") -> fetchAll());

    forEach($oldMedias as $oldMedia) {
        $lienMedia = $oldMedia[2];
        if (!in_array($lienMedia, $_POST["oldmedias"])) {
            if (file_exists($uploadDirImages . $lienMedia)) {
                $bdd -> query("DELETE FROM projetsimages WHERE projetID = {$_POST["projectID"]} AND lienImage = '$lienMedia';");
                unlink($uploadDirImages . $lienMedia);
            } else if (file_exists($uploadDirVideos . $lienMedia)) {
                $bdd -> query("DELETE FROM projetsvideos WHERE projetID = {$_POST["projectID"]} AND lienVideo = '$lienMedia';");
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