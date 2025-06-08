<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Portfolio</title>
    <link rel="icon" type="image/x-icon" href="/icon.jpeg">
    <link rel="stylesheet" href="/sitePortfolio/aProposDeMoi/aProposDeMoi.css">
    <link rel="stylesheet" href="/sitePortfolio/header/header.css">
    <link rel="stylesheet" href="/sitePortfolio/images/images.css">
    <script type="module" src="/sitePortfolio/header/header.js"></script>
</head>

<body>
<?php include("../header/header.php") ?>

<main>
    <div id="presentation" class="partie">
        <img id="empreinteDigitale" class="imageFond translucide" src="/sitePortfolio/aProposDeMoi/empreinteDigitale.png" alt="empreinte digitale">

        <div id="presentation-text">
            <h1 class="titre">Présentation</h1>
            <p>Bonjour, je m'appelle Raphaël MATHERET, j'ai 18 ans.<br>
                Je suis passionné d'informatique et de jeux vidéo depuis tout petit. J'ai commencé le développement
                assez jeune pour automatiser un train en Lego, puis j'ai continué avec des projets de modification de
                jeux, principalement Minecraft.<br>
                J'aime aussi m'occuper des enfants : j'ai donc passé la première partie du BAFA et effectué un job d'été
                en périscolaire dans une école près de chez moi. J'ai également réalisé un petit film amateur avec des
                jeunes du centre aéré de mon village à l'occasion d'Halloween.
            </p>
        </div>

        <img id="selfie" src="/sitePortfolio/aProposDeMoi/photo.jpg" alt="photo Présentation">
        <img class="circuitElectric imageFond translucide" src="/sitePortfolio/aProposDeMoi/circuitElectric.png" alt="circuit électrique">
    </div>

    <div id="mesExperiences" class="partie">
        <img class="circuitElectric imageFond translucide" src="/sitePortfolio/aProposDeMoi/circuitElectric.png" alt="circuit électrique">
        <img id="flecheMesExperiences" class="imageFond translucide" src="/sitePortfolio/images/fleche.png" alt="fleche">

        <h1 class="titre">Mes experiences</h1>
        <ul>
            <li>
                <img src="/sitePortfolio/aProposDeMoi/experiencesPrefix.png" alt="Éxpériences préfix">
                <div class="exempleText">
                    <h2>Weatheria</h2>
                    <p>

                        Je fais partie de ce projet de serveur Minecraft en tant que développeur. Nous sommes une
                        dizaine, avec une hiérarchie bien définie pour faciliter l'avancement du projet.
                        Nous organisons des réunions hebdomadaires avec notre responsable de pôle, ainsi qu'une réunion
                        mensuelle pour faire un point entre les pôles.
                    </p>
                </div>
            </li>
            <li>
                <img src="/sitePortfolio/aProposDeMoi/experiencesPrefix.png" alt="Éxpériences préfix">
                <div class="exempleText">
                    <h2>Périscolaire</h2>
                    <p>Comme dit plus haut, j’ai eu l’occasion, lors de mon stage BAFA, de passer un mois en périscolaire
                        dans l’école primaire de Pinet. Je remplaçais une animatrice malade. J’aidais principalement à
                        gérer la pause méridienne et le repas du midi. J’ai également participé à l’organisation de la
                        kermesse de fin d’année, notamment en créant un diaporama des meilleures photos et vidéos de l’année.</p>
                </div>
            </li>
            <li>
                <img src="/sitePortfolio/aProposDeMoi/experiencesPrefix.png" alt="Éxpériences préfix">
                <div class="exempleText">
                    <h2>Youtube</h2>
                    <p>J’ai tenu pendant quelque temps une chaîne YouTube :
                        <a href="https://www.youtube.com/@thegamerfarmer">TheGamerFarmer</a>.
                        Je voulais m’essayer au montage vidéo et m’entraîner à m’exprimer à l’oral. Ça n’a pas été une
                        franche réussite, mais cela m’a permis de me lancer dans un projet, d’apprendre par moi-même,
                        ce que j’ai refait un peu plus tard en reprenant le développement.</p>
                </div>
            </li>
        </ul>

        <img id="engrenage" class="imageFond" src="/sitePortfolio/aProposDeMoi/engrenage.png" alt="engrenage">
    </div>

    <div id="mesLangages" class="partie">
        <img id="imageLocigielsTravail" class="imageFond translucide" src="/sitePortfolio/aProposDeMoi/imageMesLangages.png" alt="image logiciels travail">
        <img id="flecheMesLangagges" class="imageFond translucide" src="/sitePortfolio/images/fleche.png" alt="fleche">
        <img id="ordinateurLogicielTravail" class="imageFond" src="/sitePortfolio/aProposDeMoi/ordinateurMesLangages.png" alt="ordinateur logiciels travail">

        <h1 class="titre">Mes langages</h1>

        <div class="langage">
            <img src="/sitePortfolio/aProposDeMoi/logoJava.png" alt="logo java">
        </div>

        <div class="langage">
            <img src="/sitePortfolio/aProposDeMoi/logoPhp.png" alt="logo php">
        </div>

        <div class="langage">
            <img src="/sitePortfolio/aProposDeMoi/logoHtmlCssJs.png" alt="logo html css js">
        </div>

        <div class="langage">
            <img src="/sitePortfolio/aProposDeMoi/logoGit.png" alt="logo Git">
        </div>

        <div class="langage">
            <img src="/sitePortfolio/aProposDeMoi/logoSQL.png" alt="logo SQL">
        </div>
    </div>
</main>
</body>
</html>