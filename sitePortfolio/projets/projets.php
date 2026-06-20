<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Projets — Raphaël MATHERET</title>
    <meta name="description" content="Découvrez les projets réalisés par Raphaël MATHERET : développement logiciel, web, Minecraft et plus.">
    <meta property="og:title" content="Projets — Raphaël MATHERET">
    <meta property="og:description" content="Découvrez les projets réalisés par Raphaël MATHERET : développement logiciel, web, Minecraft et plus.">
    <meta property="og:image" content="https://raphael.zron.fr/sitePortfolio/aProposDeMoi/photo.jpeg">
    <meta property="og:url" content="https://raphael.zron.fr/portfolio/projets">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/x-icon" href="/icon.jpeg">
    <link rel="stylesheet" href="/sitePortfolio/projets/projets.css">
    <?php include("../header/headerHead.html") ?>
</head>

<body>
<?php
    require_once "../../BDD/BDD.php";
    $bdd = connectDatabase();
    include("../header/header.php");
?>

<main>
    <h1>Mes Projets</h1>

    <div id="projets">
    <?php
        $imagesDir = '/sitePortfolio/projets/images/';
        $videosDir = '/sitePortfolio/projets/videos/';

        $projets = $bdd -> query("SELECT * FROM projets") -> getIterator();

        while ($projets -> valid()) {
            $projet = $projets -> current();
            ?>
        <a class='projet reveal-scale' href='/portfolio/projets/<?= $projet["projetID"] ?>'>
            <div class='projetDescription'>
                <h2 class='title'><?= $projet["title"] ?></h2>
                <p class='description'><?= $projet["description"] ?></p>
                <span class='enSavoirPlus'>En savoir plus
                    <svg viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
                        <path d='M5 12h14M12 5l7 7-7 7'/>
                    </svg>
                </span>
            </div>

            <div class='projetImagesEtVideos'>

                <?php
            $stmtVideos = $bdd->prepare("SELECT * FROM projetsVideos WHERE projetID = ?");
            $stmtVideos->execute([$projet["projetID"]]);
            $videos = $stmtVideos;
            $isVideos = $videos -> rowCount() > 0;

            if ($isVideos) {
                $video = $videosDir . ($videos -> fetchColumn(2));

                $videoExploded = explode(".", $video);
                $extention = end($videoExploded);
                ?>
                <video controls>
                    <source src='<?= $video ?>' type='video/<?= $extention ?>'>
                </video>

                <?php
            } else {
                $stmtImages = $bdd->prepare("SELECT * FROM projetsImages WHERE projetID = ?");
                $stmtImages->execute([$projet["projetID"]]);
                $images = $stmtImages;

                if ($images -> rowCount() > 0) {
                    $image = $imagesDir . ($images -> fetchColumn(2));
                    ?>

                <img src='<?= $image ?>' alt='<?= $projet["title"] ?>'>

                <?php
                }
            }
            ?>

            </div>
        </a>

        <?php
            $projets -> next();
        }
    ?>
    </div>
</main>

</body>
</html>