<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Gestion projets</title>
    <link rel="icon" type="image/x-icon" href="/icon.jpeg">
    <link rel="stylesheet" href="/sitePortfolio/gestionProjets/gestionProjets.css">
    <?php include("../header/headerHead.html") ?>
    <script type="module" src="/sitePortfolio/gestionProjets/gestionProjets.js"></script>
</head>

<body>
<?php
require_once "../../BDD/librairie.php";
require_once "../../BDD/BDD.php";
$bdd = connectDatabase();
include("../header/header.php");
?>

<main>
    <h1>Gestion projets</h1>
    <form id="formulaire" method="POST" action="" enctype="multipart/form-data">
        <h2 class="sousTitre">Nouveau projet</h2>
        <label for="titre">Titre :</label>
        <input id="titre" type="text" name="titre" placeholder="titre" required>

        <label for="contexte">Contexte :</label>
        <textarea id="contexte" name="contexte" placeholder="Contexte" required></textarea>

        <label for="technologies">Technologies utilisées :</label>
        <textarea id="technologies" name="technologies" placeholder="Technologies utilisées" required></textarea>

        <label for="role">Mon rôle :</label>
        <textarea id="role" name="role" placeholder="Mon rôle" required></textarea>

        <label for="defis">Défis :</label>
        <textarea id="defis" name="defis" placeholder="Défis techniques" required></textarea>

        <input id="fileInput" type="file" name="medias[]" accept="image/*,video/*" multiple>
        <button id="fileInputButton" type="button">Ajouter des images ou vidéos</button>
        <div id="preview"></div>

        <div id="buttons">
            <button id="submitBtn" type="submit">Enregistrer</button>
        </div>
    </form>

    <?php
    if (isset($_POST["titre"])) {
        $uploadDirImages = __DIR__ . '/../projets/images/';
        $imagesNames = [];
        $uploadDirVideos = __DIR__ . '/../projets/videos/';
        $videosNames = [];

        if (isset($_FILES['medias'])) {
            foreach ($_FILES['medias']['tmp_name'] as $key => $tmpName) {
                $fileName = generateRandomString() . " " . basename($_FILES['medias']['name'][$key]);

                if ($_FILES['medias']['error'][$key] === UPLOAD_ERR_INI_SIZE || $_FILES['medias']['error'][$key] === UPLOAD_ERR_FORM_SIZE) {
                    http_response_code(413);
                    echo "Le fichier \"" . basename($_FILES['medias']['name'][$key]) . "\" est trop volumineux.";
                    exit;
                }

                if (empty($tmpName) || !file_exists($tmpName)) {
                    continue;
                }

                $fileType = mime_content_type($tmpName);

                if (str_starts_with($fileType, 'image')) {
                    $targetFile = $uploadDirImages . $fileName;
                    if (move_uploaded_file($tmpName, $targetFile)) {
                        $imagesNames[$key] = $fileName;
                    }
                } else if (str_starts_with($fileType, 'video')) {
                    $targetFile = $uploadDirVideos . $fileName;
                    if (move_uploaded_file($tmpName, $targetFile)) {
                        $videosNames[$key] = $fileName;
                    }
                }
            }
        }

        $nextOrdre = (int)$bdd->query("SELECT COALESCE(MAX(ordre) + 1, 0) FROM projets")->fetchColumn();
        $stmt = $bdd->prepare("INSERT INTO projets (title, contexte, technologies, role, defis, ordre) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([urldecode($_POST["titre"]), urldecode($_POST["contexte"]), urldecode($_POST["technologies"]), urldecode($_POST["role"]), urldecode($_POST["defis"]), $nextOrdre]);

        $projectID = $bdd->lastInsertId();

        $stmtImg = $bdd->prepare("INSERT INTO projetsImages (projetID, lienImage, ordre) VALUES (?, ?, ?)");
        foreach ($imagesNames as $key => $image) {
            $ordre = isset($_POST['mediasOrdres'][$key]) ? (int)$_POST['mediasOrdres'][$key] : $key;
            $stmtImg->execute([$projectID, $image, $ordre]);
        }

        $stmtVid = $bdd->prepare("INSERT INTO projetsVideos (projetID, lienVideo, ordre) VALUES (?, ?, ?)");
        foreach ($videosNames as $key => $video) {
            $ordre = isset($_POST['mediasOrdres'][$key]) ? (int)$_POST['mediasOrdres'][$key] : $key;
            $stmtVid->execute([$projectID, $video, $ordre]);
        }
    }
    ?>

    <div id="modificationProjets">
        <h2 class="sousTitre">Modification des projets</h2>

        <div id="projets">
            <?php
            $imagesDir = '/sitePortfolio/projets/images/';
            $videosDir = '/sitePortfolio/projets/videos/';

            $projets = $bdd -> query("SELECT * FROM projets ORDER BY ordre") -> getIterator();

            while ($projets -> valid()) {
                $projet = $projets -> current();
                ?>
                <div class='projet'>
                    <button id="modifyProjet:<?= $projet["projetID"] ?>">✏️</button>
                    <button id="suppProjet:<?= $projet["projetID"] ?>">🗑️</button>
                    <h2 class='title'><?= $projet["title"] ?></h2>
                </div>

                <?php
                $projets -> next();
            }
            ?>
    </div>
</main>

</body>
</html>