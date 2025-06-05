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
    <h1>Mes Projets</h1>

    <div id="projets">
    <?php
        $imagesDir = '/sitePortfolio/projets/images/';
        $videosDir = '/sitePortfolio/projets/videos/';

        $projets = $bdd -> query("SELECT * FROM projets") -> getIterator();

        while ($projets -> valid()) {
            $projet = $projets -> current();

            echo "<div class='projet'>
                    <div class='projetDescription'>
                        <h2 class='title'><a href='/portfolio/projets/{$projet["title"]}'>{$projet["title"]}</a></h2>
                        <p class='description'>{$projet["description"]}</p>
                    </div>
                    <div class='projetImagesEtVideos'>
                ";

            $videos = $bdd -> query("SELECT * FROM projetsvideos WHERE projetID = '{$projet["projetID"]}'");
            $isVideos = $videos -> rowCount() > 0;

            if ($isVideos) {
                $video = $videosDir . ($videos -> fetchColumn(2));

                $videoExploded = explode(".", $video);
                $extention = end($videoExploded);

                echo "<video controls>
                        <source src='{$video}' type='video/{$extention}'>
                    </video>";
            }

            $images = $bdd -> query("SELECT * FROM projetsimages WHERE projetID = '{$projet["projetID"]}'");

            if ($images -> rowCount() > 0) {
                $image = $imagesDir . ($images -> fetchColumn(2));

                echo "<img src='{$image}' alt='{$projet["title"]}'>";
            }

            if (!$isVideos) {
                $image = $imagesDir . ($images -> fetchColumn(2));

                echo "<img src='{$image}' alt='{$projet["title"]}'>";
            }

            echo "</div>
                </div>";

            $projets -> next();
        }
    ?>
    </div>
</main>

<main>
</main>
</body>
</html>