<?php
require_once '../db_connection.php';
$data = json_decode(file_get_contents("php://input"));
$page_id = $data->id;
$page = $data->page;
$query_images = $bdd->prepare("SELECT * FROM pages WHERE id = $page_id");
$query_images->execute();
$image = $query_images->fetch(\PDO::FETCH_ASSOC)['image'];

//Supprime la page PHP
unlink('../' . $page . '.php');
//Supprime l'image d'index'
unlink('../' . $image);

//Supprimer la page de la BDD
$query_create_page = $bdd->prepare("DELETE FROM pages WHERE id = $page_id");
$query_create_page->execute();
