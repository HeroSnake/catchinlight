<?php
$titre_page = "Modifier une gallerie";
require_once "core_BO.php";
require_once "php_functions.php";
$gallery_id = $_GET['cat'];
$query_images = $bdd->prepare("SELECT * FROM galleries WHERE id = $gallery_id LIMIT 1");
$query_images->execute();
$titre; $image; $visible; $upload_loc;

$result = $query_images->fetch(\PDO::FETCH_ASSOC);
$id = $result['id'];
$titre = $result['Nom'];
$url = strtolower(str_to_noaccent($result['titre']));
$image = $result['lien'];
$visible = $result['visible'];
$upload_loc = '../img/' . $result['nom_gallery'] . '/';

?>
<div class="container">
    <div class="row text-white">
        <div class="col-sm m-3">
            <form action="gallery_update.php" method="post">
                <h1>Edition gallerie : <a href="../<?=$url?>" target="_blank"><?=$titre?></a></h1>
                <input name="gallery_id" type="hidden" value="<?= $gallery_id ?>">
                <div class="form-group">
                    <label for="titre_page">Titre de la page :</label>
                    <input id="text_picker" onchange="update_text(value)" name="titre_page" class="form-control-sm" type="text" placeholder="Titre de la page" value="<?= $titre ?>" maxlength="15" required>
                </div>
                <div class="form-group">
                    <label for="visible">Page visible :</label>
                    <input name="visible" type="checkbox" <?php if($visible == 1) { ?>checked<?php }?>></input>
                </div>
                <input class="btn" id="buttonSubmit" value="Valider" type="submit"></input>
            </form>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="imageMenu">Image Menu :</label>
                    <input id="image_picker" onchange="update_picture()" type="file" name="imageMenu" accept="image/*" required></input>
                </div>
                <input class="btn" type="submit" value="Changer" name="submit">
            </form>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                <label for="filesToUpload">Upload images :</label>
                    <input type="file" name="filesToUpload[]" id="filesToUpload" multiple required>
                    <input type="hidden" value="<?=$upload_loc?>" name="location">
                    <input type="hidden" value="<?=$id?>" name="gallery_id">
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
</div>