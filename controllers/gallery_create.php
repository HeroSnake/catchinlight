<?php
require_once '../db_connection.php';
require_once "php_functions.php";

if (isset($_POST['submit'])) {
    $Nom = $_POST["titre_page"]; //Titre écrit en brut
    $Titre = mb_strtoupper($Nom); //Titre du menu
    $lien = strtolower(str_to_noaccent($Nom)); //Lien en minuscule
    $image = $_FILES["image"]["name"];
    $link = 'img/menu/';
    $colonnes = $_POST["colonnes"];
    $visible = "1";
    $gallery_id;

    if (!isset($_POST["visible"])) {
        $visible = "0";
    }

    $data = '
    $titre_page = "'.$Nom.'";
    $meta_description = "Gallerie d\'images";
    $css_gallery = \'<link rel="stylesheet" href="css/grid_img_'.$colonnes.'.css">\';
    require "gallery_generator.php";
    ';

    $query_create_page = "INSERT INTO galleries (Nom,nom_gallery,titre,lien,columns,visible) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt= $bdd->prepare($query_create_page);
    if($stmt->execute([$Nom, $lien, $Titre, $link.$image, $colonnes, $visible])){
        mkdir("../img/" . $lien, 0755);
        $my_file = $lien . '.php';
        $handle = fopen('../' . $my_file, 'w') or die('Cannot open file:  ' . $my_file);
        $data = '<?php $id_gallery = ' . $bdd->lastInsertId() . ';' . $data;
        $gallery_id = $bdd->lastInsertId();
        fwrite($handle, $data); //écris dans le fichier
        require "upload_create.php";
        // Redirection sur la gestion de page
        header("location: ../admin/gallery_edit?cat=" . $bdd->lastInsertId());
    }else{
        var_dump($query_create_page);
        var_dump([$Nom, $lien, $Titre, 'img/menu/'.$image, $visible]);
    }
}