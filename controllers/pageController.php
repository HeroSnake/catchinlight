<?php
require_once '../controllers/php_functions.php';
$cookie_name  = "visitor";
$cookie_value = "yes";

//Autorisation des cookies
if (isset($_COOKIE["acceptCookies"])) {
    setcookie($cookie_name, $cookie_value, time() + (86400 * 365), "/", "", true); // 86400 = 1 day
}

if (!isset($_COOKIE[$cookie_name])) {
    require_once '../controllers/db_connection.php';
    $update_visitors = $bdd->prepare("UPDATE counter SET visits = visits + 1 WHERE id=1");
    $update_visitors->execute();
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "getPhotos":
            die(json_encode(getPhotos($_GET['id_gallery'])));
        case "getPages":
            die(json_encode(getPages()));
        case "getGalleries":
            die(json_encode(getGalleries()));
        case "getServices":
            die(json_encode(getServices()));
        case "getVideos":
            die(json_encode(getVideos()));
        case "getcaptcha":
            die(json_encode(getcaptcha()));
    }
}

function getPhotos(int $id_gallery): array
{
    require_once '../controllers/db_connection.php';
    $result = [];
    $sth_gallery = $bdd->prepare("SELECT * FROM galleries WHERE id = $id_gallery");
    $sth_gallery->execute();
    $gallery = $sth_gallery->fetch(\PDO::FETCH_ASSOC);
    $result['titre_page'] = $gallery['Nom'];
    $result['columns'] = (int)$gallery['columns'];
    $sth_image = $bdd->prepare("SELECT * FROM image WHERE gallery_id = $id_gallery ORDER BY position");
    $sth_image->execute();
    $result['images'] = $sth_image->fetchAll(\PDO::FETCH_ASSOC);
    return $result;
}

function getPages(): array
{
    require_once '../controllers/db_connection.php';
    $pages = $bdd->prepare("SELECT * FROM pages WHERE visible = 1");
    $pages->execute();
    return $pages->fetchAll(\PDO::FETCH_ASSOC);
}

function getGalleries(): array
{
    require_once '../controllers/db_connection.php';
    $query = $bdd->prepare("SELECT * FROM galleries WHERE visible = 1");
    $query->execute();
    $results = $query->fetchAll(\PDO::FETCH_ASSOC);
    $galleries = [];
    foreach ($results as $result) {
        if($result['sub_cat'] == 1){
            $galleries['sub_galleries'][] = $result;
        }else{
            $galleries['galleries'][] = $result;
        }
    }
    $galleries['sub_galleries_chunks'] = array_chunk($galleries['sub_galleries'],3);
    return $galleries;
}

function getServices(): array
{
    require_once '../controllers/db_connection.php';
    $services = $bdd->prepare("SELECT * FROM services WHERE visible = 1");
    $services->execute();
    return $services->fetchAll(\PDO::FETCH_ASSOC);
}
function getcaptcha(): array
{
    require_once '../controllers/db_connection.php';
    $key = $bdd->prepare("SELECT value FROM cles");
    $key->execute();
    return $key->fetch(\PDO::FETCH_ASSOC);
}

function getVideos(): array
{
    require_once '../controllers/db_connection.php';
    $res = $bdd->prepare("SELECT * FROM video");
    $res->execute();
    $videos = $res->fetchAll(\PDO::FETCH_ASSOC);
    foreach ($videos as &$video) {
        $video_id = explode("embed/", $video['url_video']);
        $video['video_id'] = $video_id[1];
    }
    return $videos;
}
