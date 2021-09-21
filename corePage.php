<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once 'db_connection.php';
require_once "./controllers/php_functions.php";
$cookie_name  = "visitor";
$cookie_value = "yes";

//Autorisation des cookies
if (isset($_COOKIE["acceptCookies"])) {
    setcookie($cookie_name, $cookie_value, time() + (86400 * 365), "/", "", true); // 86400 = 1 day
}

if (!isset($_COOKIE[$cookie_name])) {
    $query_update_visitors = $bdd->prepare("UPDATE counter SET visits = visits + 1 WHERE id=1");
    $query_update_visitors->execute();
}

//Récupérer pages
$query_pages = $bdd->prepare("SELECT * FROM pages");
$query_pages->execute();

//Récupérer galleries
$query_galleries = $bdd->prepare("SELECT * FROM `galleries` WHERE visible = 1");
$query_galleries->execute();

//Récupérer services
$query_services = $bdd->prepare("SELECT * FROM `services` WHERE visible = 1");
$query_services->execute();

$index = false;
if (isset($pageName)) {
    if ($pageName == "index.php") {
        $index = true;
    }
}
if (!isset($is_gallery)) {
    $is_gallery = false;
}

function active($page, $is_gallery)
{
    $page = preg_replace('/\s+/', '', $page);
    $url = str_replace('%20', '', $_SERVER['REQUEST_URI']);
    $url =  explode('/', $url);
    $url = end($url);
    if ($page == $url) {
        return 'active';
    } else if($page == "photos" && $is_gallery){
        return 'active';
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#333333" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="photographie, photographe, prestations services, paysage, photomontage, montage, vidéo, shooting, photo, gallerie" />
    <meta name="rights" content="© Maxime Brisson - Tous droits réservés" />
    <meta name="description" content="Catchin'Light - <?= $meta_description ?>" />
    <meta name="author" content="Florent SYX, Maxime Brisson" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- PRELOADING -->
    <link rel=preload src="fonts/CaviarDreams.ttf" as="font" type="font/ttf" crossorigin="anonymous">
    <!-- BOOSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link rel="stylesheet" href="css/gallery-grid.css">
    <!-- <?php if (isset($css_gallery)) {
                echo $css_gallery;
            } ?> -->
    <link rel="icon" href="icon/CL_icon.png">
    <link rel="stylesheet" href="css/main.css?1">
    <link rel="stylesheet" href="css/responsive.css?1">
    <link rel="stylesheet" href="css/cookiealert.css?1">
    <link rel="stylesheet" href="css/pulse.css">
    <link rel="stylesheet" href="css/carousel.css">
    <link rel="stylesheet" href="css/loader.css">
    <link rel="stylesheet" href="css/no_drag_select.css">
    <link rel="manifest" href="manifest.webmanifest">
    <link rel="apple-touch-icon" href="icon/CL_icon.png">

    <script src="js/aa5b198ca0.js" crossorigin="anonymous"></script>
    <script src="js/cookiealert.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>

    <title>Catchin'Light : <?= $titre_page ?></title>
</head>

<body oncontextmenu="return false">
    <div class="icons">
        <ol>
            <li><a href="https://www.instagram.com/maxime.brsn/" target="_blank" rel="noreferrer"><i class="fab fa-instagram"></i> @maxime.brsn</a></li>
            <li><a href="https://www.facebook.com/maxime.brisson.74/" target="_blank" rel="noreferrer"><i class="fab fa-facebook-square"></i> Maxime Brisson</a></li>
            <li><a href="https://www.youtube.com/channel/UCzYqRxe2fuowyvjZJyIyF5g/" target="_blank" rel="noreferrer"><i class="fab fa-youtube-square"></i> Catchin' Light</a></li>
        </ol>
    </div>
    <div class="content">
        <?php require_once "navbar.php"; ?>
        <div id="loadingDiv">
            <div id="preloader">
                <div id="loader"></div>
            </div>
            <img class="logo_loader" src="icon/CL_icon_pwa.png" alt="icon">
        </div>
        <div id="pageAwait">
            <div class="tz-gallery">
                <div class="row m-0">