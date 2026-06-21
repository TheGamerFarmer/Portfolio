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
    <a id='btnRetour' href='/portfolio/projets'>
        <svg viewBox='0 0 24 24' width='60%' height='60%' fill='none' stroke='currentColor' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'>
            <path d='M19 12H5M12 5l-7 7 7 7'/>
        </svg>
    </a>
    <div id='text'>
        <h1><?= $projet["title"] ?></h1>
        <p id='contexte'><?= $projet["contexte"] ?></p>
        <section>
            <h2>Technologies utilisées</h2>
            <p id='technologies'><?= $projet["technologies"] ?></p>
        </section>
        <section>
            <h2>Mon rôle</h2>
            <p id='role'><?= $projet["role"] ?></p>
        </section>
        <section>
            <h2>Défis</h2>
            <p id='defis'><?= $projet["defis"] ?></p>
        </section>
    </div>
    <div id='medias'>
        <div id='mediaLoader'></div>
        <button class='control-btn' id='btnUp' onclick='slide(-1)'>
            <svg viewBox='0 0 24 24'><path d='M7 14l5-5 5 5z'/></svg>
        </button>

        <div id='viewport'>
            <div id='mediaWrapper'>

        <?php
        $imagesDir = '/sitePortfolio/projets/images/';
        $videosDir = '/sitePortfolio/projets/videos/';

        $stmtMedias = $bdd->prepare("
            SELECT 'image' as type, lienImage as lien, ordre FROM projetsImages WHERE projetID = ?
            UNION ALL
            SELECT 'video' as type, lienVideo as lien, ordre FROM projetsVideos WHERE projetID = ?
            ORDER BY ordre
        ");
        $stmtMedias->execute([$projet["projetID"], $projet["projetID"]]);
        $medias = $stmtMedias->getIterator();

        while ($medias->valid()) {
            $media = $medias->current();
            if ($media['type'] === 'image') {
                $imageLien = $imagesDir . rawurlencode($media['lien']);
                ?>
                <div class='media'>
                    <img src='<?= $imageLien ?>' alt='<?= htmlspecialchars($media['lien']) ?>'>
                </div>
                <?php
            } else {
                $videoLien = $videosDir . rawurlencode($media['lien']);
                $extention = pathinfo($media['lien'], PATHINFO_EXTENSION);
                ?>
                <div class='media'>
                    <video controls>
                        <source src='<?= $videoLien ?>' type='video/<?= $extention ?>'>
                        Votre navigateur ne supporte pas la vidéo.
                    </video>
                </div>
                <?php
            }
            $medias->next();
        }
        ?>
            </div>
        </div>

        <div id='counter'><span id='currentIdx'>1</span> / <span id='totalCount'>0</span></div>

        <button class='control-btn' id='btnDown' onclick='slide(1)'>
            <svg viewBox='0 0 24 24'><path d='M7 10l5 5 5-5z'/></svg>
        </button>
    </div>
</main>

<div id='lightbox'>
    <button id='closeBtn' onclick='closeLightbox()'>✕</button>
    <div id='lightboxContent'></div>
</div>

<?php
} else {
    header('Location: /portfolio/projets');

    exit();
}
?>

</body>
</html>