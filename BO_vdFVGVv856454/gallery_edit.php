<?php
$titre_page = "Modifier une gallerie";
require_once "core_BO.php";
require_once "php_functions.php";
$categorie_id = $_GET['cat'];
$query_images = $bdd->prepare("SELECT * FROM categorie WHERE id = $categorie_id");
$query_images->execute();
$titre; $image; $visible; $upload_loc;

while ($row = $query_images->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $titre = $row['Nom'];
    $image = $row['lien'];
    $visible = $row['visible'];
    $upload_loc = '../img/' . $row['nom_categorie'] . '/';
}
?>
<form class="text-center text-white" action="gallery_update.php" method="post">
<h1>Edition gallerie : <?=$titre?></h1>
    <input name="category_id" type="hidden" value="<?= $categorie_id ?>">
    <input id="text_picker" onchange="update_text(value)" name="titre_page" type="text" placeholder="Titre de la page" value="<?= $titre ?>" maxlength="15" required>
    <input id="image_picker" onchange="update_picture()" type="file" name="image" accept="image/*"></input>
    <input name="visible" type="checkbox" <?php if($visible == 1) { ?>checked<?php }?>>Visible</input>
    <input id="buttonSubmit" type="submit"></input>
</form>
<form class="text-center text-white" action="upload.php" method="post" enctype="multipart/form-data">
    <span>Upload images :<span>
    <input type="file" name="filesToUpload[]" id="filesToUpload" multiple>
    <input type="submit" value="Upload Image" name="submit">
    <input type="hidden" value="<?=$upload_loc?>" name="location">
    <input type="hidden" value="<?=$id?>" name="category_id">
</form>
<div class="col-md-4 col-sm-6 px-1 mx-auto">
    <div class="menu hovereffect">
        <img class="img-responsive" id="preview_img" src="../<?= $image ?>" alt="img">
        <a class="overlay" href="">
            <div class="align-items-center info">
                <h2 id="preview_text" class="p-0 my-auto textMenu"><?= strtoupper($titre); ?></h2>
            </div>
        </a>
    </div>
</div>