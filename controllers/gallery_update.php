<?php
require_once '../db_connection.php';
require_once "php_functions.php";
if (isset($_POST["titre_page"]) || isset($_POST["image"]) || isset($_POST["colonnes"])) {
    $gallery_id = $_POST['gallery_id'];
    $Nom = $_POST["titre_page"]; //Titre écrit en brut
    $Titre = mb_strtoupper($Nom); //Titre du menu
    $lien = strtolower(str_to_noaccent($Nom)); //Lien en minuscule
    $visible = 1;
    $image = $_POST["image"];
    $columns = $_POST["colonnes"];

    if (!isset($_POST["visible"])) {
        $visible = 0;
    }
    if ($image != "") {
        $query_create_page = "UPDATE galleries SET Nom=?, nom_gallery=?, titre=?, lien=?, columns=?, visible=? WHERE id=?";
        $stmt= $bdd->prepare($query_create_page);
        $stmt->execute([$Nom, $lien, $Titre, 'img/menu/'.$image, $columns, $visible, $gallery_id]);
    } else {
        $query_create_page = "UPDATE galleries SET Nom=?, nom_gallery=?, titre=?, columns=?, visible=? WHERE id=?";
        $stmt= $bdd->prepare($query_create_page);
        $stmt->execute([$Nom, $lien, $Titre, $columns, $visible, $gallery_id]);
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
