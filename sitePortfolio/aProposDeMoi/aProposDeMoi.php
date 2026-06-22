<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>À propos — Raphaël MATHERET</title>
    <meta name="description" content="Développeur logiciel passionné d'informatique et de jeux vidéo. Découvrez mon parcours, mes expériences et mes compétences.">
    <meta property="og:title" content="À propos — Raphaël MATHERET">
    <meta property="og:description" content="Développeur logiciel passionné d'informatique et de jeux vidéo. Découvrez mon parcours, mes expériences et mes compétences.">
    <meta property="og:image" content="https://raphael.zron.fr/sitePortfolio/aProposDeMoi/photo.jpg">
    <meta property="og:url" content="https://raphael.zron.fr/portfolio">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/x-icon" href="/icon.jpeg">
    <link rel="stylesheet" href="/sitePortfolio/aProposDeMoi/aProposDeMoi.css">
    <?php include("../header/headerHead.html") ?>
</head>

<body>
<?php include("../header/header.php") ?>

<main>
    <div id="presentation" class="partie">
        <img id="empreinteDigitale" class="imageFond translucide" src="/sitePortfolio/aProposDeMoi/empreinteDigitale.png" alt="empreinte digitale">

        <div id="presentation-text" class="reveal-left">
            <h1 class="titre">Présentation</h1>
            <p>Bonjour, je m'appelle Raphaël MATHERET, j'ai <?= (new DateTime('2006-09-21'))->diff(new DateTime())->y ?> ans.<br>
                Je suis passionné d'informatique et de jeux vidéo depuis tout petit. Ce qui m'attire en informatique,
                c'est le challenge intellectuel : trouver la bonne solution à un problème et pouvoir être fier du résultat.
                Cet attrait pour l'optimisation dépasse largement le code : Satisfactory est un
                de mes jeux vidéo préférés, et c'est uniquement centré sur ça. <br>
                Côté technique, je me retrouve naturellement sur le backend et la logique métier plutôt que sur les interfaces.
            </p>
        </div>

        <img id="selfie" class="reveal-right" src="/sitePortfolio/aProposDeMoi/photo.jpg" alt="photo Présentation">
        <img class="circuitElectric imageFond translucide" src="/sitePortfolio/aProposDeMoi/circuitElectric.png" alt="circuit électrique">
    </div>

    <div id="mesExperiences" class="partie">
        <img class="circuitElectric imageFond translucide" src="/sitePortfolio/aProposDeMoi/circuitElectric.png" alt="circuit électrique">
        <img id="flecheMesExperiences" class="imageFond translucide" src="/sitePortfolio/images/fleche.png" alt="fleche">

        <h1 class="titre">Mes expériences</h1>
        <ul>
            <li class="reveal stagger-1">
                <img src="/sitePortfolio/aProposDeMoi/experiencesPrefix.png" alt="Éxpériences préfix">
                <div class="exempleText">
                    <h2>BNP Paribas</h2>
                    <p>J'ai effectué un stage de 2 mois au sein de l'IT group de BNP Paribas à Paris, en fin de deuxième année de BUT Informatique.
                        J'y ai intégré une équipe d'une quinzaine de développeurs en tant que développeur backend.
                        Cette expérience m'a permis de découvrir le travail en entreprise,
                        avec ses processus et ses contraintes propres.</p>
                </div>
            </li>

            <li class="reveal stagger-2">
                <img src="/sitePortfolio/aProposDeMoi/experiencesPrefix.png" alt="Éxpériences préfix">
                <div class="exempleText">
                    <h2>Weatheria</h2>
                    <p>J'ai fait partie pendant 2 ans de ce projet de serveur Minecraft, aujourd'hui fermé, en tant que développeur.
                        Nous étions une dizaine, avec une hiérarchie bien définie pour faciliter l'avancement du projet.
                        Nous organisions des réunions hebdomadaires avec notre responsable de pôle, ainsi qu'une réunion
                        mensuelle pour faire un point entre les pôles.
                    </p>
                </div>
            </li>
            <li class="reveal stagger-3">
                <img src="/sitePortfolio/aProposDeMoi/experiencesPrefix.png" alt="Éxpériences préfix">
                <div class="exempleText">
                    <h2>Périscolaire</h2>
                    <p>J’ai eu l’occasion de passer un mois en périscolaire dans une école primaire, en remplacement d’une animatrice.
                        J’aidais principalement à gérer la pause méridienne et le repas du midi. J’ai également participé
                        à l’organisation de la kermesse de fin d’année, en créant un diaporama des meilleures photos et vidéos de l’année.</p>
                </div>
            </li>

            <li class="reveal stagger-4">
                <img src="/sitePortfolio/aProposDeMoi/experiencesPrefix.png" alt="Éxpériences préfix">
                <div class="exempleText">
                    <h2>Youtube</h2>
                    <p>J’ai tenu une chaîne YouTube : <a href="https://www.youtube.com/@thegamerfarmer">TheGamerFarmer</a>.
                        L’objectif était de me former au montage vidéo et de m’entraîner à m’exprimer à l’oral.
                        Le projet s’est arrêté, mais l’expérience m’a appris à me lancer seul dans quelque chose de nouveau
                        et à apprendre sur le tas, une habitude que j’ai gardée dans l'informatique.</p>
                </div>
            </li>
        </ul>

        <img id="engrenage" class="imageFond" src="/sitePortfolio/aProposDeMoi/engrenage.png" alt="engrenage">
    </div>

    <div id="mesOutils" class="partie">
        <img id="imageLocigielsTravail" class="imageFond translucide" src="/sitePortfolio/aProposDeMoi/imageMesOutils.png" alt="image logiciels travail">
        <img id="flecheMesLangagges" class="imageFond translucide" src="/sitePortfolio/images/fleche.png" alt="fleche">
        <img id="ordinateurLogicielTravail" class="imageFond" src="/sitePortfolio/aProposDeMoi/ordinateurMesOutils.png" alt="ordinateur logiciels travail">

        <h1 class="titre">Mes outils</h1>

        <div class="langage reveal-scale stagger-1">
            <img src="/sitePortfolio/aProposDeMoi/logoJava.png" alt="logo java">
        </div>

        <div class="langage reveal-scale stagger-2">
            <img src="/sitePortfolio/aProposDeMoi/logoPhp.png" alt="logo php">
        </div>

        <div class="langage reveal-scale stagger-3">
            <img src="/sitePortfolio/aProposDeMoi/logoHtmlCssJs.png" alt="logo html css js">
        </div>

        <div class="langage reveal-scale stagger-4">
            <img src="/sitePortfolio/aProposDeMoi/logoCC++.png" alt="logo C / C++">
        </div>

        <div class="langage reveal-scale stagger-5">
            <img src="/sitePortfolio/aProposDeMoi/logoSQL.png" alt="logo SQL">
        </div>
    </div>
</main>
</body>
</html>