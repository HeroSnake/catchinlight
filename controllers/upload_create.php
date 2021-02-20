<?php
if(isset($_FILES['image'])){
    $file_name=$_FILES["image"]["name"];
    $file_tmp=$_FILES["image"]["tmp_name"];
    $file_size=$_FILES["image"]["size"];
    $ext=pathinfo($file_name,PATHINFO_EXTENSION);
    $target_file =  '../' . $link . basename($file_name);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $uploadOk = checkImage($file_tmp, $file_size, $target_file, $imageFileType);
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.<br>";
        // if everything is ok, try to upload file
    } else {
        if (!move_uploaded_file($file_tmp, $target_file)) {
            echo "Sorry, there was an error uploading your file.<br>";
        }
    }
}
function checkImage($file_tmp, $file_size, $target_file, $imageFileType){
    $uploadOk = 1;
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
    return $uploadOk;
}
?>
