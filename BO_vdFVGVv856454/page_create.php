<?php
require_once "core_BO.php";
require_once "php_functions.php";
if (isset($_POST["titre_page"]) && isset($_POST["image"])) {
    $Nom = $_POST["titre_page"]; //Titre écrit en brut
    $lien = $_POST["lien_page"]; //Lien en minuscule
    $image = $_POST["image"];
    $meta_desc = $_POST["meta_desc"];
    $visible = "1";

    if (!isset($_POST["visible"])) {
        $visible = "0";
    }

    $data = '<?php // pour la page maître
    $pageName = basename(__FILE__);
    $titre_page = "'.$Nom.'";
    $meta_description = "' .$meta_desc. '";
    require_once "corePage.php";
    require_once "endPage.php";
    ?>';

    $my_file = $lien . '.php';
    $handle = fopen('../' . $my_file, 'w') or die('Cannot open file:  ' . $my_file);

    fwrite($handle, $data); //écris dans le fichier

    $query_create_page = "INSERT INTO pages (nom, titre_lien, image, visible)
    VALUES (?, ?, ?, ?)";
    $stmt= $bdd->prepare($query_create_page);
    $stmt->execute([$Nom, $lien, 'img/accueil/containers/'.$image, $visible]);

    // Redirection sur la page créée
    header("location: ../index.php");
}

