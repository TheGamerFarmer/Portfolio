<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Portfolio</title>
    <link rel="icon" type="image/x-icon" href="/icon.jpeg">
    <link rel="stylesheet" href="/sitePortfolio/contact/contact.css">
    <link rel="stylesheet" href="/sitePortfolio/header/header.css">
    <link rel="stylesheet" href="/sitePortfolio/images/images.css">
    <script type="module" src="/sitePortfolio/header/header.js"></script>
</head>

<body>
<?php include("../header/header.php") ?>

<main>
    <img id="fleche" class="imageFond translucide" src="/sitePortfolio/images/fleche.png" alt="fleche">

    <h1>Contact</h1>
    <div id="contact">
        <ul>
            <li>Email: <i>prenom.nom@etu.univ-grenoble-alpes.fr</i></li>
        </ul>
        <img id="contactImg" src="/sitePortfolio/contact/contactImage.png" alt="Contact image">
        <ul>
            <li>GitHub: <i><a href="https://github.com/TheGamerFarmer">TheGamerFarmer</a></i></li>
            <li>LinkedIn: <i><a href="https://www.linkedin.com/in/raphael-matheret">Raphaël M</a></i></li>
        </ul>
    </div>
    <div id="formMessage">
        <img src="/sitePortfolio/contact/form arrow.png" alt="first arrow">
        <p>Écrivez votre message ici:</p>
        <img src="/sitePortfolio/contact/form arrow.png" alt="second arrow">
    </div>

    <form method="POST">
        <label>
            <input class="textField" type="email" name="email" placeholder="Email" required>
        </label>
        <label>
            <input class="textField" type="text" name="nom" placeholder="Nom" required>
        </label>
        <label>
            <textarea name="message" placeholder="Message" required></textarea>
        </label>
        <input id="submit" type="submit" value="Envoyer">
    </form>

    <?php
    if (isset($_POST["message"])) {
        mail("nicolas.hili@univ-grenoble-alpes.fr",
            "Porfolio: " . $_POST["nom"],
            $_POST["message"],
            "From:portfolio@raphael.zron.fr\r\nReply-To:" . $_POST["email"]);
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