<?php
require_once '../db_connection.php';

if(isset($_POST['submit'])){
    echo 'TEST';
    foreach($_FILES["filesToUpload"]["tmp_name"] as $key=>$tmp_name){
        $file_name=$_FILES["filesToUpload"]["name"][$key];
        $file_tmp=$_FILES["filesToUpload"]["tmp_name"][$key];
        $file_size=$_FILES["filesToUpload"]["size"][$key];
        $ext=pathinfo($file_name,PATHINFO_EXTENSION);

        $target_dir = $_POST["location"];
        $gallery_id = $_POST["gallery_id"];
        $target_file = $target_dir . basename($file_name);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($file_tmp);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".<br>";
                $uploadOk = 1;
            } else {
                echo "File is not an image.<br>";
                $uploadOk = 0;
            }
        }
    
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.<br>";
            $uploadOk = 0;
        }
    
        // Check file size
        if ($file_size > 5000000) {
            echo "Sorry, your file is too large.<br>";
            $uploadOk = 0;
        }
    
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "webp") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            $uploadOk = 0;
        }
    
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.<br>";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($file_tmp, $target_file)) {
                $insert_img = "INSERT INTO image (gallery_id,extension) VALUES (?,?)";
                $stmt= $bdd->prepare($insert_img);
                $stmt->execute([$gallery_id,$ext]);
                rename($target_file, $target_dir.$bdd->lastInsertId().'.'.$ext);
                echo "The file ". htmlspecialchars(basename($file_name)). " has been uploaded.<br>";
                echo 'TEST';
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        }
    }
}
?>
