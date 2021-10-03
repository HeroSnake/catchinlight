<?php
require_once 'db_connection.php';
$data = json_decode(file_get_contents("php://input"));
if (isset($data->sub_cat)) {
    $query_create_page = "UPDATE galleries SET sub_cat=? WHERE id=?";
    $stmt= $bdd->prepare($query_create_page);
    $stmt->execute([$data->sub_cat, $data->gallery_id]);
}
if (isset($data->visible)) {
    $query_create_page = "UPDATE galleries SET visible=? WHERE id=?";
    $stmt= $bdd->prepare($query_create_page);
    $stmt->execute([$data->visible, $data->gallery_id]);
}