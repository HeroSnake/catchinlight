<?php
    require_once '../db_connection.php';
    require_once "php_functions.php";
    $titre_page = "Modifier une gallerie";
    $gallery_id = $_GET['cat'];
    $query_images = $bdd->prepare("SELECT * FROM galleries WHERE id = $gallery_id LIMIT 1");
    $query_images->execute();

    $result = $query_images->fetch(\PDO::FETCH_ASSOC);
    $gallery_name = $result['nom_gallery'];
    $titre = $result['Nom'];
    $url = strtolower(str_to_noaccent($result['titre']));
    $image = $result['lien'];
    $visible = $result['visible'];
    $upload_loc_menu = 'img/menu/';
    $upload_loc_gallery = '../img/' . $result['nom_gallery'] . '/';
    $colonnes = $result['columns'];
    $css_gallery = "<link rel='stylesheet' href='../css/grid_img_$colonnes.css'>";

    $sth = $bdd->prepare("SELECT * FROM image WHERE gallery_id = $gallery_id ORDER BY position");
    $sth->execute();
    $images = $sth->fetchAll(\PDO::FETCH_ASSOC);
    require_once "core_BO.php";
?>
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet"> 
<script src="https://code.jquery.com/jquery-1.10.2.js"></script> 
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 
<div class="container">
    <div class="row text-white">
        <div class="col-sm m-3">
            <form action="gallery_update.php" class="border rounded border-dark my-2 text-center" method="post">
                <h1>Edition gallerie : <a href="../<?=$url?>" target="_blank"><?=$titre?></a></h1>
                <input name="gallery_id" type="hidden" value="<?= $gallery_id ?>">
                <div class="form-group">
                    <label for="titre_page">Titre de la page :</label>
                    <input id="text_picker" onchange="update_text(value)" name="titre_page" class="form-control-sm" type="text" placeholder="Titre de la page" value="<?= $titre ?>" maxlength="15" required>
                </div>
                <div class="form-group">
                    <label for="colonnes">Nombre colonnes :</label>
                    <input id="colonne" name="colonnes" type="number" value="<?=$colonnes?>" min="2" max="5" required></input>
                </div>
                <div class="form-group">
                    <label for="visible">Page visible :</label>
                    <input name="visible" type="checkbox" <?php if($visible == 1) { ?>checked<?php }?>></input>
                </div>
                <input class="btn" id="buttonSubmit" value="Valider" type="submit"></input>
            </form>
            <form class="border rounded border-dark my-2 text-center" action="upload.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="imageMenu">Image Menu :</label>
                    <input id="image_picker" type="file" name="imageMenu" accept="image/*" required></input>
                    <input type="hidden" value="<?=$upload_loc_menu?>" name="location">
                    <input type="hidden" value="<?=$gallery_id?>" name="gallery_id">
                </div>
                <input class="btn" type="submit" value="Changer" name="submit">
            </form>
            <form class="border rounded border-dark my-2 text-center" action="upload.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="filesToUpload">Upload images :</label>
                    <input type="file" name="filesToUpload[]" id="filesToUpload" multiple required>
                    <input type="hidden" value="<?=$upload_loc_gallery?>" name="location">
                    <input type="hidden" value="<?=$gallery_id?>" name="gallery_id">
                </div>
                <input class="btn" type="submit" value="Uploader" name="submit">
            </form>
        </div>
        <div class="col-sm">
            <div class="col-md-8 col-sm-12 px-1 mx-auto my-5">
                <div class="menu hovereffect">
                    <img class="img-responsive" id="preview_img" src="../<?= $image ?>" alt="img">
                    <a class="overlay" href="">
                        <div class="align-items-center info">
                            <h2  class="p-0 my-auto textMenu"><?= strtoupper($titre); ?></h2>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="border rounded border-dark my-2 text-center">
        <button name="<?=$gallery_id?>" id="updatePictures" type="button" class="btn btn-primary">Valider</button>
        <section id="photos" class="droppable">
            <?php
            foreach($images as $image){
                $link = "../img/$gallery_name/".$image["id"] . "." . $image["extension"];?>
                <div class="overflow-hidden">
                    <div class="supp-icon" id="<?=$image["id"]?>">
                        <i class="fas fa-trash-alt text-danger"></i>
                    </div>
                    <div id="<?=$image["id"]?>" class="draggable">
                        <div class="lightbox">
                            <img src="<?=$link?>" alt="img_gallery">
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>
    </div>
<div>