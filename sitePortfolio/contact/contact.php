<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Portfolio</title>
    <link rel="icon" type="image/x-icon" href="/icon.jpeg">
    <link rel="stylesheet" href="/sitePortfolio/contact/contact.css">
    <link rel="stylesheet" href="/sitePortfolio/headerAndFooter/headerAndFooter.css">
    <link rel="stylesheet" href="/sitePortfolio/images/images.css">
</head>

<body>
<?php include("../headerAndFooter/header.php") ?>

<main>
    <img id="fleche" class="imageFond translucide" src="/sitePortfolio/images/fleche.png" alt="fleche">

    <h1>Contact</h1>
    <div id="contact">
        <ul>
            <li><i>Tel: </i>0786870606</li>
            <li><i>Email: </i>prenom.nom@etu.univ-grenoble-alpes.fr</li>
        </ul>
        <img src="/sitePortfolio/contact/contactImage.png" alt="Contact image">
        <ul>
            <li><i>Adresse: </i>7 impasse du geai, 38410 Saint Martin d'Uriage</li>
        </ul>
    </div>
    <div id="formMessage">
        <img src="/sitePortfolio/contact/form arrow.png" alt="first arrow">
        <p>Écrivez directement votre message ici:</p>
        <img src="/sitePortfolio/contact/form arrow.png" alt="second arrow">
    </div>

    <form method="POST">
        <input class="textField" type="email" name="email" placeholder="Email" required>
        <input class="textField" type="text" name="nom" placeholder="Nom" required>
        <textarea name="message" placeholder="Message" required></textarea>
        <input id="submit" type="submit" value="Envoyer">
    </form>

    <?php
    if (isset($_POST["message"])) {
        mail("raphaelmatheret@gmail.com",
            "Porfolio: " . $_POST["nom"],
            $_POST["message"],
            "From:portfolio@raphael.zron.fr\r\nReply-To:" . $_POST["email"]);
    }
    ?>

    <img id="imageBasGauche" class="imageFond translucide" src="/sitePortfolio/contact/imageBasGauche.png" alt="image bas gauche">
</main>
</body>
</html>