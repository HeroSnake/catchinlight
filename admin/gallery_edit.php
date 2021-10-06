<?php
    $titre_page = "Modifier une gallerie";
    $gallery_id = $_GET['cat'];
    require_once "core_BO.php";
    $query_images = Database::connect()->prepare("SELECT * FROM galleries WHERE id = $gallery_id LIMIT 1");
    $query_images->execute();

    $result = $query_images->fetch(\PDO::FETCH_ASSOC);
    $titre = $result['Nom'];
    $url = '#gallery&id'.strtolower(str_to_noaccent($result['id']));
    $image = $result['lien'];
    $visible = $result['visible'];
    $upload_loc_menu = 'img/menu/';
    $upload_loc_gallery = '../img/gallery/';
    $colonnes = $result['columns'];
    $desc = $result['description'];
    $sub_cat = $result['sub_cat'];
    $colonne = floor(12 / $colonnes);

    $sth = Database::connect()->prepare("SELECT * FROM image WHERE gallery_id = $gallery_id ORDER BY position");
    $sth->execute();
    $images = $sth->fetchAll(\PDO::FETCH_ASSOC);
?>
<script src="../js/update_pictures.js"></script>
<div class="container">
    <div class="row text-white text-center">
        <div class="col-sm m-3">
            <form action="../controllers/gallery_update.php" class="border rounded border-dark my-2" method="post">
                <h1>Edition gallerie : <a href="../<?=$url?>" target="_blank"><?=$titre?></a></h1>
                <input name="gallery_id" type="hidden" value="<?= $gallery_id ?>">
                <div class="form-group">
                    <label for="titre_page">Titre de la page :</label>
                    <input id="text_picker" name="titre_page" class="form-control-sm" type="text" placeholder="Titre de la page" value="<?= $titre ?>" maxlength="15" required>
                </div>
                <div class="form-group">
                    <label for="colonnes">Nombre colonnes :</label>
                    <input id="colonne" name="colonnes" type="number" value="<?=$colonnes?>" min="1" max="4" required></input>
                </div>
                <div class="form-group">
                    <label for="visible">Page visible :</label>
                    <input name="visible" type="checkbox" <?php if($visible == 1) { ?>checked<?php }?>></input>
                </div>
                <div class="form-group">
                    <label for="subCat">Sous-catégorie</label>
                    <input name="subCat" type="checkbox" <?php if($sub_cat == 1) { ?>checked<?php }?>></input>
                </div>
                <div class="form-group">
                    <textarea name="description" id="description" placeholder="Description de la gallerie" cols="30"><?=$desc?></textarea>
                </div>
                <input class="btn" id="buttonSubmit" value="Valider" type="submit"></input>
            </form>
            <form class="border rounded border-dark my-2" action="../controllers/upload_update_gallery.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="imageMenu">Image Menu :</label>
                    <input id="image_picker" type="file" name="imageMenu" accept="image/*" required></input>
                    <input type="hidden" value="<?=$upload_loc_menu?>" name="location">
                    <input type="hidden" value="<?=$gallery_id?>" name="gallery_id">
                    <input type="hidden" value="<?=$titre?>" name="gallery_title">
                </div>
                <input class="btn" type="submit" value="Changer" name="submit">
            </form>
            <form class="border rounded border-dark my-2" action="../controllers/upload_update_gallery.php" method="post" enctype="multipart/form-data">
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
                <a class="profile-card-2">
                    <img src="../<?=$image?>" class="img img-responsive" style="height: 500px;width: 500px;">
                    <div class="profile-name centerImage"><?=strtoupper($titre)?></div>
                    <div class="profile-username"><?=$desc?></div>
                </a>
            </div>
        </div>
    </div>
    <div class="my-2 text-center">
        <button name="<?=$gallery_id?>" id="updatePictures" type="button" class="btn btn-primary my-2">Valider l'ordre</button>
        <section id="photos" class="droppable grid">
            <?php
            foreach($images as $image){
                $link = "../img/gallery/thumbnails/".$image["id"] . "." . $image["extension"];?>
                <div class="col-sm-6 col-lg-<?=$colonne?> p-0 grid-item" id="<?=$image["id"]?>">
                    <div class="supp-icon" id="<?=$image["id"]?>">
                        <i class="fas fa-trash-alt text-danger"></i>
                    </div>
                    <div id="<?=$image["id"]?>" class="draggable">
                        <div>
                            <img src="<?=$link?>" alt="img_gallery">
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>
    </div>
    <?php require_once 'confirmation_modal.php';?>
<div>
<script src="../js/packery-docs.min.js"></script>