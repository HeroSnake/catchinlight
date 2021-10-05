<?php
require_once 'db_connection.php';

if(isset($_POST['submit'])){
    $target_dir = $_POST["location"];
    $gallery_id = $_POST["gallery_id"];
    $valid_ext = array('png', 'jpeg', 'jpg', 'webp');

    if(isset($_FILES['imageMenu'])){

        $file_name=$_FILES["imageMenu"]["name"];
        $file_tmp=$_FILES["imageMenu"]["tmp_name"];
        $file_size=$_FILES["imageMenu"]["size"];
        $ext=pathinfo($file_name,PATHINFO_EXTENSION);
        $target_file = '../'.$target_dir . basename($file_name);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if (!in_array(strtolower($ext), $valid_ext)) {
            echo "$file_name : Invalid file type.";
        } else {
            if (move_uploaded_file($file_tmp, $target_file)) {
                //DELETE PREVIOUS PHOTO
                $query_galleries = $bdd->prepare("SELECT * FROM `galleries` WHERE id = $gallery_id");
                $query_galleries->execute();
                $previous_image = $query_galleries->fetch(\PDO::FETCH_ASSOC)['lien'];
                unlink('../'.$previous_image);
                //UPDATE PHOTO IN BDD
                $query = "UPDATE galleries SET lien=? WHERE id=?";
                $stmt= $bdd->prepare($query);
                $stmt->execute([$target_dir.$file_name, $gallery_id]);
                header("location: ../admin/gallery_edit?cat=" . $gallery_id);
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        }
    }else if(isset($_FILES['filesToUpload'])){

        foreach($_FILES["filesToUpload"]["tmp_name"] as $key=>$tmp_name){
            $file_name=$_FILES["filesToUpload"]["name"][$key];
            $file_tmp=$_FILES["filesToUpload"]["tmp_name"][$key];
            $file_size=$_FILES["filesToUpload"]["size"][$key];
            $location = "../img/gallery/thumbnails/" . $file_name;
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);
            $target_file = $target_dir . basename($file_name);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $info = getimagesize($file_tmp);
            compressImage($info, $file_tmp, $location, 600);

            if (!in_array(strtolower($ext), $valid_ext)) {
                echo "$file_name : Invalid file type.";
            } else {
                if (move_uploaded_file($file_tmp, $target_file)) {

                    $insert_img = "INSERT INTO image (gallery_id,extension,position) VALUES (?,?,?)";
                    $stmt= $bdd->prepare($insert_img);
                    $stmt->execute([$gallery_id,$ext,0]);
                    rename($target_file, $target_dir.$bdd->lastInsertId().'.'.$ext);
                    rename($location, "../img/gallery/thumbnails/".$bdd->lastInsertId().'.'.$ext);
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                } else {
                    echo "Sorry, there was an error uploading your file.<br>";
                }
            }
        }
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
    var_dump($thumb);
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
