<?php
require_once '../db_connection.php';
$data = json_decode(file_get_contents("php://input"));
$like = $data->like;
$image_id = $data->image_id;
$gallery_id = $data->gallery_id;
if($like){
    $query_update_visitors = $bdd->prepare("UPDATE image SET likes = likes + 1 WHERE id=$image_id and gallery_id=$gallery_id");
    $query_update_visitors->execute();
    setcookie($image_id, true, time() + (86400 * 365 * 10), "/", "", true); // 86400 = 1 day
}else{
    $query_update_visitors = $bdd->prepare("UPDATE image SET likes = likes - 1 WHERE id=$image_id and gallery_id=$gallery_id");
    $query_update_visitors->execute();
    setcookie($image_id, '', time(), "/", "", true); // 86400 = 1 day
}
