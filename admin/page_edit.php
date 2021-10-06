<?php
$titre_page = "Modifier une page";
require_once "core_BO.php";
$page_id = $_GET['cat'];
$upload_loc_accueil = 'img/accueil/containers/';
$query_images = Database::connect()->prepare("SELECT * FROM pages WHERE id = $page_id");
$query_images->execute();
$result = $query_images->fetch(\PDO::FETCH_ASSOC);
$titre; $lien; $image; $visible;

$titre = $result['nom'];
$lien = $result['titre_lien'];
$image = $result['image'];
$visible = $result['visible'];
?>
        <div class="col-md-5 mx-auto text-white text-center">
            <form class="border rounded border-dark my-2" action="../controllers/page_update.php" method="post">
                <h1>Edition Page : <a href="../<?=$lien?>" target="_blank"><?=$titre?></a></h1>
                <input name="page_id" type="hidden" value="<?= $page_id ?>">
                <div class="form-group">
                    <label for="titre_page">Titre de la page :</label>
                    <input id="text_picker" name="titre_page" type="text" placeholder="Titre de la page" value="<?= $titre ?>" maxlength="15" required></input>
                </div>
                <!-- <div class="form-group">
                    <label for="lien_page">Lien de la page :</label>
                    <input name="lien_page" type="text" placeholder="Lien de la page" value="<?= $lien ?>" maxlength="15" required></input>
                </div> -->
                <div class="form-group custom-control custom-checkbox">
                    <input type="checkbox" id="visible" name="visible" class="custom-control-input" <?php if($visible == 1) { ?>checked<?php }?>></input>
                    <label class="custom-control-label" for="visible">Page visible</label>
                </div>
                <input id="buttonSubmit" type="submit" name="submit"></input>
            </form>
            <form class="border rounded border-dark my-2" action="../controllers/upload_update_page.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="image">Image Accueil :</label>
                    <input id="image_picker" type="file" name="image" accept="image/*" required></input>
                    <input type="hidden" value="<?=$upload_loc_accueil?>" name="location">
                    <input name="page_id" type="hidden" value="<?= $page_id ?>">
                </div>
                <input class="btn" type="submit" value="Changer" name="submit">
            </form>
        <div>
    </div>
</div>
<div class="row">
    <div class="col-md-11 mx-auto p-0 mb-4 section_main">      
        <a style="height: 100%; width: 100%;">
            <div class="hovereffect1 center-block">
                <img id="preview_img" class="img-responsive" src="../<?= $image ?>" alt="">
                <h2 class="preview_text section_title m-0 w-100"><?= strtoupper($titre); ?></h2>
                <div class="overlay align-items-center">
                    <h2 class="preview_text textMenu my-auto"><?= strtoupper($titre); ?></h2>
                </div>
            </div>
        </a>
    </div>
</div>
