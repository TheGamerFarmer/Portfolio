<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Portfolio</title>
    <link rel="icon" type="image/x-icon" href="/icon.jpeg">
    <link rel="stylesheet" href="/sitePortfolio/projets/projets.css">
    <link rel="stylesheet" href="/sitePortfolio/headerAndFooter/headerAndFooter.css">
    <link rel="stylesheet" href="/sitePortfolio/images/images.css">
</head>

<body>
<?php
require_once "../../BDD.php";
$bdd = connectDatabase();
include("../headerAndFooter/header.php");
?>

<main>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="text" name="titre" placeholder="titre" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="file" value="image" accept="image/*" name="images[]" multiple>
        <input type="file" value="video" accept="video/*" name="videos[]" multiple>
        <input type="submit" value="submit">
    </form>

    <?php
    if (isset($_POST["titre"])) {
        $uploadDirImages = '../projets/images/';
        $imagesNames = [];
        $uploadDirVideos = '../projets/videos/';
        $videosNames = [];

        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            $imageName = basename($_FILES['images']['name'][$key]);
            $targetFile = $uploadDirImages . $imageName;

            if (move_uploaded_file($tmpName, $targetFile)) {
                $imagesNames[] = $imageName;
            }
        }

        foreach ($_FILES['videos']['tmp_name'] as $key => $tmpName) {
            $videoName = basename($_FILES['videos']['name'][$key]);
            $targetFile = $uploadDirVideos . $videoName;

            if (move_uploaded_file($tmpName, $targetFile)) {
                $videosNames[] = $videoName;
            }
        }


        addProject($_POST["titre"], $_POST["description"], $imagesNames, $videosNames);
    }
    ?>
</main>

<main>
</main>
</body>
</html>