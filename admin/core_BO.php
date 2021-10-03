<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ob_start();
require_once '../controllers/db_connection.php';
require_once '../controllers/session.php';
require_once "../controllers/php_functions.php";
function active($current_page)
{
    $url_array =  explode('/', $_SERVER['REQUEST_URI']);
    $url = end($url_array);
    if ($current_page == $url) {
        echo 'active'; //class name in css 
    }
}

//VISITEURS - avec Cookies
$query_nb_visitors = $bdd->prepare("SELECT visits FROM counter WHERE id=1");
$query_nb_visitors->execute();
$result = $query_nb_visitors->fetch(\PDO::FETCH_ASSOC);
$nb_visitors = $result['visits'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
    <script src="https://unpkg.com/draggabilly@2/dist/draggabilly.pkgd.min.js"></script>

    <!-- BOOSTRAP -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">

    <link rel="icon" href="../icon/CL_icon.png">
    <link rel="stylesheet" href="../css/back_office.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="stylesheet" href="../css/gallery-grid.css">

    <script src="../js/fontawesome.js" crossorigin="anonymous"></script>
    <script src="../js/update_gallery.js" crossorigin="anonymous"></script>

    <title>CatchinLight BO : <?= $titre_page ?></title>
</head>

<body>
    <div class="content">
        <ul class="navbar navbar-expand-lg">
            <li><div class="<?php active('index'); ?>"><a href="../">Home</a></div></li>
            <li><div class="<?php active('gallery_creation'); ?> <?php active('gallery_liste'); ?>"><a href="gallery_liste">Galleries</a></div></li>
            <li><div class="<?= active('page_creation'); ?> <?= active('page_liste'); ?>"><a href="page_liste">Pages</a></div></li>
            <?php if ($logged === false) { ?>
                <li><div class="<?php active('login'); ?>"><a href="login">Login</a></div></li>
            <?php } else { ?>
                <li><div><a href="logout">Logout</a></div></li>
            <?php } ?>
            <span class="px-3 text-light">Visiteurs : <?= $nb_visitors ?></span>
        </ul>