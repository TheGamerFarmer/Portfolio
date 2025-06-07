<?php
$bdd = null;

function connectDatabase(): PDO {
    global $bdd;
    $bdd = new PDO('mysql:host=localhost;dbname=portfolio', "root", "");
    return $bdd;
}

function addProject($title, $description, $competences, $objectifs, $travailEnGroupe, $travailIndividuel, $aquis, $images, $videos): void {
    global $bdd;

    $bdd -> query("INSERT INTO projets (title, description, competences, objectifs, travail_En_Groupe, travail_individuel, savoir_Faire_Aquis)
            VALUES ('$title', '$description', '$competences', '$objectifs', '$travailEnGroupe', '$travailIndividuel', '$aquis')");

    $projectID = $bdd -> query("SELECT max(projetID) FROM projets") -> fetchColumn();

    forEach($images as $image) {
        $bdd -> query("INSERT INTO projetsImages (projetID, lienImage) VALUES ('$projectID', '$image')");
    }

    forEach($videos as $video) {
        $bdd -> query("INSERT INTO projetsVideos (projetID, lienVideo) VALUES ('$projectID', '$video')");
    }
}