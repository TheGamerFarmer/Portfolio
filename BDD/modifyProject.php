<?php
require "BDD.php";
require "librairie.php";
require "isUserLoggedFunc.php";
$bdd = connectDatabase();

header('Content-Type: text/html; charset=UTF-8');

$token = $_COOKIE['token'] ?? null;

if (!isUserLogged($token) || !isset($_POST['projectID']))
    exit;

$uploadDirImages = __DIR__ . '/../sitePortfolio/projets/images/';
$imagesNames = [];
$uploadDirVideos = __DIR__ . '/../sitePortfolio/projets/videos/';
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
                $imagesNames[$key] = $fileName;
            }
        } else if (str_starts_with($fileType, 'video')) {
            $targetFile = $uploadDirVideos . $fileName;
            if (move_uploaded_file($tmpName, $targetFile)) {
                $videosNames[$key] = $fileName;
            }
        }
    }
}

$projectID = (int)$_POST["projectID"];

$stmt = $bdd->prepare("UPDATE projets SET title = ?, contexte = ?, technologies = ?, role = ?, defis = ? WHERE projetID = ?");
$stmt->execute([urldecode($_POST["titre"]), urldecode($_POST["contexte"]), urldecode($_POST["technologies"]), urldecode($_POST["role"]), urldecode($_POST["defis"]), $projectID]);

$oldMedias = array_merge(
    $bdd->query("SELECT * FROM projetsImages WHERE projetID = $projectID;")->fetchAll(),
    $bdd->query("SELECT * FROM projetsVideos WHERE projetID = $projectID;")->fetchAll()
);

$stmtDelImg = $bdd->prepare("DELETE FROM projetsImages WHERE projetID = ? AND lienImage = ?");
$stmtDelVid = $bdd->prepare("DELETE FROM projetsVideos WHERE projetID = ? AND lienVideo = ?");

foreach ($oldMedias as $oldMedia) {
    $lienMedia = $oldMedia[2];

    if (!isset($_POST["oldmedias"]) || !in_array($lienMedia, $_POST["oldmedias"])) {
        if (file_exists($uploadDirImages . $lienMedia)) {
            $stmtDelImg->execute([$projectID, $lienMedia]);
            unlink($uploadDirImages . $lienMedia);
        } else if (file_exists($uploadDirVideos . $lienMedia)) {
            $stmtDelVid->execute([$projectID, $lienMedia]);
            unlink($uploadDirVideos . $lienMedia);
        }
    }
}

if (isset($_POST["oldmedias"])) {
    $stmtUpdImg = $bdd->prepare("UPDATE projetsImages SET ordre = ? WHERE projetID = ? AND lienImage = ?");
    $stmtUpdVid = $bdd->prepare("UPDATE projetsVideos SET ordre = ? WHERE projetID = ? AND lienVideo = ?");
    foreach ($_POST["oldmedias"] as $i => $oldMedia) {
        $ordre = isset($_POST["oldmediasOrdres"][$i]) ? (int)$_POST["oldmediasOrdres"][$i] : $i;
        if (file_exists($uploadDirImages . $oldMedia)) {
            $stmtUpdImg->execute([$ordre, $projectID, $oldMedia]);
        } else {
            $stmtUpdVid->execute([$ordre, $projectID, $oldMedia]);
        }
    }
}

$stmtImg = $bdd->prepare("INSERT INTO projetsImages (projetID, lienImage, ordre) VALUES (?, ?, ?)");
foreach ($imagesNames as $key => $image) {
    $ordre = isset($_POST['mediasOrdres'][$key]) ? (int)$_POST['mediasOrdres'][$key] : $key;
    $stmtImg->execute([$projectID, $image, $ordre]);
}

$stmtVid = $bdd->prepare("INSERT INTO projetsVideos (projetID, lienVideo, ordre) VALUES (?, ?, ?)");
foreach ($videosNames as $key => $video) {
    $ordre = isset($_POST['mediasOrdres'][$key]) ? (int)$_POST['mediasOrdres'][$key] : $key;
    $stmtVid->execute([$projectID, $video, $ordre]);
}