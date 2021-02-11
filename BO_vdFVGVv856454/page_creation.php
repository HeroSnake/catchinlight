<?php
$titre_page = "Créer un page";
require_once "core_BO.php";
?>
<form class="text-center text-white" action="page_create.php" method="post">
    <input id="text_picker" onchange="update_text(value)" name="titre_page" type="text" placeholder="Titre de la page" maxlength="15" required></input>
    <input id="text_picker" name="meta_desc" type="text" placeholder="Méta description" maxlength="50" required></input>
    <input name="lien_page" type="text" placeholder="Lien de la page" maxlength="15" required></input>
    <input id="image_picker" onchange="update_picture('P')" type="file" name="image" accept="image/*" required>
    <input name="visible" type="checkbox" checked>Visible</input>
    <input id="buttonSubmit" type="submit"></input>
</form>
<div class="col-md-11 mx-auto p-0 mb-4 section_main">           
    <a style="height: 300px;width: 100%;">
        <div class="hovereffect1 center-block">
            <img id="preview_img" class="img-responsive" src="" alt="">
            <h2 class="preview_text section_title m-0 w-100"></h2>
            <div class="overlay align-items-center">
                <h2 class="preview_text textMenu my-auto"></h2>
            </div>
        </div>
    </a>
</div>