<?php
require_once '../controllers/db_connection.php';
require_once "php_functions.php";

if (isset($_POST['submit'])) {
    $Nom = $_POST["titre_page"]; //Titre écrit en brut
    $colonnes = $_POST["colonnes"];
    $desc = $_POST["description"];
    $image = $_FILES["image"]["name"];
    $link = 'img/menu/';
    $visible = $sub_cat = "1";
    $gallery_id;

    if (!isset($_POST["visible"])) {
        $visible = "0";
    }
    if (!isset($_POST["subCat"])) {
        $visible = "0";
    }

    $query_create_page = "INSERT INTO galleries (Nom,lien,columns,visible,sub_cat,description) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt= $bdd->prepare($query_create_page);
    if($stmt->execute([$Nom, $link.$image, $colonnes, $visible, $sub_cat, $desc])){
        $gallery_id = $bdd->lastInsertId();
        require "upload_create.php";
        header("location: ../admin/gallery_edit?cat=" . $bdd->lastInsertId());
    }else{
        var_dump($query_create_page);
        var_dump([$Nom, $link.$image, $colonnes, $visible, $sub_cat, $desc]);
    }
}