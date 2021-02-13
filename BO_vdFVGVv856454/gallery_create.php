<?php
require_once "core_BO.php";
require_once "php_functions.php";
if (isset($_POST["titre_page"]) && isset($_POST["image"])) {
    $Nom = $_POST["titre_page"]; //Titre écrit en brut
    $Titre = mb_strtoupper($Nom); //Titre du menu
    $lien = strtolower(str_to_noaccent($Nom)); //Lien en minuscule
    $image = $_POST["image"];
    $colonnes = $_POST["colonnes"];
    $visible = "1";

    if (!isset($_POST["visible"])) {
        $visible = "0";
    }

    $data = '
    $titre_page = "'.$Nom.'";
    $meta_description = "Gallerie d\'images";
    $css_gallery = \'<link rel="stylesheet" href="css/grid_img_'.$colonnes.'.css">\';
    require "gallery_generator.php";
    ';

    $query_create_page = "INSERT INTO galleries (Nom,nom_gallery,titre,lien,visible) VALUES (?, ?, ?, ?, ?)";
    $stmt= $bdd->prepare($query_create_page);
    if($stmt->execute([$Nom, $lien, $Titre, 'img/menu/'.$image, $visible])){
        mkdir("../img/" . $lien, 0755);
        $my_file = $lien . '.php';
        $handle = fopen('../' . $my_file, 'w') or die('Cannot open file:  ' . $my_file);
        $data = '<?php $id_gallery = ' . $bdd->lastInsertId() . ';' . $data;
        fwrite($handle, $data); //écris dans le fichier
        // Redirection sur la gestion de page
        header("location: gallery_edit?cat=" . $bdd->lastInsertId());
    }else{
        var_dump($query_create_page);
        var_dump([$Nom, $lien, $Titre, 'img/menu/'.$image, $visible]);
    }
}