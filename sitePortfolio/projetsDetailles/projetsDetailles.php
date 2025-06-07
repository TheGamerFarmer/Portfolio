<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Portfolio</title>
    <link rel="icon" type="image/x-icon" href="/icon.jpeg">
    <link rel="stylesheet" href="/sitePortfolio/projetsDetailles/projetsDetailles.css">
    <link rel="stylesheet" href="/sitePortfolio/header/header.css">
    <link rel="stylesheet" href="/sitePortfolio/images/images.css">
    <script type="module" src="/sitePortfolio/header/header.js"></script>
    <script src="/sitePortfolio/projetsDetailles/projetsDetailles.js"></script>
</head>

<body>
<?php
require_once "../../BDD.php";
$bdd = connectDatabase();
include("../header/header.php");
?>

<main>
    <?php
    $urlExploded = explode("/",$_SERVER['REQUEST_URI']);
    $title = end($urlExploded);
    $queryAwser = $bdd -> query("SELECT * FROM projets WHERE title = '$title'") -> getIterator();

    if ($queryAwser -> valid()) {
        $projet = $queryAwser -> current();
        ?>

    <div id='text'>
        <h1><?= $title ?></h1>
        <p id='description'><?= $projet["description"] ?></p>
        <h2>Les compétances nécessaires:</h2>
        <p id='competances'><?= $projet["competences"] ?></p>
        <h2>Les objectifs du projet:</h2>
        <p id='objectifs'><?= $projet["objectifs"] ?></p>
        <h2>Les étapes du groupe:</h2>
        <p id='travailGroupe'><?= $projet["travail_En_Groupe"] ?></p>
        <h2>Ma partie du travaille:</h2>
        <p id='travailIndividuel'><?= $projet["travail_individuel"] ?></p>
        <h2>Les savoirs faires aquis grâce à ce projet:</h2>
        <p id='aquis'><?= $projet["savoir_Faire_Aquis"] ?></p>
    </div>
    <div id='medias'>
        <button class='control-btn' id='btnUp' onclick='slide(-1)'>
            <svg viewBox='0 0 24 24'><path d='M7 14l5-5 5 5z'/></svg>
        </button>

        <div id='viewport'>
            <div id='mediaWrapper'>

        <?php
        $imagesDir = '/sitePortfolio/projets/images/';
        $videosDir = '/sitePortfolio/projets/videos/';

        $videos = $bdd -> query("SELECT * FROM projetsvideos WHERE projetID = '{$projet["projetID"]}'") -> getIterator();

        while ($videos -> valid()) {
            $video = $videos -> current();

            $videoLien = $videosDir . $video["lienVideo"];

            $videoExploded = explode(".", $videoLien);
            $extention = end($videoExploded);
            ?>

                <div class='media'>
                    <video controls>
                        <source src='<?= $videoLien ?>' type='video/<?= $extention ?>'>
                        Votre navigateur ne supporte pas la vidéo.
                    </video>
                </div>

            <?php
            $videos -> next();
        }

        $images = $bdd -> query("SELECT * FROM projetsimages WHERE projetID = '{$projet["projetID"]}'") -> getIterator();

        while ($images -> valid()) {
            $image = $images -> current();

            $imageLien = $imagesDir . ($image["lienImage"]);
            ?>

                <div class='media'>
                    <img src='<?= $imageLien ?>' alt='<?= $imageLien ?>'>
                </div>

            <?php
            $images -> next();
        }
        ?>
            </div>
        </div>

        <button class='control-btn' id='btnDown' onclick='slide(1)'>
            <svg viewBox='0 0 24 24'><path d='M7 10l5 5 5-5z'/></svg>
        </button>
    </div>

    <?php
    }
    ?>
</main>

</body>
</html>