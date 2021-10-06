<?php
include '../classes/Database.php';
require_once "php_functions.php";

if (isset($_POST['submit'])) {
    $Nom = $_POST["titre_page"]; //Titre écrit en brut
    $colonnes = $_POST["colonnes"];
    $desc = $_POST["description"];
    $file_name = $_FILES["image"]["name"];
    $file_tmp = $_FILES["image"]["tmp_name"];
    $file_size = $_FILES["image"]["size"];
    $ext = pathinfo($file_name,PATHINFO_EXTENSION);
    $link = "img/menu/$Nom.$ext";
    $visible = $sub_cat = "1";
    $gallery_id;

    if (!isset($_POST["visible"])) {
        $visible = "0";
    }
    if (!isset($_POST["subCat"])) {
        $visible = "0";
    }

    $query_create_page = "INSERT INTO galleries (Nom,lien,columns,visible,sub_cat,description) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt= Database::connect()->prepare($query_create_page);
    if($stmt->execute([$Nom, $link, $colonnes, $visible, $sub_cat, $desc])){
        $gallery_id = Database::connect()->lastInsertId();
        $target_file = "../$link";
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $info = getimagesize($file_tmp);
        $valid_ext = array('png', 'jpeg', 'jpg', 'webp');
    
        if (!in_array(strtolower($ext), $valid_ext)) {
            echo "$file_name : Invalid file type.";
        } else {
            compressImage($info, $file_tmp, $target_file, 750);
        }
        header("location: ../admin/gallery_edit?cat=" . Database::connect()->lastInsertId());
    }else{
        var_dump($query_create_page);
        var_dump([$Nom, $link, $colonnes, $visible, $sub_cat, $desc]);
    }
}

// Compress image
function compressImage($info, $source, $destination, $max_width)
{
    // Calcul des nouvelles dimensions
    $width = $info[0];
    $height = $info[1];
    $newwidth = $width / $width * $max_width;
    $newheight = $height / $width * $max_width;
    // Chargement
    $thumb = imagecreatetruecolor($newwidth, $newheight);
    switch ($info['mime']) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($source);
            break;
        case 'image/gif':
            $source = imagecreatefromgif($source);
            break;
        case 'image/png':
            $source = imagecreatefrompng($source);
            break;
        case 'image/webp':
            $source = imagecreatefromwebp($source);
            break;
    }
    // Redimensionnement
    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    // Affichage
    imagejpeg($thumb,$destination);
}