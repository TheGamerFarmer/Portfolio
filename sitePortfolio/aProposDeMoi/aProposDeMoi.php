<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Portfolio</title>
    <link rel="icon" type="image/x-icon" href="/icon.jpeg">
    <link rel="stylesheet" href="/sitePortfolio/aProposDeMoi/aProposDeMoi.css">
    <link rel="stylesheet" href="/sitePortfolio/headerAndFooter/headerAndFooter.css">
</head>

<body>
<?php include("../headerAndFooter/header.php") ?>

<main>
    <div id="presentation" class="partie">
        <div id="presentation-text">
            <h1 class="titre">Présentation</h1>
            <img id="empreinteDigitale" class="imageFond" src="/sitePortfolio/aProposDeMoi/empreinteDigitale.png" alt="empreinte digitale">
            <p>Bonjour, je m'appelle Raphaël MATHERET, j'ai 18 ans.<br>Je suis passionné d'informatique et de jeux vidéo
                depuis tout petit. J'ai commencé le développement asser jeune pour automatiser un train en légo, puis
                j'ai continué avec des projets de modifications de jeux, très principalement Minecraft.<br>J'aime aussi
                m'occuper des enfants, j'ai donc passé la première partie du BAFA et fais un job d'été en périscolaire
                dans une école près de chez moi. J'ai aussi réalisé un petit film amateur avec des jeunes du centre
                AÉRÉ de mon village à l'occasion d'Halloween.
            </p>
        </div>

        <img id="selfie" src="/sitePortfolio/aProposDeMoi/photo.jpg" alt="photo Présentation">
        <img class="circuitElectric imageFond" src="/sitePortfolio/aProposDeMoi/circuitElectric.png" alt="circuit électrique">
    </div>

    <div id="mesExperiences" class="partie">
        <img class="circuitElectric imageFond" src="/sitePortfolio/aProposDeMoi/circuitElectric.png" alt="circuit électrique">
        <img id="fleche" class="imageFond" src="/sitePortfolio/aProposDeMoi/fleche.png" alt="fleche">

        <h1 class="titre">Mes Experiences</h1>
        <ul>
            <li>
                <img src="/sitePortfolio/aProposDeMoi/experiencesPrefix.png" alt="Éxpériences préfix">
                <div class="exempleText">
                    <h2>Weatheria</h2>
                    <p>Je fais partis de ce projet de serveur Minecraft en tant que développeur. On est une dizaine
                        avec une hiérarchie bien définie pour faciliter l'avancement du projet. On a des réunions
                        hebdomadaires avec notre responsable de pôle et une réunion mensuel pour faire un point interpôles.
                    </p>
                </div>
            </li>
            <li>
                <img src="/sitePortfolio/aProposDeMoi/experiencesPrefix.png" alt="Éxpériences préfix">
                <div class="exempleText">
                    <h2>Un titre d'éxemple</h2>
                    <p>Je ne sais pas un exemple</p>
                </div>
            </li>
            <li>
                <img src="/sitePortfolio/aProposDeMoi/experiencesPrefix.png" alt="Éxpériences préfix">
                <div class="exempleText">
                    <h2>Un titre d'éxemple</h2>
                    <p>Je ne sais pas un exemple</p>
                </div>
            </li>
            <li>
                <img src="/sitePortfolio/aProposDeMoi/experiencesPrefix.png" alt="Éxpériences préfix">
                <div class="exempleText">
                    <h2>Un titre d'éxemple</h2>
                    <p>Je ne sais pas un exemple</p>
                </div>
            </li>
        </ul>

        <img id="engrenage" class="imageFond" src="/sitePortfolio/aProposDeMoi/engrenage.png" alt="engrenage">
    </div>
</main>
</body>
</html>