<?php
if (isset($_FILES['filesToUpload'])) {
    foreach ($_FILES["filesToUpload"]["tmp_name"] as $key => $tmp_name) {
        $file_name = $_FILES["filesToUpload"]["name"][$key];
        $file_tmp = $_FILES["filesToUpload"]["tmp_name"][$key];
        $location = "../img/gallery/thumbnails/" . $file_name;
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $valid_ext = array('png', 'jpeg', 'jpg', 'webp');
        if (in_array(strtolower($ext), $valid_ext)) {
            compressImage($file_tmp, $location, 600);
        } else {
            echo "$file_name : Invalid file type.";
        }
    }
}

// Compress image
function compressImage($source, $destination, $max_width)
{
    // Calcul des nouvelles dimensions
    $info = getimagesize($source);
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
?>
<form action="compress_image.php" method="post" enctype="multipart/form-data">
    <input id="image_picker" type="file" name="filesToUpload[]" accept="image/*" multiple required></input>
    <input class="btn" type="submit" value="Créer" name="submit"></input>
</form>