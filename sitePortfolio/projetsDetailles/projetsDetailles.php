<!DOCTYPE html>
<html lang="fr">

<?php
require_once "../../BDD/BDD.php";
$bdd = connectDatabase();

$stmt = $bdd->prepare("SELECT * FROM projets WHERE projetID = ?");
$stmt->execute([$_GET["projetID"]]);
$queryAwser = $stmt->getIterator();

if ($queryAwser -> valid()) {
    $projet = $queryAwser -> current();
?>

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($projet["title"]) . " — Raphaël MATHERET" ?></title>
    <link rel="icon" type="image/x-icon" href="/icon.jpeg">
    <link rel="stylesheet" href="/sitePortfolio/projetsDetailles/projetsDetailles.css">
    <?php include("../header/headerHead.html") ?>
    <script src="/sitePortfolio/projetsDetailles/projetsDetailles.js"></script>
</head>

<body>
<?php include("../header/header.php"); ?>

<main>
    <div id='text'>
        <h1><?= $projet["title"] ?></h1>
        <p id='description'><?= $projet["description"] ?></p>
        <h2>Les compétences nécessaires:</h2>
        <p id='competances'><?= $projet["competences"] ?></p>
        <h2>Les objectifs du projet:</h2>
        <p id='objectifs'><?= $projet["objectifs"] ?></p>
        <h2>Les étapes du groupe:</h2>
        <p id='travailGroupe'><?= $projet["travail_En_Groupe"] ?></p>
        <h2>Ma partie du travail:</h2>
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

        $stmtVideos = $bdd->prepare("SELECT * FROM projetsVideos WHERE projetID = ?");
        $stmtVideos->execute([$projet["projetID"]]);
        $videos = $stmtVideos->getIterator();

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

        $stmtImages = $bdd->prepare("SELECT * FROM projetsImages WHERE projetID = ?");
        $stmtImages->execute([$projet["projetID"]]);
        $images = $stmtImages->getIterator();

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
</main>

<?php
} else {
    header('Location: /portfolio/projets');

    exit();
}
?>

</body>
</html>