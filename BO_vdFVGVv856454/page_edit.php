<?php
$titre_page = "Modifier une page";
require_once "core_BO.php";
require_once "php_functions.php";
$page_id = $_GET['cat'];
$query_images = $bdd->prepare("SELECT * FROM pages WHERE id = $page_id");
$query_images->execute();
$titre; $lien; $image; $visible;

while ($row = $query_images->fetch(PDO::FETCH_ASSOC)) {
    $titre = $row['nom'];
    $lien = $row['titre_lien'];
    $image = $row['image'];
    $visible = $row['visible'];
}
?>
<form class="text-center text-white" action="page_update.php" method="post">
    <input name="page_id" type="hidden" value="<?= $page_id ?>">
    <div class="row">
        <input class="mx-auto" id="text_picker" onchange="update_text('P')" name="titre_page" type="text" placeholder="Titre de la page" value="<?= $titre ?>" maxlength="15" required></input>
        <input class="mx-auto" name="lien_page" type="text" placeholder="Lien de la page" value="<?= $lien ?>" maxlength="15" required></input>
    </div>
    <input id="image_picker" onchange="update_picture('P')" type="file" name="image" accept="image/*"></input>
    <input name="visible" type="checkbox" <?php if($visible == 1) { ?>checked<?php }?>>Visible</input>
    <input class="w-10" name="ordre" type="number">Ordre</input>
    <input id="buttonSubmit" type="submit"></input>
</form>
<div class="col-md-11 mx-auto p-0 mb-4 section_main">      
    <a style="height: 300px;width: 100%;">
        <div class="hovereffect1 center-block">
            <img id="preview_img" class="img-responsive" src="../<?= $image ?>" alt="">
            <h2 class="preview_text section_title m-0 w-100"><?= strtoupper($titre); ?></h2>
            <div class="overlay align-items-center">
                <h2 class="preview_text textMenu my-auto"><?= strtoupper($titre); ?></h2>
            </div>
        </div>
    </a>
</div>