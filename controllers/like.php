<?php
if (isset($_GET['action']) && $_GET['action'] == 'like') {
    die(like($_POST['like'], $_POST['gallery_id'], $_POST['image_id']));
}

function like(string $like, string $gallery_id, string $image_id) :void
{
    require_once 'db_connection.php';
    var_dump($like);
    if($like == 'true'){
        $query_update_visitors = $bdd->prepare("UPDATE image SET likes = likes + 1 WHERE id=$image_id and gallery_id=$gallery_id");
        $query_update_visitors->execute();
        setcookie($image_id, true, time() + (86400 * 365 * 10), "/", "", true); // 86400 = 1 day
    }else if($like == 'false'){
        $query_update_visitors = $bdd->prepare("UPDATE image SET likes = likes - 1 WHERE id=$image_id and gallery_id=$gallery_id");
        $query_update_visitors->execute();
        setcookie($image_id, '', time(), "/", "", true); // 86400 = 1 day
    }
}
