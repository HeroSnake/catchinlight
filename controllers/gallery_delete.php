<?php
    include '../classes/Database.php';
    $data = json_decode(file_get_contents("php://input"));
    $gallery_id = $data->id;
    $page = $data->page;
    $query_galleries = Database::connect()->prepare("SELECT * FROM `galleries` WHERE id = $gallery_id");
    $query_galleries->execute();
    $image = $query_galleries->fetch(\PDO::FETCH_ASSOC)['lien'];

    //Supprime image menu
    unlink('../' . $image);

    $sth_picture = Database::connect()->prepare("SELECT * FROM image WHERE gallery_id = $gallery_id");
    $sth_picture->execute();
    $pictures = $sth_picture->fetchAll(\PDO::FETCH_ASSOC);
    foreach($pictures as $picture){
        $extension = $picture['extension'];
        $id = $picture['id'];
        unlink("../img/gallery/$id.$extension");
    }

    //Supprimer la page de la BDD
    $query_delete_page = Database::connect()->prepare("DELETE FROM galleries WHERE id = $gallery_id");
    $query_delete_page->execute();

    $query_delete_page = Database::connect()->prepare("DELETE FROM image WHERE gallery_id = $gallery_id");
    $query_delete_page->execute();
