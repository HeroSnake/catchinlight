<?php
    require_once '../db_connection.php';
    require_once '../controllers/unaccent.php';
    require_once "php_functions.php";
    if (isset($_POST["titre_page"]) && isset($_POST["image"])) {
        $Nom = $_POST["titre_page"]; //Titre écrit en brut
        $lien = strtolower(unaccent($Nom)); //Lien en minuscule
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

        $query_create_page = "INSERT INTO pages (nom, titre_lien, image, visible, ordre)
        VALUES (?, ?, ?, ?, ?)";
        $stmt= $bdd->prepare($query_create_page);
        if($stmt->execute([$Nom, $lien, 'img/accueil/containers/'.$image, $visible, 0])){
            $my_file = $lien . '.php';
            $handle = fopen('../' . $my_file, 'w') or die('Cannot open file:  ' . $my_file);
    
            fwrite($handle, $data); //écris dans le fichier
    
            // Redirection sur la page créée
            header("location: ../index.php");
        }
    }

