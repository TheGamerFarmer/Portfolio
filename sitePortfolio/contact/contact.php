<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Contact — Raphaël MATHERET</title>
    <meta name="description" content="Contactez Raphaël MATHERET par email, GitHub ou LinkedIn.">
    <meta property="og:title" content="Contact — Raphaël MATHERET">
    <meta property="og:description" content="Contactez Raphaël MATHERET par email, GitHub ou LinkedIn.">
    <meta property="og:image" content="https://raphael.zron.fr/sitePortfolio/aProposDeMoi/photo.jpeg">
    <meta property="og:url" content="https://raphael.zron.fr/portfolio/contact">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/x-icon" href="/icon.jpeg">
    <link rel="stylesheet" href="/sitePortfolio/contact/contact.css">
    <?php include("../header/headerHead.html") ?>
</head>

<body>
<?php include("../header/header.php") ?>

<main>
    <img id="fleche" class="imageFond translucide" src="/sitePortfolio/images/fleche.png" alt="fleche">

    <h1>Contact</h1>
    <div id="contact" class="reveal">
        <ul>
            <li>Email: <i>prenom.nom@etu.univ-grenoble-alpes.fr</i></li>
        </ul>
        <img id="contactImg" src="/sitePortfolio/contact/contactImage.png" alt="Contact image">
        <ul>
            <li>GitHub: <i><a href="https://github.com/TheGamerFarmer">TheGamerFarmer</a></i></li>
            <li>LinkedIn: <i><a href="https://www.linkedin.com/in/raphael-matheret">Raphaël M</a></i></li>
        </ul>
    </div>
    <div id="formMessage" class="reveal stagger-1">
        <img src="/sitePortfolio/contact/form arrow.png" alt="first arrow">
        <p>Écrivez votre message ici:</p>
        <img src="/sitePortfolio/contact/form arrow.png" alt="second arrow">
    </div>

    <form method="POST" class="reveal stagger-2">
        <input id="mail" class="textField" type="email" name="email" placeholder="Email" required>
        <label for="mail"></label>
        <input id="name" class="textField" type="text" name="nom" placeholder="Nom" required>
        <label for="name"></label>
        <textarea id="message" name="message" placeholder="Message" required></textarea>
        <label for="message"></label>
        <input id="submit" type="submit" value="Envoyer">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email   = trim($_POST["email"] ?? "");
        $nom     = trim($_POST["nom"] ?? "");
        $message = trim($_POST["message"] ?? "");

        $erreurs = [];

        if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreurs[] = "L'adresse email est invalide.";
        }
        if ($nom === "") {
            $erreurs[] = "Le nom est requis.";
        }
        if ($message === "") {
            $erreurs[] = "Le message est requis.";
        }

        if (empty($erreurs)) {
            $sujet  = "Portfolio: " . htmlspecialchars($nom, ENT_QUOTES, "UTF-8");
            $corps  = htmlspecialchars($message, ENT_QUOTES, "UTF-8");
            $entetes = "From: portfolio@raphael.zron.fr\r\nReply-To: " . htmlspecialchars($email, ENT_QUOTES, "UTF-8");

            if (mail("raphaelmatheret@gmail.com", $sujet, $corps, $entetes)) {
                echo '<p class="formRetour succes">Message envoyé avec succès !</p>';
            } else {
                echo '<p class="formRetour erreur">Une erreur est survenue, veuillez réessayer.</p>';
            }
        } else {
            foreach ($erreurs as $err) {
                echo '<p class="formRetour erreur">' . htmlspecialchars($err, ENT_QUOTES, "UTF-8") . '</p>';
            }
        }
    }
    ?>

    <img id="imageBasGauche" class="imageFond translucide" src="/sitePortfolio/contact/imageBasGauche.png" alt="image bas gauche">
</main>
</body>
</html>