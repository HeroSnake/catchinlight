<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once 'db_connection.php';
function active($page)
{
    $url_array =  explode('/', $_SERVER['REQUEST_URI']);
    $url = end($url_array);
    if ($page == $url) {
        return 'active'; //class name in css 
    }
}

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

//VISITEURS - avec Cookies
$query_nb_visitors = $bdd->prepare("SELECT visits FROM counter WHERE id=1");
$query_nb_visitors->execute();

$result = $query_nb_visitors->fetch(\PDO::FETCH_ASSOC);
$nb_visitors = $result['visits'];

$index = false;
if (isset($pageName)) {
    if ($pageName == "index.php") {
        $index = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#333333"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="keywords" content="photographie, photographe, prestations services, paysage, photomontage, montage, vidéo, shooting, photo, gallerie" />
    <meta name="rights" content="© Maxime Brisson - Tous droits réservés" />
    <meta name="description" content="Catchin'Light - <?= $meta_description ?>" />
    <meta name="author" content="Florent SYX, Maxime Brisson" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- PRELOADING -->
    <link rel=preload src="fonts/CaviarDreams.ttf" as="font" type="font/ttf" crossorigin="anonymous">
    <!-- BOOSTRAP -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">

    <link rel="stylesheet" href="css/gallery-grid.css">
    <!-- <?php if(isset($css_gallery)){  echo $css_gallery;  }?> -->

    <link rel="icon" href="icon/CL_icon.png">
    <link rel="stylesheet" href="css/main.css?1">
    <link rel="stylesheet" href="css/responsive.css?1">
    <link rel="stylesheet" href="css/cookiealert.css?1">
    <link rel="stylesheet" href="css/pulse.css">
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
        <nav class="navbar navbar-expand-lg sticky">
            <div class="btn navbar-toggler" role="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars h2"></i><p class="ml-2 d-inline h2">Catchin'Light</p>
            </div>
            <div class="collapse text-white navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a href="index" class="<?= active("index") ?>">Home</a></li>
                    <?php
                    while ($row = $query_pages->fetch(\PDO::FETCH_ASSOC)) {
                        if ($row['visible'] == 1) { ?>
                            <li class="dropdown-divider"></li>
                            <?php
                            if ($row['titre_lien'] == 'photos' && $meta_description == "Gallerie d'images") { ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle pointer" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $row['nom'] ?></a>
                                    <div class="dropdown-menu bg-dark">
                                        <?php
                                        while ($rowG = $query_galleries->fetch(\PDO::FETCH_ASSOC)) { ?>
                                            <a href="<?= $rowG['nom_gallery'] ?>" class="<?= active($rowG['nom_gallery']) ?>"><?= $rowG['Nom'] ?></a>
                                        <?php
                                        } ?>
                                    </div>
                                </li>
                            <?php
                            } else if($row['nom'] == "Services") { ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle <?= active($row['titre_lien']) ?> pointer" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $row['nom'] ?></a>
                                    <div class="dropdown-menu bg-dark">
                                        <?php
                                        while ($rowS = $query_services->fetch(\PDO::FETCH_ASSOC)) { ?>
                                            <a href="<?=$row['titre_lien']?>#section<?= $rowS['section'] ?>" ><?= $rowS['titre'] ?></a>
                                        <?php
                                        } ?>
                                    </div>
                                </li>
                            <?php
                            }
                            else { ?>
                                <li class="nav-item">
                                    <a href="<?= $row['titre_lien'] ?>" class="<?= active($row['titre_lien']) ?>"><?= $row['nom'] ?></a>
                                </li>
                            <?php
                            }
                        }
                    } ?>
                </ul>
            </div>
        </nav>
        <div id="loadingDiv">
            <div id="preloader">
                <div id="loader"></div>
            </div>
        </div>
        <div id="pageAwait">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php
                    $count = 0;
                    foreach (new DirectoryIterator(__DIR__ . '/img/header') as $file) {
                        if ($file->isFile()) {
                            list($width, $height) = getimagesize(__DIR__ . '/img/header/' . $file);
                            if ($width > 0) {
                                if ($count == 0) {
                                    echo '
                                    <li data-target="#carouselExampleIndicators" data-slide-to="' . $count . '" class="active"></li>';
                                } else {
                                    echo '
                                    <li data-target="#carouselExampleIndicators" data-slide-to="' . $count . '"></li>';
                                }
                                $count++;
                            }
                        }
                    }   ?>
                </ol>
                <div class="carousel-inner">
                    <?php
                    $count = 0;
                    foreach (new DirectoryIterator(__DIR__ . '/img/header') as $file) {
                        if ($file->isFile()) {
                            list($width, $height) = getimagesize(__DIR__ . '/img/header/' . $file);
                            if ($width > 0) {
                                $count++;
                                if ($count == 1) {
                                    echo '
                                <div class="carousel-item active" >
                                    <img class="d-block w-100" src="img/header/' . $file . '" alt="' . $count . '">
                                </div>';
                                } else {
                                    echo '
                                <div class="carousel-item" >
                                    <img class="d-block w-100" src="img/header/' . $file . '" alt="' . $count . '">
                                </div>';
                                }
                            }
                        }
                    } ?>
                </div>
            </div>
            <div class="tz-gallery">
                <div class="row m-0">