<?php
include '../classes/Database.php';
require_once "php_functions.php";
if (isset($_POST["submit"])) {
    $page_id = $_POST['page_id'];
    $Nom = $_POST['titre_page'];
    $visible = 1;
    if(isset($_POST["image"])){
        $image = $_POST["image"];
    }

    if (!isset($_POST["visible"])) {
        $visible = 0;
    }
    if (isset($image)) {
        $query_create_page = "UPDATE pages SET nom=?, image=?, visible=? WHERE id=?";
        $stmt= Database::connect()->prepare($query_create_page);
        $stmt->execute([$Nom, $link.$image, $visible, $page_id]);
    } else {
        $query_create_page = "UPDATE pages SET nom=?, visible=? WHERE id=?";
        $stmt= Database::connect()->prepare($query_create_page);
        $stmt->execute([$Nom, $visible, $page_id]);
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
