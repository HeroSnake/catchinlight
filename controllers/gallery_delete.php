<?php
    require_once '../controllers/db_connection.php';
    $data = json_decode(file_get_contents("php://input"));
    $gallery_id = $data->id;
    $page = $data->page;
    $query_galleries = $bdd->prepare("SELECT * FROM `galleries` WHERE id = $gallery_id");
    $query_galleries->execute();
    $image = $query_galleries->fetch(\PDO::FETCH_ASSOC)['lien'];

    //Supprime image menu
    unlink('../' . $image);

    $sth_picture = $bdd->prepare("SELECT * FROM image WHERE gallery_id = $gallery_id");
    $sth_picture->execute();
    $pictures = $sth_picture->fetchAll(\PDO::FETCH_ASSOC);
    foreach($pictures as $picture){
        $extension = $picture['extension'];
        $id = $picture['id'];
        unlink("../img/gallery/$id.$extension");
    }

    //Supprimer la page de la BDD
    $query_delete_page = $bdd->prepare("DELETE FROM galleries WHERE id = $gallery_id");
    $query_delete_page->execute();

    $query_delete_page = $bdd->prepare("DELETE FROM image WHERE gallery_id = $gallery_id");
    $query_delete_page->execute();
