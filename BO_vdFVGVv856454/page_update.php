<?php
require_once "core_BO.php";
require_once "php_functions.php";
if (isset($_POST["titre_page"]) && isset($_POST["image"])) {
    $page_id = $_POST['page_id'];
    $Nom = $_POST['titre_page'];
    $lien = $_POST["lien_page"]; //Lien en minuscule
    $visible = 1;
    $image = $_POST["image"];

    if (!isset($_POST["visible"])) {
        $visible = 0;
    }
    if ($image != "") {
        $query_create_page = "UPDATE pages SET nom=?, titre_lien=?, image=?, visible=? WHERE id=?";
        $stmt= $bdd->prepare($query_create_page);
        $stmt->execute([$Nom, $lien, 'img/accueil/containers/'.$image, $visible, $page_id]);
    } else {
        $query_create_page = "UPDATE pages SET nom=?, titre_lien=?, visible=? WHERE id=?";
        echo 'UPDATE pages SET nom='.$Nom.', titre_lien='.$lien.', visible='.$visible.' WHERE id='.$page_id;
        $stmt= $bdd->prepare($query_create_page);
        $stmt->execute([$Nom, $lien, $visible, $page_id]);
    }

    // Redirection sur la page créée
    // header("location: page_liste");
}
