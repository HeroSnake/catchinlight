<?php
require_once "core_BO.php";
require_once "php_functions.php";
if (isset($_POST["titre_page"]) && isset($_POST["image"])) {
    $category_id = $_POST['category_id'];
    $Nom = $_POST["titre_page"]; //Titre écrit en brut
    $Titre = mb_strtoupper($Nom); //Titre du menu
    $lien = strtolower(str_to_noaccent($Nom)); //Lien en minuscule
    $visible = 1;
    $image = $_POST["image"];

    if (!isset($_POST["visible"])) {
        $visible = 0;
    }
    if ($image != "") {
        $query_create_page = "UPDATE categorie SET NOM=?, nom_categorie=?, titre=?, lien=?, visible=? WHERE id=?";
        $stmt= $bdd->prepare($query_create_page);
        $stmt->execute([$Nom, $lien, $Titre, 'img/menu/'.$image, $visible, $category_id]);
    } else {
        $query_create_page = "UPDATE categorie SET NOM=?, nom_categorie=?, titre=?, visible=? WHERE id=?";
        $stmt= $bdd->prepare($query_create_page);
        $stmt->execute([$Nom, $lien, $Titre, $visible, $category_id]);
    }

    // Redirection sur la page créée
    header("location: gallery_liste");
}
