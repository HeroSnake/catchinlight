<?php
    include '../classes/Database.php';
    $data = json_decode(file_get_contents("php://input"));
    $pictures = $data->orderPicture;
    $gallery_id = $data->gallery_id;
    //MAJ ORDRE IMAGES BDD
    foreach($pictures as $key => $picture){
        $query = "UPDATE image SET position=? WHERE id=? AND gallery_id=?";
        $stmt= Database::connect()->prepare($query);
        $stmt->execute([$key, $picture, $gallery_id]);
    }
    //SUPPRESSION BDD ET FICHIER DES IMAGES
    if(isset($data->deletedPictures)){
        $sth_gallery = Database::connect()->prepare("SELECT * FROM galleries WHERE id = $gallery_id");
        $sth_gallery->execute();
        $gallery = $sth_gallery->fetch(\PDO::FETCH_ASSOC);

        //supprimer les images du dossier
        foreach($data->deletedPictures as $deletedPicture){
            $sth_picture = Database::connect()->prepare("SELECT * FROM image WHERE id = $deletedPicture AND gallery_id = $gallery_id");
            $sth_picture->execute();
            $picture = $sth_picture->fetch(\PDO::FETCH_ASSOC);
            $extension = $picture['extension'];
            unlink("../img/gallery/$deletedPicture.$extension");
            unlink("../img/gallery/thumbnails/$deletedPicture.$extension");
        }

        //Supprimer les images de la BDD
        $deletedPictures = implode(',', $data->deletedPictures);
        $query_delete_page = Database::connect()->prepare("DELETE FROM image WHERE gallery_id = $gallery_id AND id IN($deletedPictures)");
        $query_delete_page->execute();
    }