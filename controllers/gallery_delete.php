<?php
    require_once '../db_connection.php';
    $data = json_decode(file_get_contents("php://input"));
    $gallery_id = $data->id;
    $page = $data->page;

    //Supprime la page PHP
    unlink('../' . $page . '.php');

    //Vide le dossier
    array_map( 'unlink', array_filter((array) glob("../img/". $page ."/*") ) );

    //Supprime le dossier
    rmdir('../img/' . $page);

    //Supprimer la page de la BDD
    $query_delete_page = $bdd->prepare("DELETE FROM galleries WHERE id = $gallery_id");
    $query_delete_page->execute();

    $query_delete_page = $bdd->prepare("DELETE FROM image WHERE gallery_id = $gallery_id");
    $query_delete_page->execute();
